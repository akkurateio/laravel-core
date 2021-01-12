<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelCore\Database\Factories\Admin\PreferenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $table = 'admin_preferences';
    protected $fillable = ['target', 'pagination', 'language_id'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PreferenceFactory::new();
    }

    public function preferenceable()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
