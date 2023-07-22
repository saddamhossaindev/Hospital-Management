<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nurses = Nurse::all();
        return response()->json(['success' => true, 'nurses' => $nurses]);
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
            'email' => 'required|email|unique:nurses,email',
            'mobile' => 'required|max:11|unique:nurses,mobile',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
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
            $nurse = new Nurse();
            $nurse->first_name = $request->first_name;
            $nurse->last_name = $request->last_name;
            $nurse->email = $request->email;
            $nurse->mobile = $request->mobile;
            $nurse->password = Hash::make($request->password);
            $nurse->image = $request->image;
            $nurse->education = $request->education;
            $nurse->experience = $request->experience;
            $nurse->save();
            return response()->json(['success' => true, 'nurse' => $nurse]);
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
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function show($nurse)
    {
        $nurse = Nurse::find($nurse);
        if(!$nurse){
            return response()->json([
                'success' => 'false',
                'error' => 'No nurse found with the given ID.',
            ], 422);
        }
        return response()->json(['success' => true, 'nurse' => $nurse]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function edit(Nurse $nurse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nurse $nurse)
    {
        if(!$nurse){
            return response()->json([
                'success' => 'false',
                'error' => 'No nurse found with the given ID.',
            ], 422);
        }
        // validate the data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:nurses,email,' . $nurse->id,
            'mobile' => 'required|max:11|unique:nurses,mobile,' . $nurse->id,
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
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
            $nurse->first_name = $request->first_name;
            $nurse->last_name = $request->last_name;
            $nurse->email = $request->email;
            $nurse->mobile = $request->mobile;
            $nurse->password = Hash::make($request->password);
            $nurse->image = $request->image;
            $nurse->education = $request->education;
            $nurse->experience = $request->experience;
            $nurse->save();
            return response()->json(['success' => true, 'nurse' => $nurse]);
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
     * @param  \App\Models\Nurse  $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy($nurse)
    {
        $nurse = Nurse::find($nurse);
        if(!$nurse){
            return response()->json([
                'success' => 'false',
                'error' => 'No nurse found with the given ID.',
            ], 422);
        }

        try{
            $nurse->delete();
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
