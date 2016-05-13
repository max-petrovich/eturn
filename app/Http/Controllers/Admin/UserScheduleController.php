<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = User::role('master')->get();

        return view('admin.userSchedule.index', [
            'pageTitle' => trans('admin_userSchedule.user_schedule'),
            'masters' => $masters
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master = User::role('master')->findOrFail($id);

        $schedule = $master->schedule;
        $scheduleExceptions = $master->scheduleException()->orderBy('exception_date')->get();

        return view('admin.userSchedule.edit', [
            'pageTitle' => trans('admin_userSchedule.editing_user_schedule'),
            'master' => $master,
            'schedule' => $schedule,
            'scheduleExceptions' => $scheduleExceptions
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $master = User::role('master')->findOrFail($id);

        $this->validate($request, [
            'schedule.*.time_start' => 'dateFormat:H:i',
            'schedule.*.time_end' => 'dateFormat:H:i'
        ]);

        foreach ($request->input('schedule') as $scheduleWeekday=>$schedule) {
            $userSchedule = $master->schedule()->whereWeekday($scheduleWeekday)->first();

            if (empty($schedule['time_start']) || empty($schedule['time_end'])) {
                $userSchedule->time_start = null;
                $userSchedule->time_end = null;
            } else {
                $userSchedule->fill($schedule);
            }

            $userSchedule->save();
        }

        return redirect()->route('admin.userSchedule.edit', $master->id)->with('message', trans('admin_userSchedule.schedule_success_updated'));
    }

}
