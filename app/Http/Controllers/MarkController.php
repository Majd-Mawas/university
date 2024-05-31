<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => Mark::all()
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
        $mark = new Mark;

        $user = User::findOrFail($request->user_id);

        if (isset($user)) {


            $mark->subject_id = $request->subject_id;
            $mark->test_id = $user->tests->first()->id;
            $mark->degree = $request->degree;

            $mark->save();

            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => [
                    "degree" => $mark->degree,
                    "subject_name" => $mark->subject->name
                ]
            ]);
        } else {
            return response()->json([
                "success" => false,
                "status" => 404,
                "data" => "user not found"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mark $mark)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $mark
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mark $mark)
    {
        $user = User::findOrFail($request->user_id);

        if (isset($user)) {

            $mark->subject_id = $request->subject_id;
            $mark->test_id = $user->tests->first()->id;
            $mark->degree = $request->degree;

            $mark->save();

            return response()->json([
                "success" => true,
                "status" => 200,
                "data" => [
                    "degree" => $mark->degree,
                    "subject_name" => $mark->subject->name
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mark $mark)
    {
        $mark->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => $mark
        ]);
    }
}
