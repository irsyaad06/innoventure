<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarSeminarResource\Pages;
use App\Filament\Resources\DaftarSeminarResource\RelationManagers;
use App\Models\DaftarSeminar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DaftarSeminarResource extends Resource
{
    protected static ?string $model = DaftarSeminar::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Seminar';

    protected static ?string $navigationLabel = 'Daftar Seminars';

    protected static ?string $modelLabel = 'Daftar Seminar';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(DaftarSeminar::class, 'email', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('no_undian')
                    ->disabled()
                    ->dehydrated(false)
                    ->default('Generated automatically')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_absen')
                    ->disabled()
                    ->dehydrated(false)
                    ->default('Generated automatically')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instansi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_undian')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_absen')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('instansi')
                    ->form([
                        Forms\Components\TextInput::make('instansi')
                            ->label('Instansi'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['instansi'], fn(Builder $query, $instansi) => $query->where('instansi', 'like', "%{$instansi}%"));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan RelationManagers jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarSeminars::route('/'),
            'create' => Pages\CreateDaftarSeminar::route('/create'),
            'edit' => Pages\EditDaftarSeminar::route('/{record}/edit'),
        ];
    }
}
