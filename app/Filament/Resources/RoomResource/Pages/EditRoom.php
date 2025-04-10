<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getRedirectUrl(): ?string
    {
        return RoomResource::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika kamar tidak tersedia, pastikan is_booked = false
        if (!$data['is_available']) {
            $data['is_booked'] = false;
        }

        return $data;
    }
}
