<?php

namespace App\Models;

use App\Traits\StaticTableName;
use App\Enums\FeedbackStatus;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use StaticTableName;

    protected $table = 'feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'ip',
        'status',
    ];

    public function getStatus()
    {
        return FeedbackStatus::tryFrom($this->status);
    }

    public static function getOption(): array
    {
        return [
            FeedbackStatus::Created->value    => FeedbackStatus::Created->label(),
            FeedbackStatus::InProgress->value => FeedbackStatus::InProgress->label(),
            FeedbackStatus::Done->value       => FeedbackStatus::Done->label(),
        ];
    }
}