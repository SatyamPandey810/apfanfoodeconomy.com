<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Pin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
/*============================= Start User Register Show Page ===============================*/ 
    public function register(){
        $packages=Package::get();
        return view('website.pages.register',compact('packages'));
    } 
/*================================= Start User Register ======================================*/ 
public function store(Request $request)
{
   
    $validator = Validator::make($request->all(), [
        'referId' => 'required|string|max:200', 
        'join' => 'required|in:L,R',
        'name' => 'required|string|max:50',
        'email' => 'required|email|max:200|unique:users,email',
        'mobile' => 'required',
        'address' => 'required|string',
        'username' => 'required|string|max:200|unique:users,username',
        'package' => 'required',
        'password' => 'required',
        'pin' => 'required',
        'bank_name' => 'required|string|max:100',
        'bank_account' => 'required|string|max:100',
    ]);
    $validator->after(function ($validator) use ($request) {
        $userExists = User::where('user_id', $request->referId)->exists();
        if (!$userExists) {
            $validator->errors()->add('referId', 'The referral ID does not exist.');
        }

        $pinExists = Pin::where('pin_no', $request->pin)->exists();
        if (!$pinExists) {
            $validator->errors()->add('pin', 'The PIN is not valid.');
        }

        $pinInUse = User::where('use_pin', $request->pin)->exists();
        if ($pinInUse) {
            $validator->errors()->add('pin', 'The PIN is already in use.');
        }
    });
   
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
  
    $user_id = 'AFC' . mt_rand(10000000, 99999999);

    $lastUsers = User::where(function ($query) use ($request) {
        $query->where('sponser_id', $request->referId)   
        ->where('user_position', $request->join);
    })
    ->orWhere(function ($query) use ($request) {
        $query->where('user_posid', $request->referId)->where('user_position', $request->join);
    })->orderBy('created_at', 'desc')->first();

   

    $isSponsorUnused = !User::where('sponser_id', $request->referId)->where('user_position', $request->join)->exists();
    $isSponsorUnused2 = !User::where('user_posid', $request->referId)->where('user_position', $request->join)->exists();

    if ($isSponsorUnused && $isSponsorUnused2) {
        $user = new User();
        $user->user_id = $user_id;
        $user->username = $request->username;
        $user->password = Hash::make(value: $request->password);
        $user->conform_password = $request->password;
        $user->user_posid = $request->referId;
        $user->sponser_id = $request->referId;
        $user->user_position = $request->join;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->package = $request->package;
        $user->use_pin = $request->pin;
        $user->bank_name = $request->bank_name; 
        $user->bank_account = $request->bank_account;
        $user->status = 'activ';
        $user->save();
        $pin = Pin::where('pin_no', $request->pin)->first();
        if ($pin) {
            $pin->status = 'inactiv'; 
            $pin->save();
        }
    } else {
        $user = new User();
        $user->user_id = $user_id;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        if ($lastUsers) {
            $lastUser = User::where('user_posid', $lastUsers->user_id)->orderBy('id', 'desc')->first();
            $user->user_posid = $lastUser ? $lastUser->user_id : $lastUsers->user_id;
        } else {
            $user->user_posid = $request->referId;
        }
        $user->sponser_id = $request->referId;
        $user->user_position = $request->join;
        $user->name = $request->name;  
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->package = $request->package; 
        $user->use_pin = $request->pin;
        $user->bank_name = $request->bank_name; 
        $user->bank_account = $request->bank_account;
        $user->status = 'activ';
        $user->save();
        $pin = Pin::where('pin_no', $request->pin)->first();
        if ($pin) {
            $pin->status = 'inactiv'; 
            $pin->save();
        }
    }
    Auth::login($user);
    return redirect()->route('user.dashboard.index')->with('success', 'User registered successfully!');
}

/*================================= Start Validate Referrale Id ======================================*/ 

/*================================= Start User Register2 ======================================*/ 
public function register2(Request $request){

    $referid=$request->user_id;
    $currentUser = $request->current_user;
    $user = User::where('user_id',$referid)->get();
    $user_ids = $user->pluck('user_id'); 
    $user_ids_array = $user_ids->toArray(); 
    $user_id = implode(',', $user_ids_array);

    /*----------------curent user ------------------*/
    $users = User::where('id', $currentUser)->get();
    $currentuser_ids = $users->pluck('user_id'); 
    $currentuser_ids_array = $currentuser_ids->toArray(); 
    $login_user= implode(',', $currentuser_ids_array);
    $user_position = $request->position;
    $packages=Package::get();

    return view('website.pages.refer_register',compact('packages','user','user_id','login_user','user_position',));
}

  public function ReferStore(Request $request){
    $validator = Validator::make($request->all(), [
        'referId' => 'required|string|max:200', 
        'join' => 'required|in:L,R',
        'name' => 'required|string|max:50',
        'email' => 'required|email|max:200|unique:users,email',
        'mobile' => 'required',
        'address' => 'required|string',
        'username' => 'required|string|max:200|unique:users,username',
        'package' => 'required',
        'password' => 'required',
        'pin' => 'required',
        'bank_name' => 'required|string|max:100',
        'bank_account' => 'required|string|max:100',
    ]);
    
    $validator->after(function ($validator) use ($request) {
        $userExists = User::where('user_id', $request->referId)->exists();
        if (!$userExists) {
            $validator->errors()->add('referId', 'The referral ID does not exist.');
        }

        $pinExists = Pin::where('pin_no', $request->pin)->exists();
        if (!$pinExists) {
            $validator->errors()->add('pin', 'The PIN is not valid.');
        }

        $pinInUse = User::where('use_pin', $request->pin)->exists();
        if ($pinInUse) {
            $validator->errors()->add('pin', 'The PIN is already in use.');
        }
    });
   
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $packege = $request->package; 
    $pinAmount =Pin::where('amount',$packege)->first();

    $user_id = 'AFC' . mt_rand(10000000, 99999999);
    $package= Package::where('amount',$packege)->first();
    
  if($request->referId != $request->user_posid){
        $user = new User();
        $user->user_id = $user_id;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->Conform_password =$request->password;
        $user->user_posid=$request->user_posid;
        $user->sponser_id=$request->referId;
        $user->user_position = $request->join;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->package = $request->package;
        $user->use_pin = $request->pin;
        $user->bank_name = $request->bank_name; 
        $user->bank_account = $request->bank_account;
        $user->status = 'activ';
        $user->save(); 

        $pin = Pin::where('pin_no', $request->pin)->first();
        if ($pin) {
            $pin->status = 'inactiv'; 
            $pin->save();
        }

     return redirect()->route('user.dashboard.index')->with('success', 'User registered successfully!');
    }
else{
    $user = new User();
    $user->user_id = $user_id;
    $user->username = $request->username;
    $user->password = Hash::make($request->password);
    $user->Conform_password =$request->password;
    $user->user_posid=$request->referId;
    $user->sponser_id=$request->referId;
    $user->user_position = $request->join;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->mobile = $request->mobile;
    $user->address = $request->address;
    $user->package = $request->package;
    $user->use_pin = $request->pin;
    $user->bank_name = $request->bank_name; 
    $user->bank_account = $request->bank_account;
    $user->status ='activ';
    $user->save(); 
      
    $pin = Pin::where('pin_no', $request->pin)->first();
    if ($pin) {
        $pin->status = 'inactiv'; 
         $pin->save();
    }
        
return redirect()->route('user.dashboard.index')->with('success', 'User registered successfully!');
}
}

/*================================= End User Register2 ================================================*/  

}
