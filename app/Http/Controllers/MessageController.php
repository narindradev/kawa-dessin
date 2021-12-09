<?php

namespace App\Http\Controllers;

use App\Models\File;
use Auth;
use Notification;
use App\Models\User;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Notifications\ChatProjectNotification;
use App\Notifications\ChatPrivateNotification;

class MessageController extends Controller
{
    protected $files;
    protected $per_page = 6;

    public function chat(Request $request)
    {
        $options = $request->all();
        $project_id = $request->project_id;
        $user_id = $request->user_id;
        if ($project_id) {
            $project = Project::find($project_id);
            $options['project'] = $project; 
        }
        $messages = Message::getDetails($options)->take($this->per_page)->get()->reverse();
        $auth = auth()->user();
        $per_page = $this->per_page;
        return [
            "view"=>view("messages.chat", compact("project_id", "messages", "auth" ,"per_page" ,"user_id"))->render() , 
            "info"=> !$project_id ? view("project.column.members", ["members" =>  User::where("id",$user_id )->get() , "for_user" => $auth])->render() : view("project.column.members", ["members" =>  get_cache_member($project) , "for_user" => $auth])->render(),
        ];
    }
    public function message(Request $request)
    {
        if ($request->project_id) {
            $message = $this->save_project_message($request);
        }
        if ($request->user_id) {
            $message = $this->save_private_message($request);
        }
        if ($request->group_id) {
            $message = $this->save_groupe_message($request);
        }
        return ["success" => true, "message" => trans("lang.message_sended"), "data" => view("messages.item", ["message" => $message, "my_message" => true ,"for_user" => auth()->user(),"need_load_more" => false])->render()];
    }
    private function save_project_message(Request $request){
        $project = Project::find($request->project_id);
        if ($request->hasFile("files")) {
            $this->uploads($request,$project);
        }
        $message = Message::create(["sender_id" => Auth::id(), "project_id" => $request->project_id, "content" => $request->message ,"files" => $this->files]);
        Notification::send(get_cache_member($project), new ChatProjectNotification($message, $project));
        return $message;
    }
    private function save_private_message(Request $request){
        $message = Message::create(["sender_id" => Auth::id() , "content" => $request->message ,"receiver_id" => $request->user_id]);
        if ($request->hasFile("files")) {
            $this->uploads($request,$message);
            $message->files = $this->files;
            $message->save();
        }
        Notification::send( User::find($message->receiver_id), new ChatPrivateNotification($message));
        return $message;
    }
    private function save_groupe_message(Request $request){
    }
    private function uploads($request , $object = null ){
        $attachements = [];
        $files = $request->file("files");
        $path = "uploads";
        if ($request->project_id) {
            $path = "project_files/$request->project_id";
        }
        foreach ($files as $file) {
            $file_info = upload($file,  $path, "local");
            if ($file_info["success"]) {
                unset($file_info["success"]);
                $file_info["created_by"] = auth()->id();
                $file_info["project_id"] = $request->project_id;
                $file_info["preliminary"] = 1;
                $attachements[] = $file_info;
            }
        }
        $this->files = $object->files()->createMany($attachements)->pluck("id")->implode(",");
    }
    public function mark_seen(Request $request)
    {
        $auth = auth()->id();
        $message = Message::whereRaw("NOT FIND_IN_SET($auth,seen_by)")->where("id" ,$request->id)->first();
        if ($message) {
            $message->seen_by = $message->seen_by . "," . $auth;
            $message->save();
        }
        return ["success" => true];
    }
    public function mark_deleted(Request $request)
    {
        $auth = auth()->id();
        $star_with = str_starts_with($request->id,"me-");
        $id = $request->id;
        if ($star_with){
            $id = str_replace("me-","",$request->id);
        }
        $message = Message::find($id);
        if ($message) {
            $star_with ? $message->deleted = 1 : ($message->deleted_by = $message->deleted_by . "," . $auth);
            $message->save();
        }
        return ["success" => true ,"id" => $message->id];
    }
    public function get_message(Request $request)
    {
        $message = Message::find($request->id);
        return["success" => true, "message_id" => $message->id  , "message" => view("messages.item" ,["message" => $message ,"my_message" => ($message->sender_id == auth()->id())  , "from_notification" => false ,"for_user" => auth()->user() ,"need_load_more" => false])->render()];
    }
    public function load_more(Request $request)
    {
        $options = $request->all(); $has_more = false; $html = ""; 
        $more = $this->per_page + 1; $auth = auth()->user();  $project_id = $request->project_id;
        if ($project_id){
            $options['project'] =  Project::find($project_id); 
        }
        $query = Message::getDetails($options);
        $offest = get_array_value($options, "offest");
        if ($offest){
            $query->skip($offest)->take($more);
        }
        $results = $query->get();
        if ($results->count() == $more){
            $has_more = true;
            $results= $results->take($this->per_page); // take only per page
        }
        foreach ($results->reverse() as $message) {
            $html.= view("messages.item" , ["message" => $message ,"my_message" => ($message->sender_id == $auth->id) ,"for_user" => $auth])->render();
        }
        return["success" => true,  "has_more" => $has_more,"offest" =>$offest + $this->per_page ,"data" =>  $html ,"message" => "Plus"];
    }
    /** Download file in chat private */
    public function download_file(File $file)
    {
        return response()->download(public_path($file->url), $file->originale_name);
    }
}