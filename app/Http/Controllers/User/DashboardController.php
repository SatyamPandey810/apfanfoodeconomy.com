<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reward;
use App\Models\Food;
use App\Models\Foodpurchase;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Services\MLMService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
/*=================================================Start Show Dashboard===================================================>*/
protected $mlmService;

public function __construct(MLMService $mlmService)
{
    $this->mlmService = $mlmService;
}
public function userdashboard(Request $request)
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $user_id = $currentUser->user_id;
        $userId = $currentUser->id;
        $totalbonus = $currentUser->commission_account;
        $user = User::where('user_id',$user_id)->first();

        $totalWithdrawalAmount = Withdrawal::where('user_id', $user_id)->sum('withdrawal_amount');
        $totalCommission = Withdrawal::where('user_id', $user_id)->sum('commission');

        $totalWithdrawal = $totalWithdrawalAmount + $totalCommission;
        return view('user.dashboard.pages.index', compact(
            'user', 
            'userId', 
            'totalWithdrawal',
        ));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

}

public function profile()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $user_id = $currentUser->user_id;
        $userId = $currentUser->id;
        $totalbonus = $currentUser->commission_account;
        $user = User::where('user_id',$user_id)->first();
        return view('user.dashboard.pages.profile', compact( 'user',));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}

public function profileupdate(Request $request, $id)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);


    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = Hash::make($request->password);
        $user->conform_password = $request->password;
    }

    $user->save();
    return redirect()->back()->with('success','Profile updated successfully.');

}



public function Reward()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $user_id = $currentUser->user_id;
        $userId = $currentUser->id;
        $totalbonus = $currentUser->commission_account;
        $user = User::where('user_id',$user_id)->first();
        $reward = Reward::where('user_id', $user_id)->paginate(10);
        return view('user.dashboard.pages.reward', compact(
            'user', 
            'userId',
            'reward', 
        ));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}

public function Food()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $user_id = $currentUser->user_id;
        $userId = $currentUser->id;
        $totalbonus = $currentUser->commission_account;
        $user = User::where('user_id',$user_id)->first();
        $reward = Food::where('user_id', $user_id)->paginate(10);
        return view('user.dashboard.pages.food', compact(
            'user', 
            'userId',
            'reward', 
        ));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
public function FoodStore(Request $request)
{
    if (Auth::check()) {
       $currentUser = Auth::user();
        $userId = $currentUser->user_id; 
        $Name = $currentUser->name;
        $totalwallet = $currentUser->commission_account;
        $user = User::where('user_id', $userId)->first();

        // dd($request->all());
       if ($request->purchase_amount >= $currentUser->total_food) {
            return redirect()->back()->withErrors(['error', 'The purchase amount cannot be low to your food balance.']);
       }
        $food = new Foodpurchase();
        $food->user_id = $currentUser->user_id;
        $food->username = $currentUser->username;
        $food->total_amount = $currentUser->total_food;
        $food->purchase_amount = $request->purchase_amount;
        $food->message = $request->message;
        $food->status = 'pending';
        $food->save();

        $currentUser->total_food -= $request->purchase_amount; 
        $currentUser->save();

        return view('user.dashboard.pages.encashment', compact('user', 'Name', 'totalwallet'));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}

public function WithdrawalRequest(){
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userId = $currentUser->user_id; 
        $Name = $currentUser->name;
        $totalwallet = $currentUser->commission_account;
        $user = User::where('user_id', $userId)->first();   
        return view('user.dashboard.pages.encashment', compact('user', 'Name', 'totalwallet'));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
public function getUserAccount(Request $request)
{
     if (Auth::check()) {
        $currentUser = Auth::user();
        $user = User::where('user_id',$currentUser->user_id)->first();

        if($user->orange_money == $request->user_id){
            return response()->json([
                'account_number' => $user->orange_money,
            ]);
        }
        elseif($user->moov_money == $request->user_id){
            return response()->json([
                'account_number' => $user->moov_money,
            ]);
        }
        elseif($user->TRC20_address == $request->user_id){
            return response()->json([
                'account_number' => $user->TRC20_address,
            ]);
        }
        elseif($user->wave == $request->user_id){
            return response()->json([
                'account_number' => $user->wave,
            ]);
        }
        elseif($user->mtn_money == $request->user_id){
            return response()->json([
                'account_number' => $user->mtn_money,
            ]);
        }
        elseif($user->bank_name == $request->user_id){
            return response()->json([
                'account_number' => $user->bank_account,
            ]);
        }
        else{
            return response()->json([
                'account_number' => null,
            ]);
        }
}
else{
    return response()->json(['error' => 'User not found'], 404);
}

}
public function Withdrawaluser(Request $request){

$validatedData = $request->validate([
    'w_amount' => 'required|numeric|min:12',  
    'bank' => 'required|string',  
    'account' => 'required|string',  
], [
    'w_amount.min' => 'The withdrawal amount must be at least 3000(NG).',
    'account.required' => 'Account details are required.',
]);

    if (Auth::check()) {
        $currentUser = Auth::user();
        $total_balance =$currentUser->commission_account;
        $bank = $currentUser->bank;
        $account = $currentUser->account;
        $withdrawal_amount = $request->w_amount;
        $commission = 0.05 * $withdrawal_amount;
        $final_withdrawal_amount = $withdrawal_amount - $commission;
        $user = user::where('user_id',$currentUser->user_id)->first();
         if($user->orange_money == $request->bank){
             $bank = 'Orange Money';
         }
         elseif($user->moov_money == $request->bank){
             $bank = 'Moov Money';
         }
          elseif($user->TRC20_address == $request->bank){
             $bank = 'TRC20 Address';
         }
          elseif($user->wave == $request->bank){
             $bank = 'Wave';
         }
          elseif($user->mtn_money == $request->bank){
             $bank = 'MTN Money';
         }
         else{
             $bank = $request->bank; 
         }

        if ($total_balance < 2999) {
            return redirect()->back()->withErrors(['error' => 'Your balance must be at least 3000(NG) to make a withdrawal.']);
        }

        if ($withdrawal_amount > $total_balance) {
            return redirect()->back()->withErrors(['error' => 'Withdrawal amount exceeds available balance.']);
        }

        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $currentUser->user_id;
        $withdrawal->username = $currentUser->username;
     
        $withdrawal->bank = $bank;
        $withdrawal->account = $request->account;
        $withdrawal->total_amount = $total_balance;
        $withdrawal->withdrawal_amount = $final_withdrawal_amount;
        $withdrawal->commission = $commission;
        $withdrawal->status = 'pending';
  
        $withdrawal->save();

        $currentUser->commission_account -= $withdrawal_amount; 
        $currentUser->save();
        if($bank == 'Orange Money'){
        $currentUser->orange_money = $request->account; 
        $currentUser->save();  
        }
        elseif($bank == 'Moov Money'){
        $currentUser->moov_money = $request->account; 
        $currentUser->save();  
        }
        elseif($bank == 'TRC20 Address'){
        $currentUser->TRC20_address = $request->account; 
        $currentUser->save();  
        }
          elseif($bank == 'Wave'){
        $currentUser->wave = $request->account; 
        $currentUser->save();  
        }
        elseif($bank == 'MTN Money'){
        $currentUser->mtn_money = $request->account; 
        $currentUser->save();  
        }
        return redirect()->back()->with('success', 'Withdrawal request submitted successfully.');
    
    }
    else{
        return response()->json(['error' => 'User is not authenticated'], 401); 
    }
}

public function WithdrawalHistory(){
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $user_id = $currentUser->user_id;
        $userId = $currentUser->id;
        $totalbonus = $currentUser->commission_account;
        $user = User::where('user_id',$user_id)->first();
        $withdrawals = Withdrawal::where('user_id', $user_id)->paginate(10);
        return view('user.dashboard.pages.withdrawalhistory', compact('user', 'userId','withdrawals'));
        
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
public function getUserData($id)
{
    $user = User::where('user_id', $id)->first();
   if ($user) {
   $sponsor = User::where('user_id', $user->sponser_id)->first();



 
 if( $sponsor){
   
        return response()->json([
            'username' => $user->username,
            'name' => $user->name,
            'userid' => $user->user_id,
            'referral' => $sponsor->username,
            'package' => $user->package,

        ]);
    }
    else{
        return response()->json([
            'username' => $user->username,
            'name' => $user->name,
            'referral' => null,
            'package' => $user->package,

        ]);  
    }
}

    else {
        return response()->json(['error' => 'User not found'], 404);
    }
}

public function getUserSponsorInfos(Request $request)
{
    // dd($request->user_id);
    if (Auth::check()) {
        $currentUsers = Auth::user();
        $userName = $currentUsers->username;
        $fullName = $currentUsers->name;
        $Name = $currentUsers->name ;
     
        $user = User::where('user_id',$currentUsers->user_id)->first();
        $user = User::where('user_id',$request->user_id)->first();
        $currentUser= $user;

        return view('user.dashboard.pages.binary_tree', compact('currentUser', 'fullName','Name', 'user', 'currentUsers'));
    }
    return redirect()->route('login');
}

}
