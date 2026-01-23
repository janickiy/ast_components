<?php

namespace App\Enums;

enum FeedbackStatus: int
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

    public function cssColor(): string
    {
        return match ($this) {
            self::Created    => 'text-warning',
            self::InProgress => 'text-primary',
            self::Done       => 'text-success',
        };
    }
}
