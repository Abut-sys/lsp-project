<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    // Setelah edit, arahkan kembali ke halaman index resource.
    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('index');
    }
}
