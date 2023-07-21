<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();
        return response()->json(['success' => true, 'patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'mobile' => 'required|max:11|unique:patients,mobile',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            // store in the database
            $patient = new Patient();
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->email = $request->email;
            $patient->mobile = $request->mobile;
            $patient->password = Hash::make($request->password);
            $patient->image = $request->image;
            $patient->save();
            return response()->json(['success' => true, 'patient' => $patient]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => 'false',
                'error' => 'Server error occurred.',
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show($patient)
    {
        $patient = Patient::find($patient);
        if(!$patient){
            return response()->json([
                'success' => 'false',
                'error' => 'No patient found with the given ID.',
            ], 422);
        }
        return response()->json(['success' => true, 'patient' => $patient]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        if(!$patient){
            return response()->json([
                'success' => 'false',
                'error' => 'No patient found with the given ID.',
            ], 422);
        }
        // validate the data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'mobile' => 'required|max:11|unique:patients,mobile,' . $patient->id,
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            // store in the database
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->email = $request->email;
            $patient->mobile = $request->mobile;
            $patient->password = Hash::make($request->password);
            $patient->image = $request->image;
            $patient->save();
            return response()->json(['success' => true, 'patient' => $patient]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => 'false',
                'error' => 'Server error occurred.',
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($patient)
    {
        $patient = Patient::find($patient);
        if(!$patient){
            return response()->json([
                'success' => 'false',
                'error' => 'No patient found with the given ID.',
            ], 422);
        }

        try{
            $patient->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => 'false',
                'error' => 'Server error occurred.',
            ], 422);
        }
    }
}
