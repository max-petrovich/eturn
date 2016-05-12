<?php

namespace App\Http\Controllers;

use App\Entities\UserData;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('profile.form',[
            'pageTitle' => trans('user.profile'),
            'user' => User::with('data')->find($request->user()->id),
            'minimum_serivce_durations' => UserData::minimumServiceDurations()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('profile.index')->with('message', trans('user.profile_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
