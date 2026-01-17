<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logs extends Model
{
    public const ACTION_LOGIN = 0;

    public const ACTION_REGISTRATION = 1;

    public const ACTION_PASSWORD_RESET = 2;

    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip',
        'customer_id',
        'user_agent',
        'action',
    ];

    public static array $action_name = [
        self::ACTION_LOGIN => 'авторизация',
        self::ACTION_REGISTRATION => 'регистрация',
        self::ACTION_PASSWORD_RESET => 'сброс пароля',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}