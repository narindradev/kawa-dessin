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
    // protected $with = ["categories" ,"client" ,"status"];

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
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function descriptions(){
        return $this->hasMany(ProjectDescription::class);
    }
    public function files(){
        return $this->hasMany(ProjectFiles::class);
    }
    public function is_member($user_id = null)
    {
       return in_array($user_id ?? Auth::user()->id , cache("project_members_$this->id" , $this->members()->pluck("user_id")->toArray())  ) || Auth::user()->admin ;
    }
    public function is_client()
    {
       return $this->client_id ===  Auth::user()->id;
    }
    public function relaunchs()
    {
       return $this->belongsToMany(Relaunch::class,"project_relaunch");
    }  
    public function scopeGetDetails($query, $options = [])
    {
        $user_id = get_array_value($options, "user_id");
        if(Auth::user()->admin){
            /** All project  */
            $projects = Project::query();
        }elseif($user_id){
           /** load user's projects */
            $projects = User::find($user_id)->projects();
        }else{
            /** load this Auth projects */
            $projects = Auth::user()->projects();
        }
        $projects->with("categories","client","status");
        $status_id = get_array_value($options, "status_id");
        if ($status_id) {
            $projects->where("status_id", $status_id);
        }
        $priority_id = get_array_value($options, "priority_id");
        if ($priority_id) {
            $projects->where("priority_id", $priority_id);
        }
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $projects->where("client_id", $client_id);
        }
        $validation = get_array_value($options, "validation");
        if ($validation) {
            $projects->where("validation", $validation);
        }
        $version = get_array_value($options, "version");
        if ($version) {
            $projects->where("version", $version);
        }
        $categorie_id = get_array_value($options, "categorie_id");
        if ($categorie_id) {
            $projects->whereHas('categories', function ($query) use ($categorie_id) {
                $query->where('category_id', $categorie_id);
            });
        }
        $date = get_array_value($options, "date");
        if($date){
            $dates = explode("-",$date);
            $projects->whereBetween("start_date",[to_date($dates[0]),to_date($dates[1])]);  
        }
        return $projects->whereDeleted(0)->orderBy('status_id', 'ASC')->latest('created_at');
    }
}
