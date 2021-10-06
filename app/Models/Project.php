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
        return $this->belongsToMany(User::class, "project_member");
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function descriptions()
    {
        return $this->hasMany(ProjectDescription::class);
    }
    public function files()
    {
        return $this->hasMany(ProjectFiles::class)->whereDeleted(0);
    }
    public function infoGround()
    {
        return $this->hasOne(InfoGround::class);
    }
    public function is_client()
    {
        return $this->client_id ===  Auth::user()->id;
    }
    public function relaunchs()
    {
        return $this->hasMany(ProjectRelaunch::class)->latest();
    }

    public function is_member($user_id = null)
    {
        return in_array($user_id ?? Auth::user()->id, cache("project_members_$this->id", $this->members()->pluck("user_id")->toArray())) || Auth::user()->admin;
    }
    public function own_project()
    {
        return $this->client_id == Auth::user()->client_id();
    }
    
    public function scopeGetDetails($query, $options = [])
    {
        $user_id = get_array_value($options, "user_id");
        $client = get_array_value($options, "client");
        if (Auth::user()->user_type_id == 1) {
            /** load all project  */
            $projects = Project::query();
        } elseif ($user_id) {
           
            /** load the user's projects assigned */
            $projects = User::find($user_id)->projects();
        } elseif ($client) {
  
            /** load client's projects  */
            $projects = Project::where("client_id", $client);
        } else {
            /** load Auth user's projects assigned */
            $projects = Auth::user()->projects();
        }
        $projects->with("categories", "client", "status");
        $client_id = get_array_value($options, "client_id");
        if ($client_id) {
            $projects->where("client_id", $client_id);
        }
       
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
        $type = get_array_value($options, "client_type");
        if ($type) {
            $projects->whereHas('client', function ($query) use ($type) {
                $query->where('type', $type);
            });
        }
        $date = get_array_value($options, "date");
        if ($date) {
            $dates = explode("-", $date);
            $projects->whereBetween("start_date", [to_date($dates[0]), to_date($dates[1])]);
        }
        return $projects->whereDeleted(0)->orderBy('status_id', 'ASC')->latest('created_at');
    }

    public static function get_client_dropdown($for_user = 0)
    {
        $client_dropdown = [];
        if ($for_user && !Auth::user()->is_admin() ) // user not admin
        { 
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
