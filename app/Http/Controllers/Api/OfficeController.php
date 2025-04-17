<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Offices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast;

class OfficeController extends Controller
{
    public function index()
    {
        try {
            $employees = Offices::orderBy('id', 'desc')->get();
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
            'office_name' => 'required',
            'office_lat' => 'required',
            'office_long' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }
        try {

            $offices = Offices::create([
                'office_name' => $request->office_name,
                'office_phone' => $request->office_phone,
                'office_address' => $request->office_address,
                'office_lat' => $request->office_lat,
                'office_long' => $request->office_long,
                'is_active' => $request->is_active,
            ]);
            return response()->json(['success' =>  true, 'message' => 'Offices added success', 'data' => $offices]);
        } catch (\Throwable $th) {
            Log::error('failed insert : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed Create offices'], 500);
            //throw $th;
        }
    }


    public function show($id)
    {
        try {
            $offices = Offices::findOrFail($id);
            return response()->json(['success' => true, 'message' => 'Show Data Success', 'Data' => $offices]);
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
            'office_name' => 'required',
            'offlice_lat' => 'required',
            'offlice_long' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }
        try {

            $offices = Offices::findOrFail($id);

            $data = [
                'office_name' => $request->office_name,
                'office_phone' => $request->office_phone,
                'office_address' => $request->office_address,
                'office_lat' => $request->office_lat,
                'office_long' => $request->office_long,
                'is_active' => $request->is_active,
            ];

            $offices->update($data);

            return response()->json(['success' =>  true, 'message' => 'offices added success', 'data' => $offices]);
        } catch (\Throwable $th) {
            Log::error('failed Update : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed Create offices'], 500);
            //throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Offices::find($id)->delete();
            return response()->json(['message' => 'Offices delete success']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
