<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use SpatieLogsActivity;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

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

    protected $with = [];
    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */

     public function __construct() {
        if(isset($this->client->id)){
            $this->with[] = "client";
        }
     }
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
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class,"project_member");
    }
    
}
