<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswords;


class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable , Billable, SpatieLogsActivity ,HasRoles ,CanResetPasswords;
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
    // protected $appends  = [
    //     "message_not_seen"
    // ];
    protected static $logName = 'user';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ["client", "type"];

    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset("avatars/".$this->avatar);
        }else{
            return "https://i.pravatar.cc/80?img={$this->id}";
            // return asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
        }
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, "project_member");
    }
    public function type()
    {
        return $this->belongsTo(UserType::class, "user_type_id");
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
    public function function()
    {
        return $this->type();
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
        return  $this->user_type_id == 3;
    }
    public function getMessageNotSeenAttribute()
    {
        return $this->message_not_seen();
    }
    public function message_not_seen(){
        $me = auth()->id();
        return Message::select("id")
                    ->where('sender_id',$this->id )->where('receiver_id',$me)
                    ->whereRaw('NOT FIND_IN_SET('.$me.',deleted_by)')
                    ->whereRaw('NOT FIND_IN_SET('.$me.',seen_by)')
                    ->whereDeleted(0)
                    ->count();
    }
}
