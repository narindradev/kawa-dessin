<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable , Billable, SpatieLogsActivity ,HasRoles;

   
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ["client", "type"];
    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function getAvatarUrlAttribute()
    {
        if ($this->info) {
            return asset($this->info->avatar_url);
        }
        return asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
    }
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, "project_member");
    }
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function client_id()
    {
        if ($this->is_client()) {
            return $this->client->id;
        }
    }
    public function type()
    {
        return $this->belongsTo(UserType::class, "user_type_id");
    }
    public function is_admin()
    {
        return $this->user_type_id == 1 ;
    }
    public function not_admin()
    {
        return !$this->is_admin();
    }
    public function is_client()
    {
        return $this->user_type_id == 5;
    }
    public function not_client()
    {
        return !$this->is_client();
    }
    public function is_mdp()
    {
        return $this->user_type_id == 2;
    }
    public function is_dessignator()
    {
        return $this->user_type_id == 4;
    }
    public function is_commercial()
    {
        return   $this->user_type_id == 3;
    }
    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }
}
