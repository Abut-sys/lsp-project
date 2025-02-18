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
            TextInput::make('name')->required()->unique(),
            Forms\Components\Select::make('facility_id')->label('Facility')->relationship('facility', 'name')->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('facility.name')
                ->label('Facility')
                ->sortable()
                ->searchable(),
            Tables\Columns\ViewColumn::make('facility.images')
                ->label('Images')
                ->view('filament.resources.room-type-resource.columns.facility-images'),
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
