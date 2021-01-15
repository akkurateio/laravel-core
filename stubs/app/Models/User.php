<?php

namespace App\Models;

use Akkurate\LaravelCore\Notifications\Auth\ResetPasswordNotification;
use Akkurate\LaravelCore\Traits\Access\HasAccess;
use Akkurate\LaravelCore\Traits\Admin\HasAccount;
use Akkurate\LaravelCore\Traits\Admin\HasPreference;
use Akkurate\LaravelCore\Traits\IsActivable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable implements Searchable
{
    use HasApiTokens,
        HasAccess,
        HasAccount,
        Notifiable,
        HasFactory,
        HasPreference,
        IsActivable,
        HasRoles,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'initials',
        'internal_reference',
        'sign',
        'gender',
        'birth_date',
        'is_active',
        'activation_token',
        'deleted_reason',
        'activated_at',
        'deleted_at',
        'account_id',
        'email',
        'password',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'activated_at' => 'datetime',
        'birth_date' => 'datetime',
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
}
