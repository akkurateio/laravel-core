<?php

namespace Akkurate\LaravelCore\Models;

use Akkurate\LaravelAuth\Notifications\ResetPasswordNotification;
use Akkurate\LaravelContact\Traits\Contactable;
use Akkurate\LaravelCore\Database\Factories\Admin\UserFactory;
use Akkurate\LaravelCore\Traits\Access\HasAccess;
use Akkurate\LaravelCore\Traits\Admin\HasAccount;
use Akkurate\LaravelCore\Traits\Admin\HasPreference;
use Akkurate\LaravelCore\Traits\HasUuid;
use Akkurate\LaravelCore\Traits\IsActivable;
use Akkurate\LaravelMedia\Traits\HasResources;
use Akkurate\LaravelSearch\Traits\ElasticSearchable;
use Akkurate\LaravelSearch\Traits\EloquentSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements Searchable
{
    use Contactable,
        ElasticSearchable,
        EloquentSearchable,
        HasAccess,
        HasAccount,
        HasApiTokens,
        HasFactory,
        HasPreference,
        HasResources,
        HasRoles,
        HasUuid,
        IsActivable,
        Notifiable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    /*
    |--------------------------------------------------------------------------
    | Getters for user’s fullanme
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Getter for the user fullname (John Doe)
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Getter for the user reverse fullname (Doe John)
     *
     * @return string
     */
    public function getNamefullAttribute()
    {
        return "{$this->lastname} {$this->firstname}";
    }

    /*
    |--------------------------------------------------------------------------
    | Spatie Searchable
    |--------------------------------------------------------------------------
    |
    */

    public function getSearchResult(): SearchResult
    {
        if (auth()->user()->superadmin()) {
            $url = route('brain.admin.users.show', [
                'uuid' => auth()->user()->account->slug,
                'user' => $this->id
            ]);
        } elseif (auth()->user()->admin()) {
            $url = route('brain.me.users.edit', [
                'uuid' => auth()->user()->account->slug,
                'userUuid' => $this->uuid
            ]);
        } else {
            $url = route('brain.me.profile.edit', uuid());
        }

        return new SearchResult(
            $this,
            $this->fullname ?? $this->username,
            $url
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Laravel Search Methods
    |--------------------------------------------------------------------------
    |
    */

    public function getEntities()
    {
        return [
            'uuid' => $this->account->searchable->uuid,
            'name' => $this->account->name,
        ];
    }

    public function getSearchContent()
    {
        return [
            $this->fullname,
            $this->email
        ];
    }
}
