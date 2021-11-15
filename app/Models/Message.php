<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "messages";
    protected $with = ["sender"];
    protected $appends  = ["files_info"];

     /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, "project_id");
    }
    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
    public function destignators()
    {
        return $this->belongsToMany(User::class, "message_user");
    }
    public function getFilesInfoAttribute()
    {
        if ($this->files) {
            $ids = explode(",", $this->files);
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
            $project = get_array_value($options, "project");
            $message =  $project->messages();
        }
        /** Private messages */
        $user_id = get_array_value($options, "user_id");
        if ($user_id) {
            $message = User::find($user_id)->messages()->where("sender_id", $auth );
        }
        $group_id = get_array_value($options, "group_id");
        if ($group_id) {
            // $message = Group::find($group_id)->messages();
        }
        return $message->whereRaw('NOT FIND_IN_SET(' . $auth . ',deleted_by)')->whereDeleted(0)->orderBy('created_at', "DESC");
    }
}
