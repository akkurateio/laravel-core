<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelCore\Database\Factories\Admin\LanguageFactory;
use Akkurate\LaravelCore\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasUuid, HasFactory;

    protected $table = 'admin_languages';

    protected $fillable = ['label', 'locale', 'locale_php', 'priority', 'is_active', 'is_default'];

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
