<?php

namespace App\Models;

use Database\Factories\PreferenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $table = 'admin_preferences';
    protected $fillable = ['target', 'pagination'];
    protected $hidden = ['preferenceable_id', 'preferenceable_type'];

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
}
