<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInsurerRequest;
use App\Http\Requests\UpdateInsurerRequest;
use App\Models\Insurer;

class InsurerController extends Controller
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
     * @param  \App\Http\Requests\StoreInsurerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInsurerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insurer  $insurer
     * @return \Illuminate\Http\Response
     */
    public function show(Insurer $insurer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Insurer  $insurer
     * @return \Illuminate\Http\Response
     */
    public function edit(Insurer $insurer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInsurerRequest  $request
     * @param  \App\Models\Insurer  $insurer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInsurerRequest $request, Insurer $insurer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Insurer  $insurer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insurer $insurer)
    {
        //
    }
}
