<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Feedback extends Model
{
    protected $table = 'feedback';

    public const TYPE_FEEDBACK = 0;

    public const TYPE_INVITE = 1;

    public const TYPE_REQUEST = 2;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'message',
        'ip',
        'attach',
    ];

    public static $type_name = [
        self::TYPE_FEEDBACK => 'Обратная связь',
        self::TYPE_INVITE => 'Приглашение на тендер',
        self::TYPE_REQUEST => 'Запрос номенклатуры',
    ];

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function getAttach(): string
    {
        return Storage::disk('public')->url('attach/' . $this->attach);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('attach/' . $this->attach) === true) Storage::disk('public')->delete('attach/' . $this->attach);

        $this->delete();
    }
}