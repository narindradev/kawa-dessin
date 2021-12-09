<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreRequestClient;
use App\Jobs\CreateClientProjectJob;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index()
    {
        if ("allowed client request") {
            return view("home.step", ["questions" => (new Questionnaire())->preliminary_question(), "offers" => Offer::whereDeleted(0)->whereActive(1)->has("categories")->get()]);
        }
    }
    public function save(StoreRequestClient $request)
    {
        $descriptions = $this->validate_question($request);
        $client_type = $request->input("client_type");
        $user = User::create($request->only("first_name", "last_name", "email","phone", "address","city","zip") + ["user_type_id" => 5,'password' => Hash::make("123456789")]);
        // Create client of this user
        $client = $user->client()->create(['type' => $client_type]);
        // Save client info
        if ($client_type == "corporate") {
            $client->company()->create(
                [
                    "name" => $request->input("company_name"),
                    "address" => $request->input("company_head_office"),
                    "phone" => $request->input("company_phone"),
                    "zip" => $request->input("zip"),
                    "siret" => $request->input("siret"),
                    "num_tva" => $request->input("num_tva")
                ]
            );
        }
        //Save client project
        $project = $client->projects()->create(["status_id" => 1, "priority_id" => 1  ]);
        // Attach project category
        $project->categories()->attach($request->input("categorie"));
        $project->update(['estimate_price' , $project->categories->sum("estimate")] );
        $attachements = [];
        if ($request->hasFile("files")) {
            $attachements = $this->attachements($request, $user->id, $project->id);  
        }
        // Save project descritions and files uploaded jobs
        dispatch(new CreateClientProjectJob($project , $user ,$descriptions , $attachements));
        return ["success" => true, "message" => trans("lang.success_client_request")];
    }

    private function validate_question(StoreRequestClient $request)
    {
        $inputs = $inputs_name = [];
        foreach ((new Questionnaire())->preliminary_question() as $question) {
            $inputs_name[] = $question["name"];
            $inputs[$question["name"]] = 'required';
            $descriptions[] = ["questionnaire_id" => $question['id'], "answer" => $request->input($question["name"])];
        }
        $validator = Validator::make($request->all(), $inputs);
        if ($validator->fails()) {
            die(json_encode(["success" => false, "message" => trans("lang.required_all_response")]));
        }
        return $descriptions;
    }
    private function attachements($request, $created_by = 0, $project_id = 0)
    {
        $attachements = [];
        $files = $request->file("files");
        foreach ($files as $file) {
            $file_info = upload($file, "project_files/$project_id", "local");
            if ($file_info["success"]) {
                unset($file_info["success"]);
                $file_info["created_by"] = $created_by;
                $file_info["project_id"] = $project_id;
                $file_info["preliminary"] = 1;
                $attachements[] = $file_info;
            }
        }
        return $attachements;
    }
}
