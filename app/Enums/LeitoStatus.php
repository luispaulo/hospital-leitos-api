<?php

namespace App\Enums;

enum LeitoStatus: string
{
    case Livre     = 'livre';
    case Ocupado   = 'ocupado';

    public function label(): string
    {
        return match($this) {
            self::Livre   => 'Livre',
            self::Ocupado => 'Ocupado',
        };
    }
}
