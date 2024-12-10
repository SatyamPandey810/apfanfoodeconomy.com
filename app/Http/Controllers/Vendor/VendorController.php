<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Package;
use App\Models\Totalpv;
use App\Models\PurchasePv;
use App\Models\ProductTransfer;
use App\Models\SeatBonus;
use App\Models\ShopproductTransfer;
use App\Models\Phiproduct;
use App\Models\Phipurchase;
use App\Models\Packpurchase;
use App\Models\Transferpin;
use App\Models\Stockitbonus;
use App\Models\StockitPv;
use App\Models\Shoppurchas;
use App\Models\Shopseatbonus;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class VendorController extends Controller
{
    public function create()
    {
        return view ('admin.pages.vendor.create');
    }

    public function vendorstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'member_id' =>  ['required',
                function ($attribute, $value, $fail) {
                    if (!DB::table('users')->where('user_id', $value)->exists()) {
                        $fail('The ' . $attribute . ' is not valid.');
                    }
                },
            ],
            'package' => 'required',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
   

 
        $this->distributeBonusUpTo15Generations($request->member_id);
    
        Vendor::create([
            'name' => $request->name,
            'member_id' => $request->member_id,
            'package'=>$request->package,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'confirm_password' => $request->password, 
        ]);
         return redirect()->route('vendor.show')->with('success', 'Vendor created successfully.');
    }


   private function distributeBonusUpTo15Generations($userId)
    {
        $currentGeneration = 1;
        $userIds = $userId; 
        $user = User::where('user_id', $userId)->first(); 
        $userid = $user->user_posid; 
        $currentUser = User::where('user_id', $userid)->first(); 
    
        if (!$currentUser) {
            return; 
        }
    
        $maxGenerations = in_array($currentUser->package_id, [85, 162]) ? 15 : 20;
    
        while ($currentGeneration <= 20) {
            $currentUser = User::where('user_id', $userid)->first();
           
            if ($currentUser) {
                if ($currentGeneration <= ($currentUser->package_id == 85 || $currentUser->package_id == 162 ? 15 : 20)) {
                    Stockitbonus::create([
                        'user_id' => $currentUser->user_id, 
                        'referral_id' => $userIds, 
                        'package' => 7700,
                        'bonus' => 11.53,
                        'pv' => 2200,
                        'user_position' => 'L',
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
    
                $userid = $currentUser->user_posid;
                $currentGeneration++;
            } else {
                break;
            }
        }
    
        $sponsorUser = User::where('user_id', $user->sponser_id)->first();
    
        while ($sponsorUser) {
            StockitPv::create([
                'user_id' => $sponsorUser->user_id,
                'referral_id' => $userIds,
                'package' => 7700,
                'pv' => 2200,
                'user_position' => 'L',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            $sponsorUser = User::where('user_id', $sponsorUser->sponser_id)->first();
        }
    }




    public function vendorShow()
    {
        $vendors = Vendor::all();
        return view('admin.pages.vendor.index', compact('vendors'));
    }

    public function Edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.pages.vendor.edit', compact('vendor'));
    }
    public function update(Request $request, $id)
    {  
        $vendor = Vendor::findOrFail($id);
    
        $vendor->name = $request->name;
        $vendor->username = $request->username;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
    
        $vendor->password = Hash::make($request->password);
        $vendor->confirm_password = $request->password;
        $vendor->save();
        return redirect()->route('vendor.show')->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        if ($vendor) {
            $vendor->delete();
            return redirect()->route('vendor.show')->with('success', 'Vendor deleted successfully.');
        } else {
            return redirect()->route('vendor.show')->with('error', 'Vendor not found.');
        }
    }
   
  
    // =====================vendor login ===========================//

    public function loginView()
    {
        return view('vendor.login');
    }
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendor = Vendor::where('email', $request->email)->first();

        if ($vendor) {
            if (Hash::check($request->password, $vendor->password)) {
                Auth::guard('vendor')->login($vendor);
                $request->session()->put('id', $vendor->id);
                return redirect()->route('vendor.dashboard')->with('success', 'Successfully Logged In');
            } else {
                return back()->with('error', 'Oops! You have entered invalid credentials');
            }
        } else {
            return back()->with('error', 'This Email is Not Registered');
        }

    }
    
    public function logout()
    {
        Auth::guard('vendor')->logout();
        if (Session::has('id')) {
            Session::pull('id');
            return redirect('vendor/login')->with('success', 'You have successfully logged out!');
        }
    }
   
    public function dashboard() {
        if (Auth::guard('vendor')->check()) {  
            $currentUser = Auth::guard('vendor')->user();
            $total_commission= $currentUser->total_commission;

             $A=Purchase::where('vendor_id',$currentUser->id)->count();
            $B=Shoppurchas::where('vendor_id',$currentUser->id)->count();
            $totalpurchase=$A+$B;
        return view('vendor.dashboard',compact('total_commission','totalpurchase'));
        }
    }

    // public function encashments()
    // {    
    //     $transferpins = Transferpin::all();
    //     $totalPins = Transferpin::count();
    //     return view('vendor/encashmentpho/encashments', compact('transferpins','totalPins'));
    // }
/*=================================Product Buying=====================================================*/
public function MemberIndex(){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $currentUserId= $currentUser->id;
        return view('vendor/ProductBuying/membercheck',compact('currentUserId'));
    }
}

public function fetchMemberName(Request $request)
{
    $user = User::where('user_id', $request->orderID)->first();
    if ($user) {
        return response()->json([
            'success' => true,
            'memberName' => $user->first_name. ' ' .$user->last_name,
        ]);
    }
     return response()->json(['error' => false]);
}


public function MemberCheck(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $userId = $request->orderID;
        $request->session()->put('user_id', $userId);

        return redirect()->route('vendor.open.product');
        // dd($userId);
    }  
}

public function ProductIndex(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $userId = $request->session()->get('user_id');
        $products = ProductTransfer::where('vendor_id',$currentUser->member_id)->get();
        return view('vendor/ProductBuying/product', compact('userId','products'));
        
    }  
}
public function fetchProductDetails($productId)
{
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $product = ProductTransfer::where('id', $productId)->first();
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
    
    return response()->json(['error' => 'Unauthorized'], 403);
}
public function addCart(Request $request){

    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $id = $request->product_id;
        $total_cost=$request->total_cost;
        $product = ProductTransfer::where('id', $request->product_id)->first();

        $quantity = $request->product_quantity;


     $cart = session()->get('cart', []);
    
     if(isset($cart[$id])) {
         $cart[$id]['quantity'] += $quantity;
         $cart[$id]['total_cost'] += $cart[$id]['quantity'] * $cart[$id]['price'];
     } else {
         $cart[$id] = [
             'id' =>$product->id,
             "product_name" => $product->product_name,
             "quantity" =>$quantity,
             "price" => $product->price,
             "pv" => $product->pv,
             "image" => $product->image,
             "seat_product" => $product->seat_product,
             "total_cost" =>$product->price*$quantity,
             'phi_points' => $product->phi_points,
         ];
     }
     session()->put('cart', $cart);
     return redirect()->route('vendor.show.cart')->with('success', 'added successful!');
    

}
}


public function ShowCart()
    {
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $cart = session('cart');
        $totalAmount = 0;
    
        if ($cart) {
            foreach ($cart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }
        }

        $cart = session()->get('cart', []);
        return view('vendor.ProductBuying.cart', compact('cart','totalAmount'));
    }else{
        return response()->json(['error' => 'User not found'], 404);
    }
}

public function removeFromCart($id)
{
    $cart = session()->get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return redirect()->back()->with('success', 'Product removed from cart successfully!');

}

public function PurchaseCartOrders(Request $request)
    {
       
        if (Auth::guard('vendor')->check()) {  
            $currentVendor = Auth::guard('vendor')->user();
            $cart = Session::get('cart', []);
            $userId = $request->session()->get('user_id');
            $currentUser=User::where('user_id',$userId)->first();
            $user_id=$currentUser->user_id;
            if (!empty($cart)) {
                foreach ($cart as $id => $item) {
                    $product = ProductTransfer::findOrFail($id);
                    $seat_bonus = $item['seat_product'];
                    $price = $item['price'] * $item['quantity'];
                    $purchaseBonus = $price * 0.15;
                    $pv= $item['pv'];
    
                    if ($product->quantity >= $item['quantity']) {
                         $pvst =$pv*$item['quantity'];
                          $productname=$item['product_name'];
                        // $currentUser->updateCommission($price);
                        $currentUser->addBonus($purchaseBonus);
    
                        $purchase = new Purchase();
                        $purchase->user_id = $currentUser->user_id;
                        $purchase->product_id = $item['id'];
                        $purchase->product_name = $item['product_name'];
                        $purchase->price = $item['price'];
                        $purchase->phi_points = $item['phi_points']*$item['quantity'];
                        $purchase->purchase_bonus = $purchaseBonus;
                        $purchase->quantity = $item['quantity'];
                        $purchase->pv =$pv*$item['quantity'];
                        $purchase->vendor_id= $currentVendor->id;
                        $purchase->status = 'success';
                        $purchase->save();
    
                        $product->quantity -= $item['quantity'];
                        $product->save();

                        // Calculate 5% commission
                        $productPhipoints = $item['phi_points'] * $item['quantity'];
                        $productPrice =$item['price']*$item['quantity'];
                        $commission = $productPrice * 0.05;
    
                        // Retrieve and update vendor's total commissions
                        $vendor = Vendor::where('id',$currentVendor->id)->first();
                        if ($vendor) {
                            $vendor->total_commission += $commission;
                            $vendor->save();
                        }


                        $totalPvEntry = TotalPV::where('user_id', $currentUser->user_id)->first();
                        if ($totalPvEntry) {
                            $totalPvEntry->total_pv += $pv;
                            $totalPvEntry->save();
                        } else {
                            TotalPV::create([
                                'user_id' => $currentUser->user_id,
                                'total_pv' => $pv* $item['quantity'],
                            ]);
                        }
                        // // Distribute bonus to 15 generations
                        $this->distributeGenerationBonus($currentUser, $price);
                         $this->distributePvBonus($user_id, $pvst,$productname);
                    } else {
                        return redirect()->back()->with('error', 'Insufficient funds in commission account for ' . $item['name']);
                    }
                }
    
                Session::forget('cart');
                return redirect()->route('vendor.Orders')->with('success', 'Products purchased successfully');
            } else {
                return redirect()->route('cart.view')->with('error', 'Cart is empty');
            }
        
    }
}
// protected function distributeGenerationBonus(User $currentUser, float $price)
// {
//     $cart = Session::get('cart', []);
//     $productBonuses = [];

//     if (!empty($cart)) {
//         foreach ($cart as $item) {
//             $product_id = $item['id']; // Assuming 'id' is the identifier for the product
//             $seat_bonus = $item['seat_product'] * $item['quantity'];

//             if (!isset($productBonuses[$product_id])) {
//                 $productBonuses[$product_id] = [
//                     'amount' => $seat_bonus,
//                     'product' => $item['product_name'],
//                     'price' => $item['price'],
//                     'phi_points' => $item['phi_points'],
//                     'quantity' => $item['quantity'],
                   
//                 ];
//             } else {
//                 $productBonuses[$product_id]['amount'] += $seat_bonus;
//                 $productBonuses[$product_id]['quantity'] += $item['quantity'];
//             }
//         }
//     }

//     $currentGeneration = 1;
//     $user = $currentUser;
//     $currentDate = now(); 
    
//     while ($currentGeneration <= 20 && $user->user_posid) {
//         // Fetch the parent user based on user_posid
//         $parent = User::where('user_id', $user->user_posid)->first();

//         if ($parent) {
//             // Determine the generation limit based on the parent's package
//             if (in_array($parent->package_id, [85, 162])) {
//                 $generationLimit = 15;
//             } else {
//                 $generationLimit = 20;
//             }

//             if ($currentGeneration <= $generationLimit) {
//                 // Add the bonus to the parent user's commission account
//                 foreach ($productBonuses as $product_id => $bonusData) {
//                     // Store each product bonus only once per parent
//                     $existingBonus = SeatBonus::where([
//                         'user_id' => $parent->user_id,
//                         'referral_id' => $currentUser->user_id,
//                         'product' => $bonusData['product'],
//                         'created_at' => $currentDate, 
//                     ])->first();

//                     if (!$existingBonus) {
//                         SeatBonus::create([
//                             'user_id' => $parent->user_id,
//                             'referral_id' => $currentUser->user_id,
//                             'amount' => $bonusData['amount'],
//                             'product' => $bonusData['product'],
//                             'price' => $bonusData['price'],
//                             'phi_points' => $bonusData['phi_points'],
//                             'quantity' => $bonusData['quantity'],
//                             'status' => 'success',
//                         ]);
//                     }
//                 }

//                 // Move to the next generation
//                 $user = $parent;
//                 $currentGeneration++;
//             } else {
//                 break;
//             }
//         } else {
//             Log::error("No parent found for user_posid: {$user->user_posid} at generation $currentGeneration");
//             break;
//         }
//     }
// }
protected function distributeGenerationBonus(User $currentUser, float $price)
{
    $cart = Session::get('cart', []);
    $productBonuses = [];

    if (!empty($cart)) {
        foreach ($cart as $item) {
            $product_id = $item['id']; // Assuming 'id' is the identifier for the product
            $seat_bonus = $item['seat_product'] * $item['quantity'];

            if (!isset($productBonuses[$product_id])) {
                $productBonuses[$product_id] = [
                    'amount' => $seat_bonus,
                    'product' => $item['product_name'],
                    'price' => $item['price'],
                    'phi_points' => $item['phi_points'],
                    'quantity' => $item['quantity'],
                ];
            } else {
                $productBonuses[$product_id]['amount'] += $seat_bonus;
                $productBonuses[$product_id]['quantity'] += $item['quantity'];
            }
        }
    }

    $currentGeneration = 1;
    $user = $currentUser;
    $currentDate = now(); 
    
    while ($currentGeneration <= 20 && $user->user_posid) {
        // Fetch the parent user based on user_posid
        $parent = User::where('user_id', $user->user_posid)->first();

        if ($parent) {
            // Determine the generation limit based on the parent's package
            if (in_array($parent->package_id, [85, 162])) {
                $generationLimit = 15;
            } else {
                $generationLimit = 20;
            }

            if ($currentGeneration <= $generationLimit) {
                // Add the bonus to the parent user's commission account
                foreach ($productBonuses as $product_id => $bonusData) {
                    // Store each product bonus only once per parent
                    $existingBonus = SeatBonus::where([
                        'user_id' => $parent->user_id,
                        'referral_id' => $currentUser->user_id,
                        'product' => $bonusData['product'],
                        'created_at' => $currentDate, 
                    ])->first();

                    if (!$existingBonus) {
                        SeatBonus::create([
                            'user_id' => $parent->user_id,
                            'referral_id' => $currentUser->user_id,
                            'amount' => $bonusData['amount'],
                            'product' => $bonusData['product'],
                            'price' => $bonusData['price'],
                            'phi_points' => $bonusData['phi_points'],
                            'quantity' => $bonusData['quantity'],
                            'status' => 'success',
                        ]);
                    }
                }

                // Move to the next generation
                $user = $parent;
                $currentGeneration++;
            } else {
                // If the parent's generation limit is reached, check the parent's parent
                $user = $parent; // Move up the hierarchy
                $currentGeneration++; // Skip this generation for the parent
            }
        } else {
            Log::error("No parent found for user_posid: {$user->user_posid} at generation $currentGeneration");
            break;
        }
    }
}

protected function distributePvBonus($user_id, $pvst,$productname)
{
    $user = User::where('user_id', $user_id)->first();
    $pv = $pvst;

    while ($user && $user->sponser_id) {
        $sponsor = User::where('user_id', $user->sponser_id)->first();

        if (!$sponsor) {
            break;
        }

        PurchasePv::create([
            'user_id' => $sponsor->user_id,
            'referral_id' => $user_id,
             'pv' => $pv,
             'name'=>$productname,
            'type' => 'product',
            'status' => 'success',
        ]);

        $user = $sponsor;
    }
}
/*======================================================Orders History======================================================*/
public function Orders(){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $purchase=Purchase::orderBy('created_at', 'desc')->where('vendor_id',$currentUser->id)->paginate(5);
        $productIds = $purchase->pluck('product_id');
        $product = Product::whereIn('id', $productIds)->get();
        $totalCount = Purchase::where('vendor_id', $currentUser->id)->count();
        $total_commission= $currentUser->total_commission;
        return view('vendor/ProductBuying/orderhistory',compact('purchase','product','totalCount','total_commission'));
    }
}
/*======================================================PhiOrders History======================================================*/


// ====================================package buying====================================//

public function MemberPackage(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $currentUserId= $currentUser->id;
        return view('vendor/PackageBuying/memberpackcheck',compact('currentUserId'));
        
    }  
}
public function MemberpackName(Request $request)
{
    $user = User::where('user_id', $request->orderID)->first();
    if ($user) {
        return response()->json([
            'success' => true,
            'memberName' => $user->first_name . ' ' . $user->last_name,
        ]);
    }
    return response()->json(['success' => false]);
}

public function MembePackCheck(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $userId = $request->orderID;
        $request->session()->put('user_id', $userId);

        return redirect()->route('vendor.open.index');
        // dd($userId);
    }  
}
public function PackageIndex(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $userId = $request->session()->get('user_id');
        $packages = Package::all();
        return view('vendor/PackageBuying/package', compact('userId','packages'));
        
    }  
}
public function getPackageDetails($packageId)
{
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $package = Package::find($packageId); 
        $transferpin = Transferpin::where('package', $package->amount)->where('vendor_id', $currentUser->member_id)->sum('quantity');    
    if ($package && $transferpin) {
        return response()->json([
            'id' => $package->id,
            'name' => $package->name,
            'amount' => $package->amount,  // Send the package price
            'quantity' =>$transferpin,  // Assuming you have a `quantity` field
        ]);
    }

    return response()->json(['error' => 'Package not found'], 404);
}
else{
    return response()->json(['error' => 'User not found'], 404); 
}
}
public function addPackcart(Request $request)
{
    $id = $request->package_id;
    $package = Package::where('id',$id)->first();
    $quantity = $request->package_quantity;


    $packcart = session()->get('packcart', []);

    if(isset($packcart[$id])) {
        $packcart[$id]['quantity'] += $quantity;
        $packcart[$id]['total_cost'] = $packcart[$id]['quantity'] * $packcart[$id]['amount'];
    } else {
        $packcart[$id] = [
            'id' => $package->id,
            'name' => $package->name,
            'quantity' => $quantity,
            'amount' => $package->amount,         
            'image' => $package->image,
            'total_cost' => $package->amount * $quantity,
            'phi_points' => $package->phi_points,
        ];
    }
    // dd($packcart);
    session()->put('packcart', $packcart);

    return redirect()->route('vendor.show.packcart')->with('success', 'package added successfully!');
}
public function Showpackcart()
    {
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $packcart = session('packcart');
       
        $totalAmount = 0;
    
        if ($packcart) {
            foreach ($packcart as $details) {
                $totalAmount += $details['amount'] * $details['quantity'];
            }
        }
      
        $packcart = session()->get('packcart', []);
        return view('vendor.PackageBuying.packagecart', compact('packcart','totalAmount'));
    }else{
        return response()->json(['error' => 'User not found'], 404);
    }
}
public function removeFromPackCart($id)
{
    $packcart = session()->get('packcart');
    if(isset($packcart[$id])) {
        unset($packcart[$id]);
        session()->put('packcart', $packcart);
    }
    return redirect()->back()->with('success', 'Package removed from cart successfully!');

}

public function purchasePackCartorders(Request $request)
{
    if (Auth::guard('vendor')->check()) {  
        $currentVendor = Auth::guard('vendor')->user();

        $packcart = session('packcart', []);
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found in session.');
        }


        $currentUser = User::where('user_id', $userId)->first();
        if (!$currentUser) {
            return redirect()->back()->with('error', 'Invalid User.');
        }
         
        if (!empty($packcart)) {
            foreach ($packcart as $id => $item) {
                $product = Package::findOrFail($id); // Fetch the package
                $amount = $item['amount'] * $item['quantity'];
                $purchaseBonus = $amount * 0.15; // Calculate the purchase bonus

                    $purchase = new Packpurchase();
                    $purchase->user_id = $userId;
                    $purchase->package_id = $id;
                    $purchase->name = $item['name'];
                    $purchase->amount = $item['amount'];
                    $purchase->quantity = $item['quantity'];
                    $purchase->purchase_bonus = $purchaseBonus; // Assign the calculated bonus
                    $purchase->vendor_id = $currentVendor->id;
                    $purchase->status = 'success';
                    
                    $purchase->save();
                    $productPrice = $item['amount'] * $item['quantity'];
                    $amountss = $item['amount'] ;

                    $commission = 0;


            if ($amountss == 85) {
                    $commission = 4.6;
                } elseif ($amountss == 162) {
                   $commission = 7.6;
                } elseif ($amountss == 324) {
                  $commission = 15.3;
                } elseif ($amountss == 648) {
                   $commission = 15.3;
                } elseif ($amountss == 1296) {
                   $commission = 23;
                }
                $abcd = $item['quantity'] * $commission;
                $vendor = Vendor::where('id', $currentVendor->id)->first();
            if ($vendor) {
               $vendor->total_commission += $abcd;
               $vendor->save();
            }


               
            }
            // dd($packcart);
            // Clear the session cart after the purchase
            session()->forget('packcart'); 

            return redirect()->route('vendor.packorders')->with('success', 'Package purchased successfully');
        } else {
            return redirect()->route('packcart.view')->with('error', 'PackCart is empty');
        }
    }
}

public function Packorders()
{
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $purchase = Packpurchase::where('vendor_id', $currentUser->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
       
        $packageIds = $purchase->pluck('package_id');
        $package = Package::whereIn('id', $packageIds)->get();   
        $totalCount = Packpurchase::where('vendor_id', $currentUser->id)->count();

        $total_commission = $purchase->sum(function ($purchase) {
            return $purchase->amount * 0.05; // Assuming 5% commission
        });
        return view('vendor/packorderhistory', compact('purchase', 'package', 'totalCount','total_commission'));
    }
}

// public function transfer_show()
// {    
//     $transferpins = Transferpin::all();
//     $totalPins = Transferpin::count();
//     return view('vendor/transferpin/showtransferpin', compact('transferpins','totalPins'));
// }

public function transfer_show()
{    
    if (Auth::guard('vendor')->check()) {  
    $currentUser = Auth::guard('vendor')->user();
    $transferpins = Transferpin::where('status', 'unsold')->where('vendor_id', $currentUser->member_id)->get();
    $totalPins = Transferpin::where('vendor_id', $currentUser->member_id)->count();
    return view('vendor/transferpin/showtransferpin', compact('transferpins','totalPins'));
    }
    else{
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}

public function transfer_usedpin() {
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $vendorId = $currentUser->member_id;
      
        $usedPins = Transferpin::where('status', 'inactiv')->where('vendor_id',$currentUser->member_id)
        ->get();
        return view('vendor/transferpin/transferpinused', compact('usedPins'));
    } else {
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}

public function showTransferredProducts()
{

    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
    
        $transferProducts = ProductTransfer::where('vendor_id',$currentUser->member_id)->get();
        $totalTransferred =$transferProducts->sum('quantity');
        return view('vendor.transferproduct.showproduct', compact('transferProducts','totalTransferred'));
        }
        else{
            return response()->json(['error' => 'User is not authenticated'], 401);
        }
}

public function showTransfershopProducts()
{
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
   
    $transfershopProducts = ShopproductTransfer::where('vendor_id',$currentUser->member_id)->get();
    $totalTransferred = $transfershopProducts->sum('quantity');
    return view('vendor.transferproduct.shopproduct', compact('transfershopProducts','totalTransferred'));
    }
    else{
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}
public function RequestWithdrawal() {
  
    if (Auth::guard('vendor')->check()) {
      
        $currentUser = Auth::guard('vendor')->user();
        
     
        $userId = $currentUser->user_id; 
        $Name = $currentUser->name; 
        $totalbalence = $currentUser->total_commission;
        
    
        $user = User::where('user_id', $currentUser->member_id)->first();
        
      
        return view('vendor.withdrawals', compact('user', 'Name', 'totalbalence'));
    } else {
      
        return response()->json(['error' => 'User is not authenticated'], 401); 
    }
}

public function Withdrawal(Request $request)
{
    // Validate the withdrawal request
    $validatedData = $request->validate([
        'w_amount' => 'required|numeric|min:12',  
        'bank' => 'required|string',  
        'account' => 'required|string',  
    ], [
        'w_amount.min' => 'The withdrawal amount must be at least $12.',
        'account.required' => 'Account details are required.',
    ]);

   
    if (Auth::guard('vendor')->check()) {
        $currentUser = Auth::guard('vendor')->user();  
        $total_balance = $currentUser->total_commission;
        $withdrawal_amount = $request->w_amount;

      
        $commission = 0.05 * $withdrawal_amount;
        $final_withdrawal_amount = $withdrawal_amount - $commission;

        // Ensure the user's balance is sufficient
        if ($total_balance < 12) {
            return redirect()->back()->withErrors(['error' => 'Your balance must be at least $12 to make a withdrawal.']);
        }

        // Ensure the withdrawal amount does not exceed the total balance
        if ($withdrawal_amount > $total_balance) {
            return redirect()->back()->withErrors(['error' => 'Withdrawal amount exceeds available balance.']);
        }

       
        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $currentUser->member_id;  
        $withdrawal->username = $currentUser->username;  
        $withdrawal->bank = $request->bank;  
        $withdrawal->account = $request->account;  
        $withdrawal->total_amount = $total_balance;
        $withdrawal->withdrawal_amount = $final_withdrawal_amount;
        $withdrawal->commission = $commission;
        $withdrawal->status = 'pending';
      
    
        $withdrawal->save();

   
        $currentUser->total_commission -= $withdrawal_amount;
        
        $currentUser->save();

      
        return redirect()->back()->with('success', 'Withdrawal request submitted successfully.');
    } else {
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}

public function Withdrawalshow (){
    if (Auth::guard('vendor')->check()) {
        $currentUser = Auth::guard('vendor')->user(); 
        $userID =$currentUser->user_id;
        $Name =$currentUser->full_name;
        $Bank =$currentUser->payment_method;
        $Account =$currentUser->payment_number;
       
        $withdrawals = Withdrawal::where('user_id',$currentUser->member_id)->get();
        return view('vendor.withdrawalshow',compact('Name','withdrawals','Bank','Account'));
    }
    else{
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}
}
