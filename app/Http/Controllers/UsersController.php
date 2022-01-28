<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view("users.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data_list(){
        $data = [];
        $users = User::where("user_type_id","<>",5)->get();
      
        foreach ($users as $user) {
          $data[] = $this->_make_row($user);
        }
        return ["data" => $data];
    }

    public function _make_row($user){
        return [
            "name" => view("users.columns.name",["user" => $user])->render(),
            "email" => $user->email,
            "fonction" => $user->type->description,
            "actions" => "",
        ];
    }

    public function form()
    {
        return view("users.form",["user_type" => UserType::dropdown(UserType::where("name","<>","client")->get())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    
    {
       
        $user = User::create($request->only("first_name", "last_name", "email","user_type_id") + ['password' => Hash::make("123456789")]);
        $new_user =  $user;
        die(json_encode(["success" => true, "message" => trans("lang.success_record") , "data" =>$this->_make_row( $new_user ) ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $config = theme()->getOption('page');
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = theme()->getOption('page', 'edit');

        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function email_exist(Request $request)
    {
        echo User::whereDeleted(0)->whereEmail($request->input("email"))->first() ? json_encode(['valid' => false]) :  json_encode(['valid' => true]);
    }

    public function send_email(Request $request)
    {
        try {
            Mail::send("settings.email-test", [], function ($message) use ($request) {
                $message->to($request->to)->subject('Test envoi mail');
                $message->from(app_setting("sender_mail"),app_setting("app_name"));
            });
            if( count(Mail::failures()) ) {
                die(json_encode(["success" => false, "type" => "test" , "message" => "Erreur! verifier bien les email ou le mot de passe ou faire une configuration dans l'email donnée"]));
                
            } else {
                 die(json_encode(["success" => true, "type" => "test" , "message" => " E-mail bien envoyé"]));
             }
        } catch (Exception $e) {
            die(json_encode(["success" => false, "type" => "test"  ,"message" => $e->getMessage()]));
        }
    }
    public function save_theme_mode(Request $request)
    {
        Auth::user()->update(["theme_mode" => $request->skin ? "dark" :"default" ]);
        return Redirect::back();
    }
}
