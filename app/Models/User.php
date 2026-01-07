<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_EDITOR = 'editor';


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static array $role_name = [
        self::ROLE_ADMIN     => 'Админ',
        self::ROLE_MODERATOR => 'Модератор',
        self::ROLE_EDITOR    => 'Редактор',
    ];

    /**
     * @return array
     */
    public static function getOption(): array
    {
        return [
            self::ROLE_ADMIN     => 'Админ',
            self::ROLE_MODERATOR => 'Модератор',
            self::ROLE_EDITOR    => 'Редактор',
        ];
    }
}
