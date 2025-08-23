<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JuriResource\Pages;
use App\Filament\Resources\JuriResource\RelationManagers;
use App\Models\Juri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JuriResource extends Resource
{
    protected static ?string $model = Juri::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 4;

    protected static ?string $pluralModelLabel = 'Juri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\TextInput::make('instansi')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\TextInput::make('no_hp')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->dehydrated(fn($state) => filled($state)) // Hanya simpan jika diisi
                    ->dehydrateStateUsing(fn($state) => \Illuminate\Support\Facades\Hash::make($state)),
                Forms\Components\Toggle::make('is_aktif')
                    ->label('Aktif')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('instansi')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\IconColumn::make('is_aktif')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_aktif')
                    ->label('Status Aktif'),
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
            // Tambahkan relasi jika ada, misalnya RelationManagers
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJuris::route('/'),
            'create' => Pages\CreateJuri::route('/create'),
            'edit' => Pages\EditJuri::route('/{record}/edit'),
        ];
    }
}
