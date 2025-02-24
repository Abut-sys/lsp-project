<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use App\Models\RoomType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\RoomResource\Pages;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;
    protected static ?string $navigationGroup = 'Hotel Management';
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('room_type_id')
                    ->label('Tipe Kamar')
                    ->options(fn () => RoomType::pluck('name', 'id'))
                    ->required(),
                TextInput::make('room_number')
                    ->label('Nomor Kamar')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('capacity')
                    ->label('Kapasitas')
                    ->numeric()
                    ->default(2),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->rule('integer')
                    ->prefix('Rp')
                    ->afterStateHydrated(fn (TextInput $component, $state) => $component->state((int) $state)),
                MarkdownEditor::make('description')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Toggle::make('is_available')
                    ->label('Tersedia')
                    ->default(true),
                Toggle::make('is_booked')
                    ->label('Dipesan')
                    ->default(false),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('roomType.name')->label('Tipe Kamar')->sortable(),
                TextColumn::make('room_number')->label('Nomor Kamar')->sortable(),
                TextColumn::make('capacity')->label('Kapasitas')->sortable(),
                TextColumn::make('price')->label('Harga')->money('IDR'),
                BadgeColumn::make('is_available')
                    ->label('Status')
                    ->colors([
                        'success' => fn ($state) => $state,
                        'danger' => fn ($state) => !$state,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Tersedia' : 'Tidak Tersedia'),
                BadgeColumn::make('is_booked')
                    ->label('Dipesan')
                    ->colors([
                        'warning' => fn ($state) => $state,
                        'success' => fn ($state) => !$state,
                    ])
                    ->formatStateUsing(fn ($record) => $record->is_booked ? 'Sudah Dipesan' : 'Belum Dipesan'),


            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
