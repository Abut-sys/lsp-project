<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use App\Models\User;
use Filament\Tables;
use App\Models\Booking;
use Barryvdh\DomPDF\PDF;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
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
use Filament\Forms\Components\TextInput;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationGroup = 'Hotel Management';
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

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
            TextInput::make('total_price')
                ->label('Total Harga')
                ->numeric()
                ->prefix('Rp')
                ->disabled()
                ->dehydrated()
                ->afterStateUpdated(fn ($state, callable $set, $get) =>
                    $set('total_price', Room::find($get('room_id'))->price * max(1, (strtotime($get('check_out_date')) - strtotime($get('check_in_date'))) / 86400))
                ),
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
                TextColumn::make('total_price')->label('Total Harga')->money('IDR'),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->filters([
                Filter::make('check_in_date')
                    ->form([
                        DatePicker::make('check_in_from')->label('Dari Tanggal'),
                        DatePicker::make('check_in_to')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['check_in_from'] ?? null, fn ($q) => $q->where('check_in_date', '>=', $data['check_in_from']))
                            ->when($data['check_in_to'] ?? null, fn ($q) => $q->where('check_in_date', '<=', $data['check_in_to']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()->before(function ($record) {
                    $record->delete();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
                ]),
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
