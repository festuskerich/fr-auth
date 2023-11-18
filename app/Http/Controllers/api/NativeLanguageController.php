<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\helper\CustomResponse;
use App\Models\NativeLanguage;

class NativeLanguageController extends Controller
{

    public function index()
    {
        return response()->json(
            new CustomResponse(
                "Fetch successfully",
                true,
                200,
                NativeLanguage::all(),
                200
            )
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'residence' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                new CustomResponse("Validation errors", false, 400, $validator->errors()),
                400
            );
        }
        $language = NativeLanguage::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'residence' => $request['residence'],
        ]);
        if ($language) {
            return response()->json(
                new CustomResponse("Language added successfully", true, 200, null),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the language contact support", false, 500, null),
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
        $language = NativeLanguage::find($id);
        if ($language == null) {
            return response()->json(
                new CustomResponse("Language with id $id is not found", true, 200),
                200
            );
        }
        foreach ($fieldsToUpdate as $key => $value) {
            $language->$key = $value;
        }
        $language->save();
        if ($language) {
            return response()->json(
                new CustomResponse("Language added successfully", true, 200),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the language contact support", false, 500),
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
        $language = NativeLanguage::findOrFail($id);

        if ($language) {
            return response()->json(
                new CustomResponse("Language fetched successfully", true, 200, $language),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the language contact support", false, 500),
                500
            );
        }
    }
}
