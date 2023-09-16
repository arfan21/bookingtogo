<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Nationality;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Create customer
     * 
     * @param Request $request
     */
    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'national_id' => 'required',
                'cst_name' => 'required|string|max:50',
                'cst_dob' => 'required|date',
                'cst_phoneNum' => 'required|string|max:20',
                'cst_email' => 'required|string|max:50|unique:customer,cst_email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid input",
                    "errors" => $validator->errors()
                ], 400);
            }

            // check family list
            if ($request->has('family_list')) {
                $dataDecoded = json_decode($request->getContent(), false);

                if (!is_array($dataDecoded->family_list)) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Invalid input",
                        "errors" => [
                            "family_list" => ["The family list must be an array."]
                        ]
                    ], 400);
                }

                if (count($dataDecoded->family_list) > 0) {
                    $validator = Validator::make($data, [
                        'family_list.*.fl_relation' => 'required|string|max:20',
                        'family_list.*.fl_dob' => 'required|date',
                        'family_list.*.fl_name' => 'required|string|max:50',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Invalid input",
                            "errors" => $validator->errors()
                        ], 400);
                    }
                }
            }

            // check nationality  exists
            Nationality::findOrFail($request->input('national_id'));

            $customer = Customer::create($data);

            if ($request->has('family_list')) {
                $familyList = $request->input('family_list');
                $customer->familyList()->createMany($familyList);
            }

            $customer->family_list = $customer->familyList()->get();
            $customer->nationality = $customer->nationality()->first();

            return response()->json([
                "status" => "success",
                "message" => "customer created successfully",
                "data" => $customer
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
     * Update customer
     * 
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id)
    {
        try {
            Customer::findOrFail($id);
            $data = $request->all();
            $validator = Validator::make($data, [
                'national_id' => 'required',
                'cst_name' => 'required|string|max:50',
                'cst_dob' => 'required|date',
                'cst_phoneNum' => 'required|string|max:20',
                'cst_email' => 'required|string|max:50|unique:customer,cst_email,' . $id . ',cst_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid input",
                    "errors" => $validator->errors()
                ], 400);
            }

            // check family list
            if ($request->has('family_list')) {
                $dataDecoded = json_decode($request->getContent(), false);

                if (!is_array($dataDecoded->family_list)) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Invalid input",
                        "errors" => [
                            "family_list" => ["The family list must be an array."]
                        ]
                    ], 400);
                }

                if (count($dataDecoded->family_list) > 0) {
                    $validator = Validator::make($data, [
                        'family_list.*.fl_relation' => 'required|string|max:20',
                        'family_list.*.fl_dob' => 'required|date',
                        'family_list.*.fl_name' => 'required|string|max:50',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Invalid input",
                            "errors" => $validator->errors()
                        ], 400);
                    }
                }
            }

            // check nationality  exists
            Nationality::findOrFail(['national_id' => $data['national_id']]);

            // update customer
            $customer = Customer::findOrFail($id);
            $customer->update($data);

            // update family list
            if ($request->has('family_list')) {
                $familyList = $request->input('family_list');
                $customer->familyList()->delete();
                $customer->familyList()->createMany($familyList);
            }

            $customer->family_list = $customer->familyList()->get();
            $customer->nationality = $customer->nationality()->first();

            return response()->json([
                "status" => "success",
                "message" => "customer updated successfully",
                "data" => $customer
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
     * Get all customers
     * 
     */
    public function getAll()
    {
        $data = Customer::all(["cst_id", "cst_name", "cst_dob", "cst_phoneNum", "cst_email", "created_at"]);
        return response()->json([
            "status" => "success",
            "message" => "customers retrieved successfully",
            "data" => $data
        ]);
    }

    /**
     * Get customer by id
     * 
     * @param string $id
     */
    public function getById(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->family_list = $customer->familyList()->get();

            return response()->json([
                "status" => "success",
                "message" => "customer retrieved successfully",
                "data" => $customer
            ]);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                "status" => "error",
                "message" => "customer not found"
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Delete customer by id
     * 
     * @param string $id
     */
    public function delete(string $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json([
                "status" => "success",
                "message" => "customer deleted successfully",
            ]);
        } catch (ModelNotFoundException  $e) {
            return response()->json([
                "status" => "error",
                "message" => "customer not found"
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => $th->getMessage()
            ], 500);
        }
    }
}
