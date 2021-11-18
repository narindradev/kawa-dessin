<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "messages";
    protected $with = ["sender"];
    protected $appends  = ["files_info"];

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id");
    }
    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
    public function files()
    {
        return $this->hasMany(File::class, "message_id");
    }
    public function getFilesInfoAttribute()
    {
        if ($this->files) {
            $ids = explode(",", $this->files);
            return File::findMany($ids);
        }
        return null;
    }
    public function scopeGetDetails($query, $options = [])
    {
        $me = auth()->user();
        /** Project's messages */
        $project_id = get_array_value($options, "project_id");
        if ($project_id) {
            $project = get_array_value($options, "project");
            $message =  $project->messages();
        }
        /** Private's messages */
        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $message = Message::where(function ($query)use($user_id, $me) {
                $query->where(function($q1)   use ($user_id ,$me){
                    $q1->where('sender_id',$user_id )->where('receiver_id', $me->id);
                })->orWhere(function($q2) use ($user_id ,$me){
                    $q2->where('sender_id',$me->id )->where('receiver_id',$user_id);
                });
            });
        }
        /** Group's messages */
        $group_id = get_array_value($options, "group_id");
        if ($group_id) {
            // $message = Group::find($group_id)->messages();
        }
        return $message->whereRaw('NOT FIND_IN_SET(' . $me->id . ',deleted_by)')->whereDeleted(0)->orderBy('created_at', "DESC");
    }
}
