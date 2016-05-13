<?php

namespace App\Http\Controllers;

use App\Entities\UserData;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index(Request $request)
    {
        return redirect()->route('profile.edit', $request->user()->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->user()->id != $id && !$request->user()->isAdmin()) {
            return redirect()->route('profile.index');
        }

        return view('profile.form',[
            'pageTitle' => trans('user.profile'),
            'user' => User::with('data')->find($id),
            'minimum_serivce_durations' => UserData::minimumServiceDurations(),
        ]);
    }

    public function update(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->except(['password']));

        if ($request->hasFile('photo')) {
            $photo = Image::make($request->file('photo'));
            $photo->fit(230,230)->save(storage_path('app/public/images/users/') . $id . '.jpg');

            $user->photo = $id . '.jpg';
        }

        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->has('data')) {
            $user->data->fill($request->get('data'));
        }

        $user->push();

        return redirect()->route('profile.edit', $user->id)->with('message', trans('user.profile_updated'));
    }

    public function makeMaster($id)
    {
        $client = User::role('client')->findOrFail($id);

        $client->detachAllRoles();
        $client->attachRole(2);
        
        return redirect()->route('profile.edit', $client->id)->with('message', trans('user.profile_updated'));
    }

}
