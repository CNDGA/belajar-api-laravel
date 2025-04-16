<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employees::orderBy('id', 'desc')->get();
            return response()->json(['success' => true, 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('Failed to fetch data employees : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }
        try {

            $employees = Employees::create([
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'gender' => $request->gender,
            ]);
            return response()->json(['success' =>  true, 'message' => 'Employees added success', 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('failed insert : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed Create Employees'], 500);
            //throw $th;
        }
    }


    public function show($id)
    {
        try {
            $employee = Employees::with('user')->findOrFail($id);
            return response()->json(['success' => true, 'message' => 'Show Data Success', 'Data' => $employee]);
        } catch (\Throwable $th) {
            Log::error('Failed Show : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }
        try {

            $employees = Employees::findOrFail($id);

            $data = [
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'gender' => $request->gender,
            ];

            $employees->update($data);

            return response()->json(['success' =>  true, 'message' => 'Employees added success', 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('failed Update : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed Create Employees'], 500);
            //throw $th;
        }
    }
}
