<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\helper\CustomResponse;
use App\Models\Subtribe;
use Illuminate\Support\Facades\Validator;

class SubtribeController extends Controller
{
    public function index()
    {
        return response()->json(
            new CustomResponse(
                "Fetch successfully",
                true,
                200,
                Subtribe::all(),
                200
            )
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(
                new CustomResponse("Validation errors", false, 400, $validator->errors()),
                400
            );
        }
        $subtribe = Subtribe::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'residence' => $request['residence'],
        ]);
        if ($subtribe) {
            return response()->json(
                new CustomResponse("subtribe added successfully", true, 200, null),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the subtribe contact support", false, 500, null),
                500
            );
        }
    }

    public function update($id, Request $request)
    {
        $fieldsToUpdate = [];
        $updateableFields = ['name', 'description', 'residence'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $updateableFields)) {
                $fieldsToUpdate[$key] = $value;
            }
        }
        $subtribe = Subtribe::find($id);
        if ($subtribe == null) {
            return response()->json(
                new CustomResponse("subtribe with id $id is not found", true, 200),
                200
            );
        }
        foreach ($fieldsToUpdate as $key => $value) {
            $subtribe->$key = $value;
        }
        $subtribe->save();
        if ($subtribe) {
            return response()->json(
                new CustomResponse("subtribe added successfully", true, 200),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the subtribe contact support", false, 500),
                500
            );
        }
    }
    public function show(string $id)
    {

        if (is_null($id)) {
            return response()->json(
                new CustomResponse("Id is missing", false, 400),
                400
            );
        }
        $subtribe = Subtribe::findOrFail($id);

        if ($subtribe) {
            return response()->json(
                new CustomResponse("Subtribe fetched successfully", true, 200, $subtribe),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the Subtribe contact support", false, 500),
                500
            );
        }
    }
}
