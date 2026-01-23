<?php

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    public const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['email', 'token'];

    /**
     * @var null
     */
    protected $primaryKey = 'token';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @param string $value
     * @return void
     */
    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function getEmailAttribute(string $value): string
    {
        return strtolower($value);
    }
}