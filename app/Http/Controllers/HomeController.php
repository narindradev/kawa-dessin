<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreRequestClient;
use App\Models\Project;
use App\Models\Project_assignment;
use App\Notifications\ProjectAssignedNotification;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index()
    {
        if ("allowed client request") {
            // dd((new Questionnaire())->preliminary_question());
            return view("home.step", ["questions" => (new Questionnaire())->preliminary_question(), "offers" => Offer::whereDeleted(0)->has("categories")->get()]);
        }
    }

    public function save(StoreRequestClient $request)
    {
       
        $descriptions = $this->validate_question($request);
        $client_type = $request->input("client_type");

        $user = User::create($request->only("first_name", "last_name", "email", "phone") + ["user_type_id" => 5,'password' => Hash::make("123456789")]);
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
        $project = $client->projects()->create(["status_id" => 1, "priority_id" => 1]);
        // Attach project category
        $project->categories()->attach([$request->input("categorie")]);
        $project->descriptions()->createMany($descriptions);
        if ($request->hasFile("files")) {
            $project->files()->createMany($this->attachements($request, $user->id, $project->id));
        }
        // Assination project to commerciale
        // $toCommercial = Project_assignment::getAssignTo('commercial');
        $project->members()->attach([12]);

        /** Notification */
        // User::find(12)->notify(new ProjectAssignedNotification($project));
        // $project->status = 3;
        // $project->save();
        die(json_encode(["success" => true, "message" => trans("lang.success_client_request")]));
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
