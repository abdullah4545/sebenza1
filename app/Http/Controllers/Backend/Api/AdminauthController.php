<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class AdminauthController extends Controller
{
    public function adminstore(Request $request){
        $email=Admin::where('email', $request->email)->first();
        $phonenumber=Admin::where('phone', $request->phone)->first();
        if($email){
            $response = [
                'status' =>false,
                'message' => "Email Already Taken",
                "data"=> [
                    "user"=>[],
                ]
            ];
            return response()->json($response,201);
        }elseif($phonenumber){
            $response = [
                'status' =>false,
                'message' => "Phone number has Already Taken",
                "data"=> [
                    "user"=>[],
                ]
            ];
            return response()->json($response,201);
        }else{
            $admin=new Admin();
            $admin->first_name=$request->first_name;
            $admin->last_name=$request->last_name;
            $admin->phone=$request->phone;
            $admin->email=$request->email;
            $admin->password=Hash::make($request->password);
            $admin->status=$request->status;
            $admin->save();
            if($request->roles){
                $admin->assignRole($request->roles);
            }
            $token = $admin->createToken('admin')->plainTextToken;
            $admin->profile='public/backend/img/user.jpg';

            $response=[
                "status"=>true,
                "message"=>"Admin Create Successfully",
                "data"=> [
                    'token' => $token,
                    "user"=>$admin,
                ]
            ];
            return response()->json($response, 200);
        }
    }

    public function getroles(){
        $roles =Role::where('guard_name','admin')->get();
        $response = [
            'status' => true,
            'message'=>'List of admin roles',
            "data"=> [
                'roles'=> $roles,
            ]

        ];
        return response()->json($response,200);
    }

    public function adminlogin(Request $request){
        $admin = Admin::where('email', $request->email)
                    ->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            $error = [
                    "status"=>false,
                    "message"=>"Login failed",
                    "data"=> [
                        'token' => '',
                        "user"=>[],
                    ]
            ];
            return response()->json($error);
        }

        $admin = Admin::with('roles')->where('id', $admin->id)->first();

        $token = $admin->createToken('admin')->plainTextToken;

        $response = [
            "status"=>true,
            "message"=>"Login Successfully",
            "data"=> [
                'token' => $token,
                "user"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function admindetails($id){

        $admin = Admin::with('roles')->where('id', $id)->first();

        $response = [
            "status"=>true,
            "message"=>"Admin Details",
            "data"=> [
                "user"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function adminprofile(Request $request){

        $token = request()->bearerToken();
        $admin_id=PersonalAccessToken::findToken($token);
        $admin=Admin::where('id', $admin_id->tokenable_id)->first();

        $response = [
            "status"=>true,
            "message"=>"My Profile Details",
            "data"=> [
                "user"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function adminprofileupdate(Request $request){

        $token = request()->bearerToken();
        $admin_id=PersonalAccessToken::findToken($token);
        $admin=Admin::where('id', $admin_id->tokenable_id)->first();
        $admin->first_name=$request->firstName;
        $admin->last_name=$request->lastName;
        $admin->phone=$request->mobile;
        $time = microtime('.') * 10000;
        $productImg = $request->file('img');
        if($productImg){
            $imgname = $time . $productImg->getClientOriginalName();
            $imguploadPath = ('public/backend/profile/');
            $productImg->move($imguploadPath, $imgname);
            $productImgUrl = $imguploadPath . $imgname;
            $admin->profile = $productImgUrl;
        }
        $admin->update();

        $response = [
            "status"=>true,
            "message"=>"My Profile Details",
            "data"=> [
                "user"=>$admin,
            ]
        ];

        return response($response, 201);
    }

    public function adminlogout(Request $request){
        $token = $request->token;
        $usertoken=PersonalAccessToken::findToken($token);

        $utoken = PersonalAccessToken::where('name',$usertoken->name)->where('tokenable_id', $usertoken->tokenable_id);
        $utoken->delete();

        $error = [
            "status"=>true,
            "message" => 'Logout Successfully',
            "data"=> [
                "user"=>[],
            ]
        ];
        return response()->json($error);
    }

}
