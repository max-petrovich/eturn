<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClosedDate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClosedDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $closedDates = ClosedDate::orderBy('closed_date')->get();
        
        return view('admin.closedDate.index',[
            'pageTitle' => trans('admin.closed_date'),
            'closedDates' => $closedDates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.closedDate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'closed_date' => 'required'
        ]);

        ClosedDate::create(['closed_date' => $request->input('closed_date')]);

        return redirect()->route('admin.closedDates.index')->with('message', trans('admin_closedDate.date_added', ['date' => $request->input('closed_date')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $closedDate = ClosedDate::findOrFail($id);
        $closedDate->delete();
        return back()->with('message', trans('admin_closedDate.date_deleted', ['date' => $closedDate->closed_date->format('d-m-Y')]));
    }
}
