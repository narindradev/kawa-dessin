<?php

namespace App\Http\Controllers\Account;

use App\Models\UserInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Account\SettingsInfoRequest;
use App\Http\Requests\Account\SettingsEmailRequest;
use App\Http\Requests\Account\SettingsPasswordRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()

    {
        return view('pages.account.settings.settings', ["info" =>  Auth::user()]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingsInfoRequest $request)
    {
        $data = [];
        if ($avatar = $this->upload()) {
            $data["avatar"] = $avatar;
        }
        if ($request->boolean('avatar_remove')) {
            // Storage::delete($info->avatar);
            $data["avatar"] = null;
        }
        Auth::user()->update($request->except("_token" ,"avatar_remove","avatar") + $data);
        return['success' => true , "message" => trans("lang.success_update_info_user")];
        // return redirect()->intended('account/settings');
    }
    /**
     * Function for upload avatar image
     *
     * @param  string  $folder
     * @param  string  $key
     * @param  string  $validation
     *
     * @return false|string|null
     */
    public function upload($folder = 'avatars', $key = 'avatar', $validation = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes')
    {
        request()->validate([$key => $validation]);
        $file = null;
        if (request()->hasFile($key)) {
            $file_info  = upload(request()->file($key),$folder ,"public");
            return $file_info["name"];
        }
        return $file;
    }

    /**
     * Function to accept request for change email
     *
     * @param  SettingsEmailRequest  $request
     */
    public function changeEmail(SettingsEmailRequest $request)
    {
        Auth::user()->update(['email' => $request->input('email')]);
        return['success' => true , "message" => trans("lang.success_update_email")];
        // return redirect()->intended('account/settings');
    }
    /**
     * Function to accept request for change password
     *
     * @param  SettingsPasswordRequest  $request
     */
    public function changePassword(SettingsPasswordRequest $request)
    {
       
        Auth::user()->update(['password' => Hash::make($request->input('password'))]);
        return['success' => true , "message" => trans("lang.success_update_pwd")];
        // return redirect()->intended('account/settings');
    }
}
