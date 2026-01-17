<?php

namespace App\Enums;

enum RequestStatus: int
{
    case Created = 0;
    case InProgress = 1;
    case Done = 2;

    public function label(): string
    {
        return match ($this) {
            self::Created    => 'Создан',
            self::InProgress => 'В работе',
            self::Done       => 'Обработан',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::Created    => 'create',
            self::InProgress => 'in-progress',
            self::Done       => 'done',
        };
    }

    public function statusIcon(): string
    {
        return match ($this) {
            self::Created    => 'new-doc',
            self::InProgress => 'cogwheel',
            self::Done       => 'check-circle',
        };
    }
}
