<?php

namespace App\Http\Controllers;

use Auth;
use Notification;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Notifications\ChatChannelNotification;

class MessageController extends Controller
{
    protected $files;

    public function chat(Request $request)
    {
        $project_id = $request->project_id;
        $messages = Message::getDetails($request->all())->get();
        $messages = $messages->reverse();
        $auth = auth()->user();
        return view("messages.chat", compact("project_id", "messages", "auth"));
    }
    public function message(Request $request)
    {
        if ($request->hasFile("files")) {
            $this->uploads($request);
        }
        $message = Message::create(["sender_id" => Auth::id(), "project_id" => $request->project_id, "content" => $request->message ,"files" => $this->files]);
        $project = Project::find($request->project_id);
        Notification::send(get_cache_member($project), new ChatChannelNotification($message, $project));
        return (["success" => true, "message" => trans("lang.message_sended"), "data" => view("messages.item", ["message" => $message, "my_message" => true ,"for_user" => auth()->user(),"need_load_more" => false])->render()]);
    }
    private function uploads($request){
        $attachements = [];
        $files = $request->file("files");
        foreach ($files as $file) {
            $file_info = upload($file, "project_files/$request->project_id", "local");
            if ($file_info["success"]) {
                unset($file_info["success"]);
                $file_info["created_by"] = auth()->id();
                $file_info["project_id"] = $request->project_id;
                $file_info["preliminary"] = 1;
                $attachements[] = $file_info;
            }
        }
        $this->files = Project::find($request->project_id)->files()->createMany($attachements)->pluck("id")->implode(",");
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
        if ($star_with) {
            $id = str_replace("me-","",$request->id);
        }else {
            $id = $request->id;
        }
        $message = Message::find($id);
        if ($message) {
            if ($star_with) {
                $message->deleted = 1;
            }else {
                $message->deleted_by = $message->deleted_by . "," . $auth;
            }
            $message->save();
        }
        return ["success" => true ,"id" => $message->id ];
    }
    public function get_message(Request $request)
    {
        $message = Message::find($request->id);
        return["success" => true, "message_id" => $message->id  , "message" => view("messages.item" ,["message" => $message ,"my_message" => ($message->sender_id == auth()->id())  , "from_notification" => false ,"for_user" => auth()->user() ,"need_load_more" => false])->render()];
    }
    public function load_more(Request $request)
    {
        $message = Message::getDetails($request->all())->get();
        $offest = $request->offest + $request->offest;
        return["success" => true, "more" =>  $message ,"offest" => $offest  ];
    }
}
