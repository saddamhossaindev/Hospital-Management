<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        // validate the data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'mobile' => 'required|max:11|unique:doctors,mobile',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
            'department' => 'required',
            'education' => 'required',
            'experience' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            // store in the database
            $doctor = new Doctor();
            $doctor->first_name = $request->first_name;
            $doctor->last_name = $request->last_name;
            $doctor->email = $request->email;
            $doctor->mobile = $request->mobile;
            $doctor->password = Hash::make($request->password);
            $doctor->image = $request->image;
            $doctor->department = $request->department;
            $doctor->education = $request->education;
            $doctor->experience = $request->experience;
            $doctor->save();
            return response()->json(['success' => true, 'doctor' => $doctor]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => 'false',
                'error' => 'Server error occurred.',
            ], 422);
        }
    }

    public function update(Request $request)
    {
        
    }

    public function delete(Request $request)
    {
        
    }

    public function list(Request $request)
    {
        
    }
}
