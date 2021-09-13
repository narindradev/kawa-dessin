<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,"project_member");
    }
    public function scopeGetDetails($query, $options = [])
    {

        $user_id = get_array_value($options, "user_id");
        if( 0 ){
            /** All project  */
            $project = Project::query();
        }elseif($user_id ){
           /** load use'projects */
            $project = User::find($user_id)->projects();
        }else{
            /** load this loginUser'projects */
            $project = Auth::user()->projects();
        }
        
        $status_id = get_array_value($options, "status_id");
        if ($status_id) {
            $project->where("status_id", $status_id);
        }

        $priority_id = get_array_value($options, "priority_id");
        if ($priority_id) {
            $project->where("priority_id", $priority_id);
        }

        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $project->where("client_id", $client_id);
        }
        $validation = get_array_value($options, "validation");
        if ($validation) {
            $project->where("validation", $validation);
        }
        $version = get_array_value($options, "version");
        if ($version) {
            $project->where("version", $version);
        }

        return $project->latest('created_at');
    }
}
