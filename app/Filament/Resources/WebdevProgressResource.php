<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebdevProgressResource\Pages;
use App\Models\WebdevProgress;
use App\Models\Tim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ToggleColumn;

class WebdevProgressResource extends Resource
{
    protected static ?string $model = WebdevProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Perlombaan';
    protected static ?int $navigationSort = 2;
    protected static ?string $pluralModelLabel = 'Web Dev';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tim_id')
                    ->label('Tim')
                    ->relationship('tim', 'nama')
                    ->options(function () {
                        return Tim::whereHas('cabangLomba', function ($query) {
                            $query->where('nama', 'Web Development');
                        })->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\Toggle::make('web_app_uploaded')
                    ->label('Upload Web App')
                    ->inline(false),

                Forms\Components\Toggle::make('ppt_uploaded')
                    ->label('Upload PPT')
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tim.nama')
                    ->label('Nama Tim')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tim.instansi')
                    ->label('Instansi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('web_app_uploaded')
                    ->label('Web App')
                    ->boolean() // otomatis cek true/false
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'success' => true,  // hijau kalau true
                        'danger' => false,  // merah kalau false
                    ])
                    ->action(fn($record) => $record->update([
                        'web_app_uploaded' => ! $record->web_app_uploaded,
                    ])),

                Tables\Columns\IconColumn::make('ppt_uploaded')
                    ->label('PPT')
                    ->boolean() // otomatis cek true/false
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'success' => true,  // hijau kalau true
                        'danger' => false,  // merah kalau false
                    ])
                    ->action(fn($record) => $record->update([
                        'ppt_uploaded' => ! $record->ppt_uploaded,
                    ])),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebdevProgress::route('/'),
            'create' => Pages\CreateWebdevProgress::route('/create'),
            'edit' => Pages\EditWebdevProgress::route('/{record}/edit'),
        ];
    }
}
