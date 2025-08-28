<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SayembaraProgressResource\Pages;
use App\Filament\Resources\SayembaraProgressResource\RelationManagers;
use App\Models\SayembaraProgress;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Tim;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class SayembaraProgressResource extends Resource
{
    protected static ?string $model = SayembaraProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationGroup = 'Perlombaan';

    protected static ?int $navigationSort = 10;

    protected static ?string $pluralModelLabel = 'Sayembara Logo';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tim_id')
                    ->label('Tim')
                    ->relationship('tim', 'nama')
                    ->options(function () {
                        return Tim::whereHas('cabangLomba', function ($query) {
                            $query->where('nama', 'Sayembara Logo');
                        })->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('angkatan')
                    ->required()
                    ->numeric()
                    ->maxLength(4),
                Forms\Components\Section::make('Link Pengumpulan Karya')
                    ->description('Pastikan link dapat diakses oleh publik.')
                    ->schema([
                        Forms\Components\TextInput::make('link_deskripsi_logo')
                            ->label('Link File Deskripsi Logo (PDF)')
                            ->required()
                            ->url()
                            ->maxLength(2048)
                            ->placeholder('https://deskripsi.com'),
                        Forms\Components\TextInput::make('link_file_logo')
                            ->label('Link File Logo (PNG/JPG)')
                            ->required()
                            ->url()
                            ->maxLength(2048)
                            ->placeholder('https://filelogo.com'),
                        Forms\Components\TextInput::make('link_gdrive_logo')
                            ->label('Link Google Drive Folder Logo')
                            ->required()
                            ->url()
                            ->maxLength(2048)
                            ->placeholder('https://googledrive.com'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tim.nama')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('angkatan')
                    ->sortable(),
                IconColumn::make('link_deskripsi_logo')
                    ->label('Deskripsi Logo')
                    ->boolean()
                    ->trueIcon('heroicon-o-play-circle')
                    ->falseIcon('heroicon-o-x-mark')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->url(fn($record) => $record->link_deskripsi_logo)
                    ->openUrlInNewTab(),

                IconColumn::make('link_file_logo')
                    ->label('File Logo')
                    ->boolean()
                    ->trueIcon('heroicon-o-globe-alt')
                    ->falseIcon('heroicon-o-x-mark')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->url(fn($record) => $record->link_file_logo)
                    ->openUrlInNewTab(),

                IconColumn::make('link_gdrive_logo')
                    ->label('Drive Logo')
                    ->boolean()
                    ->trueIcon('heroicon-o-presentation-chart-line')
                    ->falseIcon('heroicon-o-x-mark')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->url(fn($record) => $record->link_gdrive_logo)
                    // ->url(fn($record) => $record->ppt ? Storage::url($record->ppt) : null)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSayembaraProgress::route('/'),
            'create' => Pages\CreateSayembaraProgress::route('/create'),
            'edit' => Pages\EditSayembaraProgress::route('/{record}/edit'),
        ];
    }
}
