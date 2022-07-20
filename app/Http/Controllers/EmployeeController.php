<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_detail;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;


class EmployeeController extends Controller
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



    public function profile()
    {

        $user = User:: join('user_details', 'users.id', '=', 'user_details.id')
        ->select(['users.id','users.name','users.email','users.role',
        'users.status','user_details.jobTitle',
        'user_details.mobile','user_details.country','user_details.city'])
        ->where('users.id',JWTAuth::user()->id)
        ->get();

        return response()->json([
            'user' => $user
        ], 200);


    }



    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'mobile'  =>  'string|max:25',
            'country' => 'string|max:50',
            'city'    => 'string|max:50',
        ]);


        $User_detail = User_detail::find(JWTAuth::user()->id);
        $User_detail->mobile = $request->input('mobile');
        $User_detail->country = $request->input('country');
        $User_detail->city = $request->input('city');
        $User_detail->save();

        if ($User_detail) {


            return response()->json([
                'message' => 'Your Data Successfully Updated'
            ], 201);

        }


    }










}
