<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\helper\CustomResponse;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (is_null($id)) {
            return response()->json(
                new CustomResponse("Id is missing", false, 400, null),
                400
            );
        }
        $user = User::where('id', $id)->get();

        if ($user->isEmpty()) {
            return response()->json(
                new CustomResponse("User not found", true, 404, $user),
                404
            );
        }

        if ($user) {
            return response()->json(
                new CustomResponse("Proverb fetched successfully", true, 200, $user),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the proverb contact support", false, 500, null),
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
