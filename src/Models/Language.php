<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelCore\Database\Factories\LanguageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Language extends Model
{
    use HasFactory;

    protected $table = 'admin_languages';

    protected $fillable = ['label', 'locale', 'locale_php', 'priority', 'is_active', 'is_default'];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return LanguageFactory::new();
    }
}
