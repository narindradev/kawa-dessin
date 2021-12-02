<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\File;
use App\Models\User;
use App\Models\Status;
use App\Models\Project;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Relaunch;
use App\Models\InfoGround;
use Illuminate\Http\Request;
use App\Jobs\memberAssignedJob;
use App\Jobs\memberDetachedJob;
use App\Models\ProjectRelaunch;
use App\Jobs\EstimateAssignedJob;
use App\Models\ProjectDescription;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PriceProjectRequest;
use App\Http\Requests\StartProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        // foreach (Message::all() as $ms ) {
        //    if($ms->deleted){
        //     $ms->delete();
        //    }
        // }
        // dd("");
        $advance_filter = $this->advance_filter();
        $basic_filter = $this->basic_filter();
        $users = null;
        if (!Auth::user()->is_dessignator()) {
            $users = $this->users_list();
        }
        return view("project.index", compact("advance_filter", "basic_filter", "users"));
    }
    public function data_list(Request $request)
    {
        $data = [];
        $projects = Project::getDetails($request->all())->get();
        // $count = $projects->count();
        foreach ($projects as $project) {
            $data[] = $this->_make_row($project, Auth::user(), true);
        }
        return ["data" => $data,];
    }
    public function _make_row(Project $project, $for_user = null, $from_notification = false)
    {
        $client = $project->client;
        $actions = [];
        $columns = [
            "DT_RowId" => row_id("projects", $project->id),
            "badge" => view("project.column.badge", ["project" => $project, "for_user" => $for_user])->render(),
            "client_info" => view("project.column.info-client", ["client" => $client, "project" => $project, "link" => 1, "for_user" => $for_user])->render(),
            "categories" => $project->categories->pluck("name")->implode(" , ", "name"),
            "client_type" => view("project.column.client-type", ["client" => $client])->render(),
            "status" => view("project.column.status", ["project" => $project, "for_user" => $for_user])->render(),
            "version" => $project->version,
            "start_date" => "<span style='display:inline'>" . ($project->start_date ? $project->start_date->format("d-M-Y") : "-") . "</span>",
            "due_date" => $this->due_column($project),
        ];
        $add_dessinator =  modal_anchor(url("/project_member/add_member_modal_form"), '<i class="text-hover-primary fas fa-user-plus " style="font-size:15px"></i>', ["data-post-project_id" => $project->id, "data-post-user_type_id" => 4, "class" => "", 'title' => trans('lang.add_dessinator')]);
        $add_mdp = modal_anchor(url("/project_member/add_member_modal_form"), '<i class="text-hover-primary fas fa-user-plus " style="font-size:15px"></i>', ["data-post-project_id" => $project->id, "data-post-user_type_id" => 2, "class" => "", 'title' => trans('lang.add_mdp')]);
        $members_list = $this->_make_user_type_column($project);

        $columns["messenger"]  = view("project.column.messenger", ["client" => $client, "project" => $project, "for_user" => $for_user, "from_notification" => $from_notification, "members_list" => $members_list])->render();
        $columns["mdp"]  =  view("project.column.members", ["members" =>  get_array_value($members_list, "mdp"), "add" => $add_mdp, "for_user" => $for_user])->render();

        if ($for_user && !$for_user->is_dessignator()) {
            $columns["commercial"] =  view("project.column.members", ["members" =>  get_array_value($members_list, "commercial"), "for_user" => $for_user])->render();
        }
        $columns["dessignator"] =   view("project.column.members", ["members" =>  get_array_value($members_list, "dessignator"), "add" => $add_dessinator, "for_user" => $for_user])->render();
        if ($for_user && $for_user->is_admin()) {
            $columns["invoice"] =  $this->invoice_column($project);
        }
        if ($for_user && ($for_user->is_admin() || $for_user->is_commercial())) {
            $columns["payment"] =  $this->payment_column($project);
        }
        if ($for_user && !$for_user->is_dessignator()) {
            $columns["client_type"] =  view("project.column.client-type", ["client" => $client])->render();
            $columns["date"] =  $project->created_at->format("d-M-Y");
            $columns["delivery_date"] = $this->delivery_date_column($project);
        }
        if ($for_user && ($for_user->is_admin() || $for_user->is_commercial())) {
            $last_relauch =  ProjectRelaunch::where("project_id", $project->id)->where("created_by", $client->user->id)->latest('created_at')->first();
            $relaunch = Relaunch::where("project_id", $project->id)->where("created_by", $client->user->id)->latest('created_at')->first();
            $columns["estimate"] =  view("project.column.estimate", ["project" => $project, "last_relaunch" => $last_relauch, "relaunch" =>  $relaunch, "for_user" => $for_user])->render();
        }
        $columns["actions"] = view("project.column.actions", ["actions" => $actions, "project" => $project, "for_user" => $for_user])->render();
        return $columns;
    }

    private function invoice_column(Project $project)
    {
        if ($project->invoice && $project->invoice->status->name !== "not_paid") {
            return view("project.column.invoice_items", ["project" =>  $project])->render();
        } else {
            return "-";
        }
    }
    private function payment_column(Project $project)
    {
        if ($project->invoice && in_array($project->invoice->status->name, ["not_paid", "part_paid"])) {
            return anchor(url("project/invoice/preview/{$project->invoice->id}"), trans("lang.{$project->invoice->status->name}"), ["class" => "text-{$project->invoice->status->class} "]);
        } elseif ($project->invoice && ($project->invoice->status->name === "paid")) {
            return anchor(url("project/invoice/preview/{$project->invoice->id}"), trans("lang.{$project->invoice->status->name}"), ["class" => "text-{$project->invoice->status->class} "]);
        } else {
            return "-";
        }
    }

    private function delivery_date_column(Project $project)
    {
        $class  = "";
        $delivery_date = null;
        if ($project->delivery_date && $project->delivery_date->isToday()) {
            $class  = "danger";
            $delivery_date = trans("lang.now");
        } elseif ($project->delivery_date && $project->delivery_date->isTomorrow()) {
            $class  = "warning";
            $delivery_date = trans("lang.tomorrow");
            "Demain";
        } elseif ($project->delivery_date) {
            $delivery_date = $project->delivery_date->format("d-M-Y");
        }
        return "<span class ='text-{$class}'>" . ($project->delivery_date ?  $delivery_date : "-") . "</span>";
    }
    private function due_column(Project $project)
    {
        $class  = "";
        $due_date = null;
        if ($project->due_date && $project->due_date->isToday()) {
            $class  = "danger";
            $due_date = trans("lang.now");
        } elseif ($project->due_date && $project->due_date->isTomorrow()) {
            $class  = "warning";
            $due_date = trans("lang.tomorrow");
        } elseif ($project->due_date) {
            $due_date = $project->due_date->format("d-M-Y");
        }
        return "<span class ='text-{$class}'>" . ($project->due_date ?  $due_date : "-") . "</span>";
    }
    private function _make_user_type_column(Project $project)
    {

        $members = get_cache_member($project);
        $list = ["mdp" => [], "dessignator" => [], "commercial" => []];
        foreach ($members as $member) {
            if ($member->is_mdp()) {
                $list["mdp"][] = [
                    "id" => $member->id,
                    "name" => $member->name,
                    "avatar" => $member->avatar_url,
                ];
            } elseif ($member->is_commercial()) {
                $list["commercial"][]  = [
                    "id" => $member->id,
                    "name" => $member->name,
                    "avatar" => $member->avatar_url,
                ];
            } elseif ($member->is_dessignator()) {
                $list["dessignator"][] = [
                    "id" => $member->id,
                    "name" => $member->name,
                    "avatar" => $member->avatar_url,
                ];
            }
        }
        return $list;
    }
    /** Relaunch summary */
    public  function relaunch(Project $project)
    {
        $subjects = Relaunch::drop();
        return ["view" => view("project.relaunch.summary", compact("project", "subjects"))->render()];
    }
    public  function add_relaunch(Request $request, Project $project)
    {
        $request->validate(['subject' => 'required']);
        $relaunch = new ProjectRelaunch(['note' => $request->note, "relaunch_id" => $request->subject, "created_by" => Auth::user()->id]);
        $project->relaunchs()->save($relaunch);
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row" => row_id("project", $project->id), "project" => $this->_make_row($project, Auth::user()), "relaunch" => $this->_make_relaunch_row($relaunch)]));
    }
    public function relaunch_list(Project $project)
    {
        $data = $relaunchs = [];
        $project->load("relaunchs");
        $relaunchs = $project->relaunchs;
        foreach ($relaunchs as $relaunch) {
            $relaunch->load("subject");
            $data[] = $this->_make_relaunch_row($relaunch);
        }
        return ["data" => $data];
    }
    private function _make_relaunch_row($relaunch)
    {
        return [
            "subjet" => $relaunch->subject ? $relaunch->subject->description : "",
            "note" => $relaunch->note ?? "-",
            "date" => "<span class ='text-muted me-2 fs-7'> <i>" . $relaunch->created_at->diffForHumans() . "</i></span>",
            "created_by" => $relaunch->createBy->name,
            "status" => '<i class="fas fa-check text-success"></i>',
        ];
    }
    public function estimat_form(Project $project)
    {
        return view("project.estimate.estimate-modal-form", compact("project"));
    }
    public function add_estimate(PriceProjectRequest $request, Project $project)
    {
        if ($project->estimate == "accepted") {
            die(json_encode(["success" => false, "message" => trans("lang.error_global")]));
        }
        $project->price = $request->devis;
        $project->status_id = 3; // estimated
        $project->save();
        dispatch(new EstimateAssignedJob($project));
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row_id" => row_id("projects", $project->id), "project" => $this->_make_row($project, Auth::user(), true)]));
    }
    private function advance_filter()
    {
        $filters = [];
        $filters[] = [
            "label" => "Status",
            "name" => "sqdqsd",
            "type" => "select",
            "options" => [
                ["value" => 1, "text" => "new", "selected" => true],
                ["value" => 2, "text" => "recieveid"],
                ["value" => 3, "text" => "avec devis"],
            ]
        ];
        return $filters;
    }
    private function basic_filter()
    {
        $filters = [];
        $filters[] = [
            "label" => trans("lang.clients"),
            "name" => "client_id",
            "type" => "select",
            "options" =>  Project::get_client_dropdown(Auth::user()),
        ];
        /*
        $filters[] = [
            "label" => trans("lang.date"),
            "name" => "date",
            "type" => "date-range",
        ];
        */
        if (!Auth::user()->is_dessignator()) {
            $filters[] = [
                "label" => trans("lang.client_type"),
                "name" => "client_type",
                "type" => "select",
                "options" => [
                    ["value" => "particular", "text" => "Particulier"],
                    ["value" => "corporate", "text" => "Entreprise"],
                ],
            ];
        }
        if (Auth::user()->is_admin()) {
            $filters[] = [
                "label" => trans("lang.payment"),
                "name" => "status_invoice",
                "type" => "select",
                "options" => [
                    ["value" => "paid", "text" => "Payé"],
                    ["value" => "part_paid", "text" => "Partiellement payé"],
                    ["value" => "not_paid", "text" => "Non payé"],
                ],
            ];
        }
        $filters[] = [
            "label" => trans("lang.priority"),
            "name" => "priority_id",
            "type" => "select",
            "options" =>  Priority::drop(),
        ];
        $filters[] = [
            "label" => trans("lang.status"),
            "name" => "status_id",
            "type" => "select",
            "options" => Auth::user()->is_dessignator() ? Status::dropProjectStatus() : Status::drop(),
        ];
        $filters[] = [
            "label" => trans("lang.type") . " " . trans("lang.project"),
            "name" => "categorie_id",
            "type" => "select",
            "options" =>  Category::drop(),
        ];
        return $filters;
    }
    public function users_list()
    {
        $list = [];
        $users = Auth::user()->is_admin() ?  User::whereIn("user_type_id", [2, 3, 4])->get() : User::where("user_type_id", 4)->get();
        foreach ($users as $user) {
            $list[] =  [
                "value" => $user->id,
                "name" => $user->first_name . ' ' . $user->last_name,
                "avatar" => $user->avatar_url,
                "email" => $user->email,
            ];
        }
        return ($list);
    }
    public function detail(Project $project)
    {
        $project->load("categories");
        $project->load("infoGround");
        foreach ($project->categories as $categorie) {
            $categorie->load("questionnaires"); // load categorie questionnaires
            $categorie->offer->load("questionnaires"); // load categorie offer questionnaires
        }
        $invoice_data = null;
        if ($project->estimate == 'accepted') {
            $project->load("invoice");
            $invoice_data = invoice_data($project->invoice);
        }
        $states = Status::StepOfStateProject($project);
        return view("project.detail.index", compact("project", "invoice_data", "states"));
    }
    public function save_info_ground(Request $request, Project $project)
    {
        if ($request->ground_info_id) {
            InfoGround::find($request->ground_info_id)->update($request->except("_token", "ground_info_id"));
        } else {
            $info_ground = new InfoGround($request->except("_token", "ground_info_id"));
            $project->infoGround()->save($info_ground);
        }
        return ["success" => true, "message" => trans("lang.success_record")];
    }
    public function save_responses_of_question(Request $request, Project $project)
    {
        $project_id = $project->id;
        $responses = $request->except("_token");
        foreach ($responses as $input => $answer) {
            $questionnaire_id = str_replace("questionnaire_id_", "", $input);
            if ($questionnaire_id) {
                ProjectDescription::updateOrCreate(
                    ["project_id" => $project_id, "questionnaire_id" => $questionnaire_id],
                    ["answer" => $answer]
                );
                Cache::forget("response_of_questionnaire_id_{$questionnaire_id}_project_id_{$project_id}");
            }
        }
        return ["success" => true, "message" => trans("lang.success_record")];
    }
    public function tab_description(Project $project)
    {
        $project->load("descriptions");
        $count = $project->files()->wherePreliminary(1)->whereDeleted(0)->count();
        return view("project.detail.description", compact("project", "count"));
    }
    public function project_files(Project $project)
    {
        $data = [];
        $files = $project->files()->wherePreliminary(1)->whereDeleted(0)->latest()->get();
        foreach ($files as $file) {
            $data[] = $this->_make_file_row($file);
        }
        return (["data" => $data]);
    }
    private function _make_file_row($file)
    {
        return [
            view("project.column.file", ["file" => $file])->render(),
            anchor(url("/project/download/file/$file->id"), '<i class="fas fa-cloud-download-alt"></i>', ["class" => "text-hover-primary", "title" => trans("lang.download")])
        ];
    }
    public function download_file(File $file)
    {
        $file->load("project");
        if ($file->project->is_member() || $file->project->own_project()) {
            $uri = public_path($file->url);
            return response()->download($uri, $file->originale_name);
        }
        abort(403);
    }
    public function add_member_modal_form(Request $request)
    {
        $project = Project::find($request->project_id);
        $not_member = User::where('user_type_id', $request->user_type_id)->whereNotIn('id', $project->members()->pluck("user_id")->toArray())->get();
        return view("project.members.add-member-modal-form", ["user_type_id" => $request->user_type_id, "project_id" => $request->project_id, "not_member" => $not_member]);
    }
    public function data_list_member(Request $request)
    {
        $data = [];
        $project = Project::find($request->project_id);
        $users = User::where('user_type_id', $request->user_type_id)->whereDeleted(0)->get();
        $member_ids = $project->members()->pluck("user_id")->toArray();
        foreach ($users as $user) {
            $data[] = $this->_make_row_member($user, $member_ids, $project);
        }
        return (["data" => $data]);
    }
    private function _make_row_member($user, $member_ids, $project)
    {
        $is_member = in_array($user->id, $member_ids);
        return [
            "DT_RowId" => row_id("user", $user->id),
            "member_info" => view("project.column.member-list", ["user" => $user, "is_member" => $is_member])->render(),
            "select" => view("project.column.member-selected-list", ["user" => $user, "is_member" => $is_member, "project_id" => $project->id])->render(),
        ];
    }
    public function delete_member(Request $request)
    {
        $project = Project::find($request->project_id);
        $user = User::find($request->user_id);
        Cache::forget("members_list_$project->id");
        if ($request->input("cancel")) {
            $project->members()->attach($request->user_id);
            $member = $project->members()->pluck("user_id")->toArray();
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "extra_data" => ["table" => "projectsTable", "row_id" => row_id("projects", $request->project_id), "data" => $this->_make_row($project, Auth::user(), true)], "row_id" => row_id("user", $request->user_id), "data" => $this->_make_row_member($user, $member, $project)]));
        } else {
            $project->members()->detach($request->user_id);
            $member = $project->members()->pluck("user_id")->toArray();
            dispatch(new memberDetachedJob($project, $request->user_id, Auth::user()));
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted"), "extra_data" => ["table" => "projectsTable", "row_id" => row_id("projects", $request->project_id), "data" => $this->_make_row($project, Auth::user(), true)], "row_id" => row_id("user", $request->user_id), "data" => $this->_make_row_member($user, $member, $project)]));
        }
    }
    public function assign_member(Request $request)
    {
        if ($request->user_ids) {
            $project = Project::find($request->project_id);
            $project->members()->syncWithoutDetaching($request->user_ids);
            Cache::forget("members_list_$project->id");
            /** Send notication */
            dispatch(new memberAssignedJob($project, $request->user_ids, Auth::user()));
            die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row_id" => row_id("projects", $project->id), "data" => $this->_make_row($project, Auth::user(), true)]));
        } else {
            die(json_encode(["success" => true, "message" => "aucune action"]));
        }
    }
    public function start_form(Project $project)
    {
        $project->load("client");
        $status = Status::dropProjectStatus();
        return view("project.start-date.start-modal-form", compact("project", "status"));
    }

    public function add_start(StartProjectRequest $request, Project $project)
    {
        $project->start_date = null;
        $project->due_date = null;
        $project->status_id = $request->status ? $request->status : 5; // in progress 
        if ($request->delivery_date) {
            $project->delivery_date = to_date($request->delivery_date);
        }
        if ($request->dates) {
            $dates = explode("-", $request->dates);
            $project->start_date = to_date($dates[0]);
            $project->due_date = to_date($dates[1]);
        }
        $project->save();
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row_id" => row_id("projects", $project->id), "project" => $this->_make_row($project, Auth::user(), true)]));
    }
    public function kanban(Request $request)
    {
        $item = view("project.column.kanban", [])->render();
        return view("project.kanban.index", compact("item"));
    }
    public function kanban_data(Request $request)
    {
        $boads = [
            [
                "id" => '_new',
                'title' => 'New',
                'class'=>"light-danger",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Andrew Fuller" ])->render(),
                        'id' =>  1,
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Janet Leverling" ])->render(),
                        'id' =>  2,
                    ],
                ]
            ],
            [
                "id" => '_inprocess',
                'title' => 'In Process',
                'class'=>"light-primary",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Andrew Fuller" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Janet Leverling" ])->render(),
                    ],
                ]
            ],
            [
                "id" => '_working',
                'title' => 'To do',
                'class'=>"light-info",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Steven Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Nancy Davolio" ])->render(),
                    ],
                ]
            ],
            [
                "id" => '_done',
                'title' => 'Done',
                'class'=>"light-success",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Robert Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Laura Buchanan Milk" ])->render(),
                    ],
                ]
            ],
            [
                "id" => '_canceled',
                'title' => 'Cancel',
                'class'=>"light-dark",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Robert Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Laura Buchanan Milk" ])->render(),
                    ],
                ]
            ],
            [
                "id" => '_supended',
                'title' => 'Suspend',
                'class'=>"light-waring",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Robert Buchanan" ])->render(),
                        'id' =>  1,
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Laura Buchanan Milk" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Milk  Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Buchanan Robert Milk " ])->render(),
                    ],
                ]
            ],
            [
                "id" => '_deleted',
                'title' => 'Deleted',
                'class'=>"light-default",
                'item' => [
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Robert Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Laura Buchanan Milk" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Milk  Buchanan" ])->render(),
                    ],
                    [
                        'title' =>  view("project.kanban.item" , ["name" => "Buchanan Robert Milk " ])->render(),
                    ],
                ]
            ],

        ];
        return ["success" => true, "data" => $boads];
    }

    private function kanban_making_data(){
        $boads= [];

        
    }
}
