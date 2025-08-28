<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JuriResource\Pages;
use App\Models\Juri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Models\AspekPenilaian;


class JuriResource extends Resource
{
    protected static ?string $model = Juri::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?int $navigationSort = 5;
    protected static ?string $pluralModelLabel = 'Juri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->minLength(8)
                    ->dehydrated(fn($state) => filled($state)),

                // Forms\Components\TextInput::make('password_confirmation')
                //     ->password()
                //     ->dehydrated(false)
                //     ->label('Konfirmasi Password'),

                Forms\Components\Toggle::make('is_aktif')
                    ->label('Aktif')
                    ->default(true),

                // 2. Tambahkan komponen CheckboxList di sini
                CheckboxList::make('aspekPenilaians')
                    ->relationship(
                        name: 'aspekPenilaians',
                        // Kita gunakan 'nama' (kolom asli) untuk titleAttribute agar query awal valid
                        titleAttribute: 'nama',
                        // Modifikasi query untuk eager load relasi cabangLomba agar efisien
                        modifyQueryUsing: fn(Builder $query) => $query->with('cabangLomba')->orderBy('id_cabang_lomba')->orderBy('nama')
                    )
                    // INI BAGIAN KUNCINYA: Buat label secara manual untuk setiap record
                    ->getOptionLabelFromRecordUsing(fn(AspekPenilaian $record) => optional($record->cabangLomba)->nama . " | {$record->nama}")
                    ->label('Tugaskan Aspek Penilaian')
                    ->bulkToggleable()
                    ->columns(2)
                    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        // ... (Tidak ada perubahan di sini, kode Anda sudah bagus)
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
                Tables\Columns\ToggleColumn::make('is_aktif')
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
            //
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
