<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use App\Models\User;
use Filament\Tables;
use App\Models\Booking;
use Barryvdh\DomPDF\PDF;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\BookingResource\Pages;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationGroup = 'Hotel Management';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Select::make('user_id')->label('Pelanggan')->options(User::pluck('name', 'id'))->searchable()->required(),
            Select::make('room_id')->label('Kamar')->options(Room::pluck('room_number', 'id'))->searchable()->required(),
            DatePicker::make('check_in_date')->label('Tanggal Check-in')->required(),
            DatePicker::make('check_out_date')->label('Tanggal Check-out')->required(),
            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Menunggu',
                    'confirmed' => 'Dikonfirmasi',
                    'cancelled' => 'Dibatalkan',
                ])
                ->default('pending')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Pelanggan'),
                TextColumn::make('room.room_number')->label('Kamar'),
                TextColumn::make('check_in_date')->label('Check-in'),
                TextColumn::make('check_out_date')->label('Check-out'),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record) {
                    $record->delete();
                }),
            ])
            ->bulkActions([
                BulkAction::make('download_pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-text')
                    ->action(function (Collection $records) {
                        $pdf = app('dompdf.wrapper');
                        $pdf->loadView('pdf.bookings', [
                            'records' => $records,
                        ]);

                        return response()->streamDownload(fn() => print $pdf->output(), 'bookings.pdf');
                    })
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
