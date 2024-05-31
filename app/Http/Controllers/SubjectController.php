<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => Subject::all()
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
        $subject = new Subject;

        $subject->name = $request->name;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $subject
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $subject
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {

        $subject->name = $request->name;

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $subject
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {

        $subject->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $subject
        ]);
    }
}
