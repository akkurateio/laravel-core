<?php

namespace App\Models;

use Akkurate\LaravelCore\Traits\Admin\HasPreference;
use Akkurate\LaravelCore\Traits\IsActivable;
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
    use HasRoles,
        HasPreference,
        HasFactory,
        IsActivable,
        Sluggable,
        softDeletes;

    protected $guard_name = 'web';

    protected $table = 'admin_accounts';

    protected $fillable = [
        'name',
        'slug',
        'email',
        'params',
        'internal_reference',
        'website',
        'parent_id',
        'country_id',
        'address_id',
        'phone_id',
        'email_id',
        'is_active',
    ];

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

    public function scopeFirstLevel(Builder $query)
    {
        return $query->where('parent_id', null);
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function target()
    {
        return $this->preference->target;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
