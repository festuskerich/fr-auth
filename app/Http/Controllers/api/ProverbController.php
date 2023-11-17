<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\helper\CustomResponse;
use App\Models\Proverb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ProverbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Proverb::paginate(2);
        return response()->json(
            new CustomResponse("Fetch successfully", true, 200, $data),
            200
        );
    }
    /**
     * Search function
     * @keyword
     *
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                new CustomResponse("Validation errors", false, 400, $validator->errors()),
                400
            );
        }

        $proverb = Proverb::query();

        if (!is_null($request->keyword)) {
            $proverb->orWhere("local_proverb", "LIKE", "%{$request->keyword}%");
            $proverb->orWhere("eng_transalion", "LIKE", "%{$request->keyword}%");
        }
        if (!is_null($request->local_proverb)) {
            $proverb->orWhere("local_proverb", "LIKE", "%{$request->keyword}%");
        }
        if (!is_null($request->local_proverb)) {
            $proverb->orWhere("eng_transalion", "LIKE", "%{$request->keyword}%");
        }

        return response()->json(
            new CustomResponse("Fetched successfully", true, 200, $proverb->get()),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info("===============================");
        $validator = Validator::make($request->all(), [
            'localProverb' => 'required',
            'language_id' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(
                new CustomResponse("Validation errors", false, 400, $validator->errors()),
                400
            );
        }
        $proverb = Proverb::create([
            'local_proverb' => $request['localProverb'],
            'language_id' => $request['language_id']
        ]);
        if ($proverb) {
            return response()->json(
                new CustomResponse("Proverb added successfully", true, 200, null),
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
        $proverb = Proverb::findOrFail($id);

        if ($proverb) {
            return response()->json(
                new CustomResponse("Proverb fetched successfully", true, 200, $proverb),
                200
            );
        } else {
            return response()->json(
                new CustomResponse("Error occured while adding the proverb contact support", false, 500, null),
                500
            );
        }
    }
}
