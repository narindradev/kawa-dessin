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
        return $this->client->id;
    }

    public function type()
    {
        return $this->belongsTo(UserType::class, "user_type_id");
    }
    public function is_client($user = null)
    {
        return $user ? $user->user_type_id === 5 :  Auth::user()->user_type_id === 5;
    }
    public function not_client()
    {
        return !$this->is_client();
    }

   

    public static function get_client_dropdown($for_user = 0)
    {
        $client_dropdown = [];
        if ($for_user) {
            $projects = User::find($for_user)->projects->groupby("client_id");
            foreach ($projects as $id => $project) {
                $client_dropdown[] = ["value" => $id, "text" => $project[0]->client->user->name];
            }
        } else {
            $users = User::with("client")->whereDeleted(0)->where("user_type_id", 5)->get();
            foreach ($users as $user) {
                $client_dropdown[] = ["value" => $user->client->id, "text" => $user->name];
            }
        }
        return $client_dropdown;
    }
}
