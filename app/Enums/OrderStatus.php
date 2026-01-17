<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Created = 0;
    case InProgress = 1;
    case Issued = 2;
    case Paid = 3;
    case Ready = 4;
    case Done = 5;

    public function label(): string
    {
        return match ($this) {
            self::Created    => 'Создан',
            self::InProgress => 'В работе',
            self::Issued     => 'Оформлен',
            self::Paid       => 'Оплачен',
            self::Ready      => 'Готов к выдаче',
            self::Done       => 'Выдан',
            default          => '',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::Created    => 'create',
            self::InProgress => 'in-progress',
            self::Issued     => 'issued',
            self::Paid       => 'paid',
            self::Ready      => 'ready',
            self::Done       => 'done',
        };
    }

    public function cssColor(): string
    {
        return match ($this) {
            self::Created    => 'text-warning',
            self::InProgress => 'text-primary',
            self::Issued     => 'text-info',
            self::Paid       => 'text-success',
            self::Ready      => 'text-muted',
            self::Done       => '',
        };
    }

    public function statusIcon(): string
    {
        return match ($this) {
            self::Created    => 'new-doc',
            self::InProgress => 'cogwheel',
            self::Issued     => 'check-circle',
            self::Paid       => 'money',
            self::Ready      => 'box',
            self::Done       => 'delivery-car',
            default          => 'info',
        };
    }
}
