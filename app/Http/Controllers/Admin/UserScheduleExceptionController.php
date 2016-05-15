<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserScheduleException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserScheduleExceptionController extends Controller
{

    public function create($master_id)
    {
        $master = User::role('master')->findOrFail($master_id);

        return view('admin.userScheduleException.index',[
            'pageTitle' => trans('admin.user_schedule_exceptions'),
            'master' => $master
        ]);
    }


    public function store(Request $request, $master_id)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'exception_type' => 'required|boolean',
            'time_start' => 'required_if:exception_type,1|date_format:H:i',
            'time_end' => 'required_if:exception_type,1|date_format:H:i'
        ]);

        $master = User::role('master')->findOrFail($master_id);

        $scheduleException = new UserScheduleException;
        $scheduleException->exception_date = $request->input('date');

        if ($request->input('exception_type') == 1) {
            $scheduleException->fill($request->only(['time_start', 'time_end']));
        } else {
            $scheduleException->time_start = null;
            $scheduleException->time_end = null;
        }
        $scheduleException->user()->associate($master);

        $scheduleException->save();
        
        return redirect()->route('admin.userSchedule.edit', [$master->id])->with('message', trans('admin_userScheduleException.exception_success_added'));
    }
    
    public function destroy($master_id, $exception_id)
    {
        $master = User::findOrFail($master_id);
        $scheduleException = $master->scheduleException()->find($exception_id);
        $scheduleException->delete();

        return redirect()->route('admin.userSchedule.edit', [$master->id])->with('message', trans('admin_userScheduleException.exception_success_deleted'));
    }
}
