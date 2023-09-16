<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    /**
     * Update Nationality by id
     * 
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'national_name' => 'required|string|max:50',
                'national_code' => 'required|string|max:2|unique:nationality,national_code,' . $id . ',national_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid input",
                    "errors" => $validator->errors()
                ], 400);
            }

            $natioanlity = Nationality::findOrFail($id);
            $natioanlity->update($request->all());

            return response()->json([
                "status" => "success",
                "message" => "natioanlity updated successfully",
                "data" => $natioanlity
            ]);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                "status" => "error",
                "message" => "nationality not found"
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Delete Nationality by id
     * 
     * @param string $id
     */
    public function delete($id)
    {
        try {
            $natioanlity = Nationality::findOrFail($id);
            $natioanlity->delete();

            return response()->json([
                "status" => "success",
                "message" => "natioanlity deleted successfully",
            ]);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                "status" => "error",
                "message" => "natioanlity not found"
            ], 404);
        } catch (QueryException $e) {
            error_log(print_r($e->getMessage(), true));
            if (str_contains($e->getMessage(), "violates foreign key constraint") === true) {
                return response()->json([
                    "status" => "error",
                    "message" => "natioanlity cannot be deleted because it is used by customer"
                ], 400);
            }

            return response()->json([
                "status" => "error",
                "message" => "something went wrong"
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
