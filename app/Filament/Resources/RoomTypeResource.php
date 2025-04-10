<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\RoomType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\RoomTypeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoomTypeResource\RelationManagers;

class RoomTypeResource extends Resource
{
    protected static ?string $model = RoomType::class;
    protected static ?string $navigationGroup = 'Room Management';


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')->required()->unique(ignoreRecord: true),

            CheckboxList::make('facilities')
                ->label('Facilities')
                ->options([
                    'wifi' => 'Wi-Fi',
                    'ac' => 'Air Conditioner',
                    'tv' => 'Televisi',
                    'pool' => 'Kolam Renang',
                    'gym' => 'Gym',
                    'restaurant' => 'Restoran',
                    'Shower' => 'Bathroom with Shower',
                    'Breakfast' => 'Breakfast',
                ])
                ->columns(2) // Agar rapi dalam 2 kolom
                ->required(),
        ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('facilities')
                ->label('Facilities')
                ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state): $state)
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'wifi' => 'success',
                    'ac' => 'info',
                    'tv' => 'warning',
                    'pool' => 'danger',
                    'gym' => 'success',
                    'restaurant' => 'info',
                    'Shower' => 'primary',
                    'Breakfast' => 'info',
                    default => 'secondary',
                }),
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
            'index' => Pages\ListRoomTypes::route('/'),
            'create' => Pages\CreateRoomType::route('/create'),
            'edit' => Pages\EditRoomType::route('/{record}/edit'),
        ];
    }
}
