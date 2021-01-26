<?php

namespace App\Http\Controllers;

use App\Models\TaxGroup;
use Illuminate\Http\Request;

class TaxGroupsController extends Controller
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
            'name' => 'bail|required|unique:tax_groups,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = new TaxGroup;
            $create->create($input);

            flash('Tax Group added successfully!')->success();
        } catch (\Throwable $th) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function show(TaxGroup $taxGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxGroup $taxGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaxGroup $taxGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxGroup $taxGroup)
    {
        //
    }
}
