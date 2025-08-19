<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MlMatchResource\Pages;
use App\Filament\Resources\MlMatchResource\RelationManagers;
use App\Models\MlMatch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MlMatchResource extends Resource
{
    protected static ?string $model = MlMatch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('round')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tim1_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tim2_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('best_of')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('tim1_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('tim2_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('winner_id')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time'),
                Forms\Components\DateTimePicker::make('end_time'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('round')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tim1_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tim2_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('best_of')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tim1_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tim2_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('winner_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMlMatches::route('/'),
            'create' => Pages\CreateMlMatch::route('/create'),
            'edit' => Pages\EditMlMatch::route('/{record}/edit'),
        ];
    }
}
