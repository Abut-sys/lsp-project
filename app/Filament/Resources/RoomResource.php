<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use App\Models\RoomType;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;
    protected static ?string $navigationGroup = 'Hotel Management';
    protected static ?string $navigationIcon = 'heroicon-o-home';

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
                    ->unique(),
                TextInput::make('capacity')
                    ->label('Kapasitas')
                    ->numeric()
                    ->default(2),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp'),
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
                BooleanColumn::make('is_available')->label('Tersedia'),
                BooleanColumn::make('is_booked')->label('Dipesan'),
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
