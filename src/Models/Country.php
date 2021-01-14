<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelCore\Database\Factories\Admin\CountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Country extends Model
{
    use HasFactory;

    protected $table = 'admin_countries';

    protected $fillable = ['name', 'code', 'priority', 'is_active'];

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
        return CountryFactory::new();
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
