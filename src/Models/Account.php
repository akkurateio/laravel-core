<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelContact\Traits\Contactable;
use Akkurate\LaravelCore\Database\Factories\Admin\AccountFactory;
use Akkurate\LaravelCore\Traits\Admin\HasPreference;
use Akkurate\LaravelCore\Traits\IsActivable;
use Akkurate\LaravelMedia\Traits\HasResources;
use Akkurate\LaravelSearch\Traits\ElasticSearchable;
use Akkurate\LaravelSearch\Traits\EloquentSearchable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Webpatser\Uuid\Uuid;

class Account extends Model implements Searchable
{
    use Contactable,
        ElasticSearchable,
        EloquentSearchable,
        HasPreference,
        HasResources,
        HasRoles,
        HasFactory,
        IsActivable,
        Sluggable,
        softDeletes;

    protected $guard_name = 'web';

    protected $table = 'admin_accounts';

    protected $fillable = ['name', 'slug', 'email', 'params', 'internal_reference', 'website', 'parent_id', 'country_id', 'address_id', 'phone_id', 'email_id', 'is_active'];

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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AccountFactory::new();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function target()
    {
        return $this->preference->target;
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('brain.admin.accounts.show', ['uuid' => auth()->user()->account->slug, 'account' => $this->id]);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    /**
     * Scope a query to only include user’s administrable account(s).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdministrable($query)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return $query
                ->where('id', auth()->user()->account_id)
                ->orWhereIn('id', auth()->user()->accounts->pluck('id'));
        }
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query
            ->where('name', 'like', '%' . $search . '%');
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function scopeFirstLevel(Builder $query)
    {
        return $query->where('parent_id', null);
    }

    public function events()
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
