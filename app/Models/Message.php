<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "messages";
    protected $with = ["sender"];
    protected $appends  = ["files_info"];
    
    public function project(){
        return $this->belongsTo(Project::class,"project_id");
    }
    public function sender(){
        return $this->belongsTo(User::class,"sender_id");
    }
    public function destignators()
    {
        return $this->belongsToMany(User::class, "message_user");
    }
    public function getFilesInfoAttribute()
    {
        if ($this->files) {
            $ids= explode(",",$this->files);
            return ProjectFiles::findMany($ids);
        }
        return null;
    }
    public function scopeGetDetails($query, $options = [])
    {
        $auth = auth()->id();
        
        $project_id = get_array_value($options, "project_id");
        /** Project's messages */
        if ($project_id) {
            $message = Project::find($project_id)->messages();
        }
        /** Private messages */
        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $message = User::find($user_id)->messages()->wherePivot("user_id" ,Auth::id());
        }
        $offest = get_array_value($options, "offest");
        if ($offest) {
            $message->skip($offest + 1);
        }
        $message->whereRaw('NOT FIND_IN_SET('.$auth.',deleted_by)');
        return $message->whereDeleted(0)->orderBy('created_at',"DESC")->take(6);
    }
}
