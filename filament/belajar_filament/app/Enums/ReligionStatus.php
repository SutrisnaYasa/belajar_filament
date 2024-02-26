<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
 
enum ReligionStatus: string implements HasLabel
{
    case Hindu = 'Hindu';
    case Islam = 'Islam';
    case Budha = 'Budha';
    case Katolik = 'Katolik';
    
    public function getLabel(): ?string
    {
        return $this->name;
        
        // or
    
        return match ($this) {
            self::Hindu => 'Hindu',
            self::Islam => 'Islam',
            self::Budha => 'Budha',
            self::Katolik => 'Katolik',
        };
    }
}
