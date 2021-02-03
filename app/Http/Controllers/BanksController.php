<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BanksController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
        $success = false;
        if ($request->filled('name') && $request->bank != 0) {
            if ($bank->name != $request->name) $bank->name = $request->name;

            if ($bank->save()) {
                $success = true;
            } else {
                $success = false;
            }
        }

        if ($success) {
            flash("Bank details " . trans('feedback.update_success'))->success();
        } else {
            flash(trans('feedback.update_error'))->error();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //

        if ($bank->delete()) {
            flash("Bank " . trans('feedback.deleted_success'))->success();
        } else {
            flash(trans('feedback.delete_error'))->error();
        }

        return back();
    }

    public function update_primary(Request $request)
    {
        // Update primary banks
        $success = false;
        $banks = Bank::where('is_primary', 1)->first();
        if (!empty($banks)) {
            $banks->is_primary = 0; //remove primary bank
        } else {
            $success = true;
        }

        if ($request->bank == 0) {
            // if no primary bank set, let it remain so
        } else {
            $banks = Bank::where('id', $request->bank)->first();
            $banks->is_primary = 1;
        }

        if ($banks->save()) {
            $success = true;
        } else {
            $success = false;
        }

        if ($success) {
            flash("Bank details " . trans('feedback.update_success'))->success();
        } else {
            flash(trans('feedback.update_error'))->error();
        }
        return back();
    }
}
