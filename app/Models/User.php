<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    protected $fillable  = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_type_id',
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


    protected $with = ["client" ,"type"];
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
    
    public function is_member($user_id = null)
    {
        return in_array($user_id ?? Auth::user()->id , cache("project_members_$this->id" , $this->projects()->pluck("user_id")->toArray())  ) || Auth::user()->admin ;
    }
    public function own_project()
    {
        return $this->client_id ===  Auth::user()->id ;
    }
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function client_id()
    {
        return $this->client->id;
    }
    
    public function type()
    {
       return $this->belongsTo(UserType::class ,"user_type_id");
    }
    public function is_client($user = null)
    {
       return $user ? $user->user_type_id === 5 :  Auth::user()->user_type_id === 5;
    }
    

}
