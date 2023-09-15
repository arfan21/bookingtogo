<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationalityController extends Controller
{
    /**
     * Create nationality
     * 
     * @param Request $request
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'national_name' => 'required|string|max:50',
                'national_code' => 'required|string|max:2|unique:nationality,national_code',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid input",
                    "errors" => $validator->errors()
                ], 400);
            }

            $data = $request->all();


            $nationality = Nationality::create($data);

            return response()->json([
                "status" => "success",
                "message" => "nationality created successfully",
                "data" => $nationality
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get all nationalities
     * 
     * @param Request $request
     */
    public function getAll()
    {
        try {
            $data = Nationality::all(['national_id', 'national_name', 'national_code']);

            return response()->json([
                "status" => "success",
                "message" => "nationalities retrieved successfully",
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
