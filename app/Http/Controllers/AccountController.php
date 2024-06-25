<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;


class AccountController extends Controller
{
    //register
    public function register(){
        return view('account.register');
    }
    public function processRegister(Request $request){
        $validator= validator::make($request->all(),[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:5',
            'password_confirmation'=>'required',
            ]);
        if($validator->fails()){
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('account.login')->with('success','you have register successfuly');
    }

    //login
    public function login(){
        return view('account.login');
    }
    public function authenticate(Request $request){
        $validator= validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|min:5',
        ]);
        if($validator->fails()){
            return redirect()->route('account.authenticate')->withInput()->withErrors($validator);
        }
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect()->route('account.profile');
        }else{
            return redirect()->route('account.authenticate')->with('error','email or password is incorrect');
        }
    }

    //to show user profile page
    public function profile(){
        $user = User::find(Auth::user()->id);
        return view('account.profile', compact('user'));
    }

    //to update profile
    public Function updateProfile(Request $request){
        $ruls=[
            'name'=>'required|string|min:3',
            'email'=>'required|email|unique:users,email,'.Auth::user()->id.',id',
        ];
        if(!empty($request->image)){
            $ruls['image']='image';
        }
        $validator= validator::make($request->all(),$ruls);
        if($validator->fails()){
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }
        $user = User::find(Auth::user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        //to upload image
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('upload/profile/'), $imageName);
            $user->image = $imageName;
            $user->save();
        }

        return redirect()->route('account.profile')->with('success','profile updated successfully');
    }

    //logout
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
}
