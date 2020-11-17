<?php

namespace App\Models;

use App\Notifications\MailResetPassword;
use App\Notifications\MailVerifyEmail;
use App\Permissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token', 'created_at', 'updated_at',
    ];

    /**
     * Also expand
     */
    protected $with = ['images'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    protected static function boot()
    {
        parent::boot(); //because we want the parent boot to be run as well
        static::creating(function ($model) {
            $model->addRole(Permissions::ROLE_CUSTOMER);
        });
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new MailVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPassword($token));
    }

    /**
     * Get the social accounts.
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Get the business accounts.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class)->withTimestamps();
    }

    /**
     * Get the wishlist.
     */
    public function wishlist()
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * Get the bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @param string $role
     * @return $this
     */
    public function addRole(string $role)
    {
        $roles = $this->getRoles();
        $roles[] = $role;
        $this->setRoles(array_unique($roles));

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->setAttribute('roles', $roles);
        return $this;
    }

    /**
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * @param $roles
     * @return mixed
     */
    public function hasRoles($roles)
    {
        $currentRoles = $this->getRoles();
        foreach ($roles as $role) {
            if (!in_array($role, $currentRoles)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->getAttribute('roles');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }

    public function isProvider()
    {
        return $this->hasRole(Permissions::ROLE_PROVIDER);
    }

    /**
     * Get the images
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function dp($appendingPath = '')
    {
        $image = $this->images->first();
        if ($image) {
            return $appendingPath . $image['filename'];
        }
        return null;
    }
}
