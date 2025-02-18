<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Setelah create, arahkan kembali ke halaman index resource.
    protected function getRedirectUrl(): string
    {
        return UserResource::getUrl('index');
    }
}
