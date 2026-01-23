<?php

namespace App\Enums;

enum ComplaintStatus: int
{
    case Created = 0;
    case InProgress = 1;
    case Agreement = 2;
    case Expertise = 3;
    case Denied = 4;
    case Approved = 5;
    case Return = 6;
    case Closed = 7;
    case Checked = 8;

    public function label(): string
    {
        return match ($this) {
            self::Created    => 'Создан',
            self::InProgress => 'В обработке',
            self::Agreement  => 'Согласование',
            self::Expertise  => 'Отправлено на экспертизу',
            self::Denied     => 'Отказано',
            self::Approved   => 'Одобрено',
            self::Return     => 'К возврату',
            self::Closed     => 'Закрыто',
            self::Checked    => 'Проверено складом',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::Created    => 'create',
            self::InProgress => 'in-progress',
            self::Agreement  => 'agreement',
            self::Expertise  => 'expertise',
            self::Denied     => 'denied',
            self::Approved   => 'done',
            self::Return     => 'return',
            self::Closed     => 'close',
            self::Checked    => 'checked',
        };
    }

    public function cssColor(): string
    {
        return match ($this) {
            self::Created    => 'text-warning',
            self::InProgress => 'text-primary',
            self::Agreement  => 'text-info',
            self::Approved   => 'text-success',
            self::Denied     => 'text-danger',
            self::Return     => 'text-primary',
            self::Closed     => '',
            self::Checked    => 'text-primary',
        };
    }

    public function statusIcon(): string
    {
        return match ($this) {
            self::Created    => 'new-doc',
            self::InProgress => 'cogwheel',
            self::Agreement  => 'folder',
            self::Expertise  => 'search',
            self::Denied     => 'cancel',
            self::Approved   => 'check',
            self::Return     => 'back',
            self::Closed     => 'close-circle',
            self::Checked    => 'fact-check'
        };
    }
}
