<?php

namespace App\Filament\Resources\NewStudentResource\Pages;

use App\Filament\Resources\NewStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNewStudent extends CreateRecord
{
    protected static string $resource = NewStudentResource::class;
}
