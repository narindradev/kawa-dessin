<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SpatieLogsActivity;

    protected $table = "projects";
    protected $guarded = [];
    protected static $logName = 'project';
    protected static $logAttributes = [];
    protected static $logUsers = "";
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'delivery_date' => 'datetime'
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function (Model $model) {
            static::$logAttributes = array_keys($model->getDirty());
        });
    }
    public function tapActivity(Activity $activity)
    {
        if (in_array("price", static::$logAttributes)) {
            $activity->users = Auth::id(); // Don't show  this log on project members
        } else {
            $activity->users =  $this->members()->pluck("user_id")->implode(",", "user_id");
        }
    }
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
        return $this->hasMany(File::class)->whereDeleted(0);
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
        return in_array($user_id ?? Auth::user()->id, cache("project_members_$this->id", $this->members()->pluck("user_id")->toArray())) || Auth::user()->is_admin();
    }
    public function own_project()
    {
        return $this->client_id == Auth::user()->client_id();
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class, "project_id");
    }
    public function scopeGetDetails($query, $options = [])
    {
        $AUTH = Auth::user();
        $user_id = get_array_value($options, "user_id");
        // $user_id = [49,53];
        $client = get_array_value($options, "client");
        if ($AUTH->is_admin() && !$user_id) {
            /** load all project  */
            $projects = Project::query();
        } elseif ($user_id && !is_array($user_id)) {
            /** load the user's projects assigned */
            $projects = User::find($user_id)->projects(); # code...

        } elseif ($user_id && is_array($user_id)) {
            $projects = Project::whereHas("members", function ($query) use ($user_id) {
                $query->whereIn('user_id', $user_id);
            });
        } elseif ($client) {
            /** load client's projects  */
            $projects = Project::where("client_id", $client);
        } else {
            /** load Auth user's projects assigned */
            $projects = $AUTH->projects();
        }
        $projects->whereDeleted(0);

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
        $version = get_array_value($options, "version");
        if ($version) {
            $projects->where("version", $version);
        }
        $with = ["categories", "client", "status"];
        if ($client || $AUTH->is_admin()) {
            $with[] = "invoiceItems";
            $with[] = "invoice";
        }
        $projects->with($with);
        $categorie_id = get_array_value($options, "categorie_id");
        if ($categorie_id) {
            $projects->whereHas('categories', function ($query) use ($categorie_id) {
                $query->where('category_id', $categorie_id);
            });
        }
        $status_invoice = get_array_value($options, "status_invoice");
        if ($status_invoice) {
            $projects->whereHas('invoice', function ($query) use ($status_invoice) {
                $query->where('status', $status_invoice);
            });
        }
        /** Messages project message auth not seen*/
        $projects->with(
            ["messages" => function ($query)  use ($AUTH) {
                $me = $AUTH->id;
                $query->select("id")->whereRaw('NOT FIND_IN_SET(' . $me . ',seen_by)')->whereRaw('NOT FIND_IN_SET(' . $me . ',deleted_by)')
                    ->where("sender_id", "<>", $me)
                    ->whereDeleted(0);
            }]
        );
        if ($user_id) {
            if (is_array($user_id)) {
                if (User::find($user_id[0])->is_commercial()) {
                    $projects->orderBy('created_at', "DESC");
                } else {
                    $projects->orderBy('due_date', "ASC");
                }
            }
        }
        if ($AUTH->is_commercial() || $AUTH->is_admin()) {
            $projects->orderBy('created_at', "DESC");
        } else {
            $projects->orderBy('due_date', "ASC");
        }
        $projects->orderBy('status_id', "ASC");

        return $projects;
    }

    public static function get_client_dropdown(User $for_user)
    {
        $client_dropdown = [];
        if ($for_user && !Auth::user()->is_admin()) // user not admin
        {
            $results = $for_user->projects->groupby("client_id");
            foreach ($results as $client_id => $projects) {
                $client_dropdown[] = ["value" => $client_id, "text" => $projects[0]->client->user->name];
            }
        } else {
            $clients = User::with("client")->whereDeleted(0)->where("user_type_id", 5)->get();
            foreach ($clients as $user) {
                $client_dropdown[] = ["value" => $user->client->id, "text" => $user->name];
            }
        }
        return $client_dropdown;
    }
}
