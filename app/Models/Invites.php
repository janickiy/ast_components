<?php

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;

class Invites extends Model
{
    use StaticTableName;

    protected $table = 'invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'message',
        'ip',
        'platform',
        'numb',
    ];

    public static function getPlatformList(): array
    {
        return [
            'platform-1' => 'Общероссийский официальный сайт ЕИС',
            "platform-2" => 'АО «АГЕНТСТВО ПО ГОСУДАРСТВЕННОМУ ЗАКАЗУ РЕСПУБЛИКИ ТАТАРСТАН» (АГЗ РТ)',
            "platform-3" => 'АО «ЕДИНАЯ ЭЛЕКТРОННАЯ ТОРГОВАЯ ПЛОЩАДКА» (АО «ЕЭТП»)',
            "platform-4" => 'ОАО «РОССИЙСКИЙ АУКЦИОННЫЙ ДОМ» (АО «РАД»)',
            "platform-5" => 'АО «ЭЛЕКТРОННЫЕ ТОРГОВЫЕ СИСТЕМЫ» (Национальная электронная площадка)',
            "platform-6" => 'Группа площадок ТЭК-Торг',
            "platform-7" => 'ЗАО «Сбербанк - Автоматизированная система торгов» (Сбербанк-АСТ)',
            "platform-8" => 'ООО «РТС-ТЕНДЕР» (РТС-тендер)',
            "platform-9" => ' ООО «Электронная торговая площадка ГПБ» (ЭТП Газпромбанк")',
        ];
    }
}