<?php

namespace App\Filament\Resources\NewStudentResource\Pages;

use App\Filament\Resources\NewStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewStudent extends EditRecord
{
    protected static string $resource = NewStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
