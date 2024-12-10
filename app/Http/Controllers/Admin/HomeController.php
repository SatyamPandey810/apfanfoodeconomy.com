<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();
        return view('admin/layoute/dashboard',compact('totalUser'));
    }
    public function index()
    {
        return view('admin/pages/index');
    }

    public function showLoginForm()
    {
        return view('admin/pages/login');
    }

    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $admin = Admin::where('username', $request->username)->first();

    if (!$admin) {
        return back()->withErrors(['username' => 'Username does not exist']);
    }

    if ($admin->password !== $request->password) {
        return back()->withErrors(['password' => 'Incorrect password']);
    }

    Auth::guard('admin')->login($admin);
    return redirect()->route('dashboard');
}

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function user(Request $request) {
        $query = User::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('use_pin', 'LIKE', "%{$search}%"); 
        }
    
        $users = $query->paginate(10);
    
        return view('admin/pages/user/userlist', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin/pages/user/useredit', compact('user'));
    }
   public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $id,
        'user_email' => 'required|email|max:255|unique:users,user_email,' . $id,
        'password' => 'nullable|string|min:8|confirmed', // Password validation
    ]);

    // Find the user and update fields
    $user = User::findOrFail($id);
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->username = $request->input('username');
    $user->orange_money = $request->input('orange_money');
    $user->mtn_money = $request->input('mtn_money');
    $user->TRC20_address = $request->input('TRC20_address');
    $user->moov_money = $request->input('moov_money');
    $user->wave = $request->input('wave');
    $user->user_email = $request->input('user_email');

    // If the password is provided, hash it and update
    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    $user->save();

    // Redirect with success message
    return redirect()->route('user')->with('success', 'User updated successfully.');
}

    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user')->with('success', 'User deleted successfully.');
    }


       public function WithdrawalPending() { 

        $withdrawals = Withdrawal::orderBy('created_at', 'desc')->get();     
        return view('admin.pages.withdrawal.withdrawal_pending',compact('withdrawals'));
         }
       public function WithdrawalSuccess(){
        
           $withdrawals = Withdrawal::orderBy('created_at', 'desc')->get();
           return view('admin.pages.withdrawal.withdawal_success',compact('withdrawals'));
       }
public function WithdrawalCancel(){
        
$withdrawals = Withdrawal::orderBy('created_at', 'desc')->get();
return view('admin.pages.withdrawal.withdrawal_cancel',compact('withdrawals'));
}
public function WithdrawalUpdate(Request $request){
        // dd($request->id);
$withdrawals = Withdrawal::where('id',$request->id)->get();

return view('admin.pages.withdrawal.status_update',compact('withdrawals'));
}

public function WithdrawalStatus(Request $request){
// dd($request->id);  
$id = $request->id;
$withdrawals = Withdrawal::findOrFail($id); 

if($withdrawals->status === 'Rejected')
{
    return redirect()->back()->with('error','Alrady Rejected Request!');    
}


else{
    if ($request->status == 'Rejected') {
        $user = User::where('user_id',$withdrawals->user_id)->first();
        
        if ($user) {
       
            $user->commission_account += $withdrawals->withdrawal_amount+$withdrawals->commission;
            $user->save();
        // Update the withdrawal status to "Rejected"
        $withdrawals->status = 'Rejected';
       
    }
    
} else {
    // Update the withdrawal status to the new status
    $withdrawals->status = $request->input('status');
}

$withdrawals->save();

return redirect()->back()->with('success','status Updated!');

}
}
//-------------------add gallery-----------------------------
public function gallery()
{
    $galleries = Gallery::all();
    return view('admin/pages/gallery/index', compact('galleries'));
}

// Show the form to create a new record
public function create()
{
    return view('admin/pages/gallery/create');
}

// Store the new record in the database

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);  

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '-' . $image->getClientOriginalName();
        $image->move(public_path('asset/img'), $imageName);
        $imagePath = $imageName;
    }

    $gallery = new Gallery;
    $gallery->title = $request->input('title');
    $gallery->image = $imagePath;
    $gallery->save();
    // dd($gallery->image);
    return redirect()->route('gallery')->with('success', 'Gallery item created successfully.');
}

// Edit a record
public function editgallery($id)
{
    $gallery = Gallery::findOrFail($id);
    return view('admin/pages/gallery/edit', compact('gallery'));
}

// Update the record
public function updategallery(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $gallery = Gallery::findOrFail($id);
    $gallery->title = $request->input('title');
    // $gallery->image = $imagePath;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '-' . $image->getClientOriginalName();
        $image->move(public_path('asset/img'), $imageName);
        $imagePath = $imageName;
    }

    $gallery->save();

    return redirect()->route('gallery')->with('success', 'Gallery item updated successfully.');
}

// Delete a record
public function destroygallery($id)
{
    $gallery = Gallery::findOrFail($id);
    $gallery->delete();

    return redirect()->route('gallery')->with('success', 'Gallery item deleted successfully.');
}

}
