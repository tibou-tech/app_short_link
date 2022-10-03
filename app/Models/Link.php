<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_link',
        'key',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];


    /**
     * For modify default binding Model by id to binding by key
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'key';
    }


    /*
    |--------------------------------------------------------------------------
    | Event handlers
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->count() >= 20) {
                $link = $model->first();

                $link->delete();
            }
        });
    }


    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
