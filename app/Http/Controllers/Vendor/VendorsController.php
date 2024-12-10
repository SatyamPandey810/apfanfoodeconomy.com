<?php

namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller; 
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchasePv;
use App\Models\Shopproduct;
use App\Models\Shoppurchas;
use App\Models\Shopseatbonus;
use App\Models\Totalpv;
use App\Models\SeatBonus;
use App\Models\Phiproduct;
use App\Models\Stockitbonus;
use App\Models\ShopproductTransfer;
use App\Models\StockitPv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorsController extends Controller
{
    /*=================================Shop Product Buying=====================================================*/
public function MemberIndex(){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $currentUserId= $currentUser->id;
        $currentUserName= $currentUser->name;
        return view('vendor/ShopBuying/membercheck',compact('currentUserId','currentUserName'));
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

        return redirect()->route('vendor.open.product2');
    }  
}

public function ProductIndex(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();

        $userId = $request->session()->get('user_id');
        $products = ShopproductTransfer::where('vendor_id',$currentUser->member_id)->get();
        return view('vendor/ShopBuying/shop', compact('userId','products'));
        
    }  
}
public function fetchProductDetails($productId)
{
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $product = ShopproductTransfer::where('id',$productId)->first();
    if ($product) {
        return response()->json($product);
    }
    return response()->json(['error' => 'Product not found'], 404);
}
}
public function addCart(Request $request){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $id = $request->product_id;
        $total_cost=$request->total_cost;
        $product = ShopproductTransfer::where('id', $request->product_id)->first();

        $quantity = $request->product_quantity;


     $shopcart = session()->get('shopcart', []);
    
     if(isset($cart[$id])) {
         $shopcart[$id]['quantity'] += $quantity;
         $shopcart[$id]['total_cost'] += $shopcart[$id]['quantity'] * $shopcart[$id]['price'];
     } else {
        $shopcart[$id] = [
             'id' =>$product->id,
             "product_name" => $product->product_name,
             "quantity" =>$quantity,
             "price" => $product->price,
             'phi_points' => $product->phi_points,
             "pv" => $product->pv,
             "image" => $product->image,
             "seat_product" => $product->seat_product,
             "total_cost" =>$product->price*$quantity,
         ];
     }
     session()->put('shopcart', $shopcart);
     return redirect()->route('vendor.show.cart2')->with('success', 'added successful!');
    

}
}


public function ShowCart()
    {
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $shopcart = session('shopcart');
        $totalAmount = 0;
    
        if ($shopcart) {
            foreach ($shopcart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }
        }

        $shopcart = session()->get('shopcart', []);
        return view('vendor.ShopBuying.shopcart', compact('shopcart','totalAmount'));
    }else{
        return response()->json(['error' => 'User not found'], 404);
    }
}

public function removeFromCart($id)
{
    $shopcart = session()->get('shopcart');
    if(isset($shopcart[$id])) {
        unset($shopcart[$id]);
        session()->put('shopcart', $shopcart);
    }
    return redirect()->back()->with('success', 'Product removed from cart successfully!');

}

public function PurchaseCartOrders(Request $request)
    {
        if (Auth::guard('vendor')->check()) {  
            $currentVendor = Auth::guard('vendor')->user();

            $shopcart = Session::get('shopcart', []);
            $userId = $request->session()->get('user_id');
            $currentUser=User::where('user_id',$userId)->first();
            $user_id=$currentUser->user_id;
            if (!empty($shopcart)) {
                foreach ($shopcart as $id => $item) {
                    $product = ShopproductTransfer::findOrFail($id);
                    $seat_bonus = $item['seat_product'];
                    $price = $item['price'] * $item['quantity'];
                    $purchaseBonus = $price* 0.10;
                    $pv= $item['pv'];
    
                    if ($product->quantity >= $item['quantity']) {
                        $pvst =$pv*$item['quantity'];
                        $productname=$item['product_name'];
                        $pv = (float)$pv;  
                        $quantity = (int)$item['quantity'];
                      
                        $currentUser->addBonus($purchaseBonus);
    
                        $purchase = new Shoppurchas();
                        $purchase->user_id = $currentUser->user_id;
                        $purchase->product_id = $item['id'];
                        $purchase->product_name = $item['product_name'];
                        $purchase->price = $item['price'];
                        $purchase->phi_points = $item['phi_points']*$item['quantity']; 
                        $purchase->purchase_bonus = $purchaseBonus;
                        $purchase->quantity = $item['quantity'];
                        $purchase->pv =$pv * $quantity;
                        $purchase->vendor_id= $currentVendor->id;
                        $purchase->status = 'success';
                        $purchase->save();
    
                        $product->quantity -= $item['quantity'];
                        $product->save();

                        $productPrice =$item['price']*$item['quantity'];
                        $commission = $productPrice * 0.05;
                        $productPhipoints = $item['phi_points'] * $item['quantity'];
    
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
                        $this->distributeGenerationBonus($currentUser, $price);
                        $this->distributePvBonus($user_id, $pvst,$productname);
                    } else {
                        return redirect()->back()->with('error', 'Insufficient funds in commission account for ' . $item['name']);
                    }
                }
    
                Session::forget('shopcart');
                return redirect()->route('vendor.Orders2')->with('success', 'Products purchased successfully');
            } else {
                return redirect()->route('showcart.view')->with('error', 'Cart is empty');
            }
        
    }
}
protected function distributeGenerationBonus(User $currentUser, float $price)
{
    $shopcart = Session::get('shopcart', []);
    $productBonuses = [];

    if (!empty($shopcart)) {
        foreach ($shopcart as $item) {
            $product_id = $item['id'];
            $seat_product = (float)$item['seat_product'];
            $quantity = (int)$item['quantity'];
            $seat_bonus = $seat_product * $quantity;

            if (!isset($productBonuses[$product_id])) {
                $productBonuses[$product_id] = [
                    'amount' => $seat_bonus,
                    'product' => $item['product_name'],
                    'price' => $item['price'],
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
        $parent = User::where('user_id', $user->user_posid)->first();

        if ($parent) {
            if (in_array($parent->package_id, [85, 162])) {
                $generationLimit = 15;
            } else {
                $generationLimit = 20;
            }

            if ($currentGeneration <= $generationLimit) {
                foreach ($productBonuses as $product_id => $bonusData) {
                    $existingBonus = Shopseatbonus::where([
                        'user_id' => $parent->user_id,
                        'referral_id' => $currentUser->user_id,
                        'product' => $bonusData['product'],
                        'created_at' => $currentDate, 
                    ])->first();

                    if (!$existingBonus) {
                        Shopseatbonus::create([
                            'user_id' => $parent->user_id,
                            'referral_id' => $currentUser->user_id,
                            'amount' => $bonusData['amount'],
                            'product' => $bonusData['product'],
                            'price' => $bonusData['price'],
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
            'type' => 'shop',
            'status' => 'success',
        ]);

        $user = $sponsor;
    }
}
/*======================================================Orders History======================================================*/
public function Orders(){
    if (Auth::guard('vendor')->check()) {  
        $currentUser = Auth::guard('vendor')->user();
        $purchase=Shoppurchas::orderBy('created_at', 'desc')->where('vendor_id',$currentUser->id)->paginate(5);
        $productIds = $purchase->pluck('product_id');
        $product = Shopproduct::whereIn('id', $productIds)->get();
        $totalCount = Shoppurchas::where('vendor_id', $currentUser->id)->count();
        $total_commission= $currentUser->total_commission;
        return view('vendor/ShopBuying/orderhistory',compact('purchase','product','totalCount','total_commission'));
    }
}
}
