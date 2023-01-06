<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

use App\Mail\PasswordReset as MailPasswordReset;

class PassportController extends Controller
{
    /**
     * Register user.
     *
     * @return json
     */
    public function register(Request $request)
    {
        $input = $request->only(['name', 'email', 'password','c_password','role']);

        $validate_data = [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            'role' => 'required|string',
            
              
        ];

        $validator = Validator::make($input, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }
            


        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'c_password' => Hash::make($input['c_password']),
             'role' => $input['role']
             
        ]);
         
        return response()->json([
            'success' => true,
            'message' => 'User registered succesfully, Use Login method to receive token.'
        ], 200);
    }
 
    /**
     * Login user.
     *
     * @return json
     */
    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);

        $validate_data = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        $validator = Validator::make($input, $validate_data);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }

        // authentication attempt
        if (auth()->attempt($input)) {
            $token = auth()->user()->createToken('passport_token')->accessToken;
            
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully, Use token to authenticate.',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User authentication failed.'
            ], 401);
        }
    }

    /**
     * Access method to authenticate.
     *
     * @return json
     */
    public function userDetail()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully.',
            'data' => auth()->user()
        ], 200);
    }

    /**
     * Logout user.
     *
     * @return json
     */
    public function logout()
    {
        $access_token = auth()->user()->token();

        // logout from only current device
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);

        // use this method to logout from all devices
        // $refreshTokenRepository = app(RefreshTokenRepository::class);
        // $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($$access_token->id);

        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    }


public function allusers()
    {
        $users = User::all();
        if($users==""){
        return response()->json([
            'success' => true,
            'message' => 'Users Not Found Done.',
            // 'data' => $Items

        ], 404);
        

        }else{
        return response()->json([
            'success' => true,
            'message' => 'Users Fetch Successfully Done.',
            'data' => $users

        ], 200);
        
    }
}

public function single_user(Request $request , $id)
    {
         $users = User::where('id',$id)->get();
        // $ids = $request->input('ids', []); // via injected instance of Request
      // $items1 = items::whereIn('id', explode(',', $id))->get();
       // $items1 = items::whereIn('id', explode(',', $id->$request->get()));
        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Users Details Not Found'
            ], 404);
        }
        return response()->json([
                'success' => true,
                'message' => 'Users Details Found',
                'data' => $users
            ], 200);

       // return $items;
    }


    public function update_user(Request $request , $id)
    {
          $user = new User();
            $user = User::find($id);
            
          
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$request->password;
            $user->c_password=$request->c_password;
            $user->role=$request->role;
            $user->save();
            
            
            
            return response()->json([
            'success' => true,
            'message' => 'Users Details Updated Successfully.'
        ], 200);

            
         } 



public function password_reset(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            $otp = rand(0000, 9999);
            \DB::table('password_resets')->updateOrInsert([
                'email' => $user->email],
                ['token' => $otp
            ]);
            \Mail::to($request->email)->send(new MailPasswordReset($otp, $user->name));
            return response()->json(['success' => true, 'message' => 'OTP is send to your email, please verify OTP to continue'], 200);
        }
    }
    public function verifyOtp(Request $request){
        $verify = \DB::table('password_resets')->where('email', $request->email)
        ->where('token', $request->otp)
        ->first();
        if($verify){
            if(isset($request->password) && isset($request->confirm_password) && $request->password == $request->confirm_password){
                User::where('email', $request->email)->update([
                    'password' => \Hash::make($request->password)
                ]);
            \DB::table('password_resets')->where('email', $request->email)->delete();
            return response()->json(['success' => true, 'message' => 'Password Reset Successfully, Please Login to continue'], 200);
            }
            return response()->json(['success' => false, 'message' => 'password doesn\'t match'], 200);
        }
        return response()->json(['success' => false, 'message' => 'something went wrong'], 400);
    }


public function destroy_user($id)
          {
        $delete_user= User::find($id);
    
        $delete_user->delete();
 
        return response()->json([
            'success' => true,
            'message' =>'User Deleted Successfully Done.'
        ], 200);
    

}



}