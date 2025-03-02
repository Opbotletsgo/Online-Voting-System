<?php

namespace App\Http\Controllers\Api;

use App\Models\Voter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class VoterController extends Controller
{
    public function index()
    {

        $voters = Voter::all();

        if ($voters->count() > 0) {
            return response()->json([
                'status' => 200,
                'voters' => $voters
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found'
            ], 404);
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'roll' => 'required|integer|max:191',
            'semester' => 'required|string|max:191',
            'password' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else{
            $voter = Voter::create([
                'name' => $request->name,
                'roll' => $request->roll,
                'semester' => $request->semester,
                'password' => $request->password,
            ]);

            if($voter){
                return response()->json([
                    'status' => 200,
                    'message' => "Voter Created Successfully"
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ], 500);
            }
        }
    }
    public function destroy($id){
        $voter = Voter::find($id);
        if($voter){
            $voter->delete();
            return response()->json([
                'status' => 200,
                'message' => "Voter deleted Successfully."
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Voter Found!"
            ], 404);
        }
    }
}
