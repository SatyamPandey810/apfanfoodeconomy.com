<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportReply;
use App\Models\Package;
use App\Models\User;
use App\Models\Pin;
use App\Models\Foodpurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class PinController extends Controller
{
  /*--========================== All Pin Section function ========================================--*/
    public function create_pin()
    {
        $packages=Package::get();
        return view('admin/pages/pin/create',compact('packages'));
    }
    public function store_pin(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);
        
        $amount = $request->input('amount');
        $quantity = $request->input('quantity');

        for ($i = 0; $i < $quantity; $i++){
            
        $pin_no = mt_rand(1000000000, 9999999999);
        $pin = new Pin();
        $pin->pin_no = $pin_no;
        $pin->amount =  $amount;
        $pin->status = 'activ';
        $pin->save();
        }
        return redirect()->back()->with('success', 'Pin created successfully');
    }
    public function show_pin()
    {
        $totalPins = Pin::where('status','activ')->count();
        $pins = DB::table('pins')
            ->leftJoin('users', DB::raw("BINARY pins.pin_no"), '=', DB::raw("BINARY users.use_pin"))
            ->whereNull('users.use_pin')
            ->where('pins.status','activ')
            ->orderBy('pins.created_at', 'desc')
            ->select('pins.*')
            ->paginate(6);
        
        return view('admin/pages/pin/show',compact('pins','totalPins'));
    }

    public function searchbypin(Request $request)
    {
        $pin = $request->input('pin');
        $pins = Pin::where('amount', 'LIKE', '%' . $pin . '%')->where('status','activ')->get();
        return response()->json(['pins' => $pins]);
    }

    public function used_pin() {
        $users = User::paginate(10);
        return view('admin/pages/pin/used',compact('users'));
    }


  /*--==============================Start Add  Package Section=========================================--*/
 
    public function create()
    {
        return view('admin.pages.package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',

        ]);

        $packages =new Package();
        $packages->name = $request->name;
        $packages->amount = $request->amount;
        $packages->status = 'activ';
        $packages->save();
        return redirect()->back()->with('success', 'Package created successfully.');
    }
    public function show_package()
    {
        $packages = Package::all();
        return view('admin.pages.package.show', compact('packages'));
    }

    public function edit($id)
    {
        $package = Package::find($id);
        return view('admin.pages.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
          
        ]);

        $package = Package::find($id);
        $package->name = $request->name;
        $package->amount = $request->amount;
        $package->status = 'activ';
        $package->save();

        return redirect()->route('packages.index')->with('success', 'Package updated successfully');
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully');
    }
/*==============================End Add  Package Section=========================================*/


public function showuserlist()
{
    $users = DB::table('users')
        ->where('users.package_id', 1296)
        ->where(function ($query) {
            $query->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('purchases')
                    ->whereRaw('purchases.user_id = users.user_id')
                    ->havingRaw('SUM(purchases.pv) >= 12');
            })->orWhereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('shoppurchases')
                    ->whereRaw('shoppurchases.user_id = users.user_id')
                    ->havingRaw('SUM(shoppurchases.pv) >= 12');
            });
        })
        ->select('users.*') 
        ->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.pages.Poolbonus.userlist', compact('users'));
}


public function storepoolbonus(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,user_id', 
        'pool_bonus' => 'required|numeric|min:0',
    ]);

    
    $poolBonus = new PoolBonus();
    $poolBonus->user_id = $request->input('user_id');
    $poolBonus->pool_bonus = $request->input('pool_bonus');
    $poolBonus->save(); 

    $comisstionadd = User::where('user_id', $request->input('user_id'))->first();

    if($comisstionadd){

        $comisstionadd->commission_account += $request->input('pool_bonus');
        $comisstionadd->save();
    }
    return redirect()->route('pool.bonus.show')->with('success', 'Pool bonus added successfully.');
}

public function transferProduct()
{
    $products = Product::all();
    $vendors = Vendor::all(); 
return view('admin.pages.product.producttransfer', compact('products','vendors')); 
}
public function storetransferProduct(Request $request)
{
    // Validate request
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required |integer|min:1',     
        'vendor_id' =>'required|exists:vendors,member_id',
    ]);
   
    $product = Product::find($request->product_id);
    if ($request->quantity > $product->quantity) {
        return redirect()->back()->with('error', 'Product quantity requested exceeds available stock.');
    }
    if ($product) {
     
        
        $transfer = ProductTransfer::where('product_id', $product->id)->where('vendor_id', $request->vendor_id)->first(); 

        if ($transfer) {
            $transfer->quantity += $request->quantity;
            $transfer->created_at = now();
            $transfer->save();
        } else {
            ProductTransfer::create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $request->quantity,
                'image' => $request->image,
                'vendor_id' => $request->vendor_id,
                'price' => $request->price, 
                'phi_points' => $request->phi_points, 
                'pv' => $request->pv,
                'seat_product' => $request->seat_product, 
            ]);
        }
        $product->quantity -= $request->quantity;
     
        $product->save();
        return redirect()->back()->with('success', 'Product transferred successfully!');
    }

    return redirect()->back()->with('error', 'Product transfer failed.');
}
public function transferHistory()
{   
    $transfer = ProductTransfer::orderBy('created_at', 'desc')->paginate(10);    
    return view('admin.pages.product.show_transfer', compact('transfer'));
}

public function transfershopproduct()
{   
    $products = Shopproduct::get();   
    $vendors = Vendor::get(); 
    return view('admin.pages.Shopproduct.transfershopproduct', compact('products','vendors'));
}
public function storeshopProduct(Request $request)
{
    // dd($request->all());
    $request->validate([
        'product_id' => 'required|exists:shopproducts,id',
        'quantity' => 'required|integer|min:1',
        'vendor_id' =>'required|exists:vendors,member_id',
    ]);

    $product = Shopproduct::where('id',$request->product_id)->first();
    if ($product) {

        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('error', 'Product quantity requested exceeds available stock.');
        }
        $transfer = ShopproductTransfer::where('product_id', $product->id)->where('vendor_id', $request->vendor_id)->first(); 

        if ($transfer) {
            $transfer->quantity += $request->quantity;
            $transfer->created_at = now();
            $transfer->save();
        } else {
        ShopproductTransfer::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'image' => $request->image,
            'vendor_id' => $request->vendor_id,
            'price' => $product->price, 
            'phi_points' => $product->phi_points, 
            'pv' => $product->pv,
            'seat_product' => $product->seat_product, 
        ]);
        }
        $product->quantity -= $request->quantity;  
        $product->save();  
        return redirect()->back()->with('success', 'Product transferred successfully!');
    }
    return redirect()->back()->with('error', 'Product transfer failed. Product not found.');
}

public function transferShopHistory()
{   
    $transfer = ShopproductTransfer::orderBy('created_at', 'desc')->paginate(10);    
    return view('admin.pages.Shopproduct.show_transfer', compact('transfer'));
}



public function AwardList() {
    $award = DB::table('awards')->where('status','success')->orderBy('created_at', 'desc')->paginate(10);
    return view('admin.pages.awards.awardlist',compact('award'));
}
public function AwardGive() {
    $award = DB::table('awards')->where('status','awarded')->orderBy('created_at', 'desc')->paginate(10);
    return view('admin.pages.awards.awards_success',compact('award'));
}



public function FoodRequest()
{
    
   
    $foodrequest = Foodpurchase::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.pages.withdrawal.foodpurchase',compact('foodrequest'));

    return redirect()->back()->with('success', 'Status updated successfully.');
}
public function FoodSuccess()
{
    $foodrequest = Foodpurchase::orderBy('created_at', 'desc')->where('status','success')->paginate(10);
    return view('admin.pages.withdrawal.foodsuccess',compact('foodrequest'));
    return redirect()->back()->with('success', 'Status updated successfully.');
}


public function Foodstatus(Request $request, $id)
{
    $food = Foodpurchase::find($id);

    if (!$food) {
        return redirect()->back()->with('error', 'Record not found.');
    }
    $food->status = $request->input('status'); 
    $food->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}


}
