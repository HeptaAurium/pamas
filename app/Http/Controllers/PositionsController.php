<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'name' => 'bail|required|unique:staff_positions,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = new Position;
            $create->create($input);

            flash('Position added successfully!')->success();
        } catch (\Throwable $th) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //

        if($position->name != $request->name){
            $position->name = $request->name;

            if($position->save()){
                flash(trans('feedback.update_success'))->success();
            }else{
                flash(trans('feedback.update_error'))->error();
            }
        }else{
            flash('No change detected!')->warning();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
        
        if ($position->delete()) {
            flash("Position " . trans('feedback.deleted_success'))->success();
        } else {
            flash(trans('feedback.delete_error'))->error();
        }

        return back();
    }
}
