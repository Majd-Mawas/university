<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => Test::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $test = new Test;

        $test->test_administration = $request->test_administration;
        $test->tested_on = $request->tested_on;
        $test->record_locater = $request->record_locater;
        $test->total_score = $request->total_score;
        $test->user_id = $request->user_id;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $test
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $test
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $test->test_administration = $request->test_administration;
        $test->tested_on = $request->tested_on;
        $test->record_locater = $request->record_locater;
        $test->total_score = $request->total_score;
        $test->user_id = $request->user_id;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $test
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $test
        ]);
    }
}
