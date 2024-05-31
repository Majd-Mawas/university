<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Resources\Document_Resource;
use App\Http\Resources\Document_Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => new Document_Collection(Document::all())
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
        $document = new Document;

        $uploadedFiles = $request->document;
        $originalFileName = pathinfo($uploadedFiles->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = preg_replace('/\s+/', '', $originalFileName) . '-' . uniqid() . '.' . $uploadedFiles->getClientOriginalExtension();
        $uploadedFiles->storeAs('public/uploads/', $fileName);

        $filePath = 'uploads/' . $fileName;

        $document->path = $filePath;
        $document->title = $originalFileName;
        $document->description = $request->fileDescription;

        $document->save();


        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => new Document_Resource($document)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => new Document_Resource($document)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $document->description = $request->description;

        $document->save();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => new Document_Resource($document)

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if (Storage::exists('public/' . $document->path)) {

            Storage::delete('public/' . $document->path);
        } else {
            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "File not found"
            ], 404);
        }

        $document->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Document deleted successfully"
        ]);
    }
}
