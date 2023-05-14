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

    public function update(Request $request)
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
        $language = NativeLanguage::update([
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
}
