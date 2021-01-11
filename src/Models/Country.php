<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelCore\Database\Factories\Admin\CountryFactory;
use Akkurate\LaravelCore\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasUuid, HasFactory;

    protected $table = 'admin_countries';

    protected $fillable = ['name', 'code', 'priority', 'is_active'];

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
