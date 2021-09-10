<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offer;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreRequestClient;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
  
    public function index()
    {
        if ("allowed client request") {
            return view("home.step" , ["questions" => (new Questionnaire())->preliminary_question(), "offers" => Offer::whereDeleted(0)->has("categories")->get()]);
        }
    }

    public function request(StoreRequestClient $request){
        $this->validate_question($request);
        $client_type = $request->input("client_type");
        if($request->hasFile("files")){
            $files = $request->file("files");
            foreach ($files as $file) {
                upload($file);
            }
        }
        //Create user
        $user = User::create($request->only("first_name","last_name","email","phone") + ['password' => Hash::make("123456789")]);
        // Create client of this user
        $user->client()->create(['type' => $client_type]);
        // Save client info
        if( $client_type == "corporate"){
            $user->client->company()->create(
                [
                    "name" => $request->input("company_name"),
                    "address" => $request->input("company_head_office"),
                    "phone" => $request->input("company_phone"),
                    "zip" => $request->input("zip"),
                    "siret" => $request->input("siret"),
                    "num_tva" => $request->input("num_tva")
                ]);
        }
        //Save client project
        $project = $user->client->projects()->create(["status_id" => 1 ,"priority_id" => 1]);
        // Attach project category
        $project->categories()->attach([$request->input("categorie")]);
        // 
        die(json_encode(["success" => true , "message" => trans("lang.success_client_request")]));

    }
    private function validate_question(StoreRequestClient $request){
        $inputs = $inputs_name = [];
        foreach ((new Questionnaire())->preliminary_question() as $question) {
            $inputs_name[] = $question["value"]; 
            $inputs[$question["value"]] = 'required';
        }
        $validator = Validator::make($request->all(),$inputs);
        if($validator->fails()){
            die(json_encode(["success" => false ,"message" => trans("lang.required_all_response")]));
        }
    }
}
