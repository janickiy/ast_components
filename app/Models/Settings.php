<?php

namespace App\Models;

use App\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Settings extends Model
{
    use StaticTableName;

    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key_cd',
        'name',
        'type',
        'display_value',
        'value',
        'published',
    ];


    /**
     * @param $value
     * @return void
     */
    public function setKeyCdAttribute($value): void
    {
        $this->attributes['key_cd'] = str_replace(' ', '_', strtoupper($value));
    }

    /**
     * @return string
     */
    public function getTypeAttribute() {
        return $this->attributes['type'] = strtoupper($this->attributes['type']);
    }

    /**
     * @return array|string
     */
    public function getValueAttribute()
    {
        if ($this->attributes['type'] == 'FILE') {
            return Storage::disk('public')->url($this->table . '/' . $this->attributes['value']);
        }

        return $this->attributes['value'];
    }

    /**
     * @return mixed
     */
    public function filePath()
    {
        return $this->attributes['value'];
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists($this->table . '/' . $this->filePath()) === true) Storage::disk('public')->delete($this->table . '/' . $this->filePath());

        $this->delete();
    }
}