<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Support\Facades\Hash;

use JWTFactory;
use JWTAuth;
use Validator;
use Response;




class HrController extends Controller
{


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function employees()
    {
        if (Auth::user()->role == 1) {


         $allEmployees = User:: join('user_details', 'users.id', '=', 'user_details.id')
         ->select(['users.id','users.name','users.email','users.role','users.status','user_details.jobTitle',
         'user_details.mobile','user_details.country','user_details.city'
         ])->paginate(15);

         return response()->json([
            'All Employees' => $allEmployees
        ], 200);


        } else {


            return response()->json([
                'message' => 'You are not HR'
            ], 401);




        }
    }

    public function newEmployee(Request $request)
    {

        if (Auth::user()->role == 1) {


        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:2500|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'jobtitle' => 'required|string|max:255',
            'mobile' => 'required|string|max:25',
            'country' => 'required|string|max:25',
            'city' => 'required|string|max:25',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        $userDetails = new User_detail;
        $userDetails->jobTitle = $request->jobtitle;
        $userDetails->mobile = $request->mobile;
        $userDetails->country = $request->country;
        $userDetails->city = $request->city;
        $userDetails->save();

                if($user && $userDetails){

                    return response()->json([
                        'message' => 'New Employee Successfully Registered',
                        'User Name' => $user->name
                    ], 201);
                }


        }else{

            return response()->json([
                'message' => 'You are not HR'
            ], 401);

        }


    }


    public function updateState(Request $request)
    {


        if (Auth::user()->role == 1) {


            $validated = $request->validate([
                'id' => 'required|integer',
                'status' => 'required|max:1|integer',
            ]);

            $updateStatus = User::where('id', request('id'))
            ->update(['status' =>  request('status')]);
            if ($updateStatus) {

                return response()->json([
                    'message' => 'Employee Status Successfully Updated'
                ], 201);

            }

        }else{

            return response()->json([
                'message' => 'You are not HR'
            ], 401);
        }


    }


    public function deleteEmployee(Request $request)
    {

        if (Auth::user()->role == 1) {

            $validated = $request->validate([
                'id' => 'required|integer',
            ]);

            $deleteUser = User::find(request('id'));
            $deleteUser->delete();

            if ($deleteUser) {

                return response()->json([
                    'message' => 'Employee Successfully Deleted'
                ], 201);

            }




        }else{

            return response()->json([
                'message' => 'You are not HR'
            ], 401);

        }


    }



    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
