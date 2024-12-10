<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PinController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PanelController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Matrix\StageController;

/*------====================================== Admin All Route ==================================================-----*/

Route::get('/admin/register', [HomeController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/registers', [HomeController::class, 'register'])->name('admin.registers');

Route::get('admin/login', [HomeController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [HomeController::class, 'login'])->name('admin.logins');

Route::middleware(['auth:admin'])->group(function () {
Route::get('logout', [HomeController::class, 'logout'])->name('admin.logout');
Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');
Route::get('/dashboard/suport', [PinController::class,'suport'])->name('dashboard.suport');
Route::get('/dashboard/create-pin', [PinController::class,'create_pin'])->name('dashboard.create-pin');
Route::post('dashboard/search-by-pin', [PinController::class,'searchbypin'])->name('dashboard.search.by.pin');
Route::post('/dashboard/store-pin', [PinController::class,'store_pin'])->name('dashboard.store-pin');
Route::get('/dashboard/show-pin', [PinController::class,'show_pin'])->name('dashboard.show-pin');
Route::get('/dashboard/used-pin', [PinController::class,'used_pin'])->name('dashboard.used-pin');

Route::get('/packages', [PinController::class, 'show_package'])->name('packages.index');
Route::get('/packages/create', [PinController::class, 'create'])->name('packages.create');
Route::post('/packages', [PinController::class, 'store'])->name('packages.store');
Route::get('packages/{id}/edit', [PinController::class, 'edit'])->name('packages.edit');
Route::put('packages/{id}', [PinController::class, 'update'])->name('packages.update');
Route::delete('packages/{id}', [PinController::class, 'destroy'])->name('packages.destroy');


Route::get('/galleries', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/galleries/create', [HomeController::class, 'create'])->name('gallery.create');
Route::post('/galleries', [HomeController::class, 'store'])->name('gallery.store');
Route::get('/galleries/{id}/edit', [HomeController::class, 'editgallery'])->name('gallery.edit');
Route::put('/galleries/{id}', [HomeController::class, 'updategallery'])->name('gallery.update');
Route::delete('/galleries/{id}', [HomeController::class, 'destroygallery'])->name('gallery.destroy');


Route::get('/user', [HomeController::class, 'user'])->name('user');
Route::get('edit-user/{id}', [HomeController::class, 'edit'])->name('edit.user');
Route::put('update-user/{id}', [HomeController::class, 'update'])->name('update.user');
Route::delete('delete-user/{id}', [HomeController::class, 'destroy'])->name('delete.user');

Route::get('/dashboard/withdrawal-panding', [HomeController::class,'WithdrawalPending'])->name('withdrawal.panding');
Route::get('/dashboard/withdrawal-success', [HomeController::class,'WithdrawalSuccess'])->name('withdrawal.success');
Route::get('/dashboard/withdrawal-cancel', [HomeController::class,'WithdrawalCancel'])->name('withdrawal.cancel');
Route::get('/dashboard/withdrawal-update/{id}', [HomeController::class,'WithdrawalUpdate'])->name('withdrawal.update');
Route::get('/dashboard/withdrawal-Status/{id}', [HomeController::class,'WithdrawalStatus'])->name('withdrawal.status');
Route::get('/dashboard/food-request', [PinController::class, 'FoodRequest'])->name('foodrequest');
Route::get('/dashboard/food-success', [PinController::class, 'FoodSuccess'])->name('foodsuccess');

Route::get('/admin/contacts', [PinController::class, 'showContacts'])->name('contacts.index'); 
Route::post('/dashboard/update-status/{id}', [PinController::class, 'Foodstatus'])->name('dashboard.food.list.update');

});



/*------======================================= User All Route ==============================================--------*/

Route::get('user/register', [UserController::class,'register'])->name('user.register');
Route::post('user/store', [UserController::class,'store'])->name('user.store');
Route::get('user/link-regiater/{user_id}/', [UserController::class,'register2'])->name('user.link.register');
Route::post('user/refer-store', [UserController::class,'ReferStore'])->name('refer.store');

Route::get('login', [AuthController::class,'index'])->name('login');
Route::post('check-login', [AuthController::class,'checklogin'])->name('check.login');

Route::middleware(['auth'])->group(function () {
Route::get('/user/dashboard/logout/', [AuthController::class,'logout'])->name('user.logout');
Route::get('/user/profile', [DashboardController::class,'profile'])->name('profile');
Route::put('user-profile/{id}', [DashboardController::class, 'profileupdate'])->name('profile.update');


Route::get('/user/dashboard/index', [DashboardController::class,'userdashboard'])->name('user.dashboard.index');
Route::get('/user/getData/{id}', [DashboardController::class, 'getUserData'])->name('user/getData');
Route::get('/user-tree', [StageController::class, 'getUserSponsorInfo'])->name('user-tree');
Route::get('/user-tree-stage-1', [StageController::class, 'stage1'])->name('user-tree-stage1');
Route::get('/user-tree-stage-2', [StageController::class, 'stage2'])->name('user-tree-stage2');
Route::get('/user-tree-stage-3', [StageController::class, 'stage3'])->name('user-tree-stage3');
Route::get('/user-tree-stage-4', [StageController::class, 'stage4'])->name('user-tree-stage4');
Route::get('/user-tree-stage-5', [StageController::class, 'stage5'])->name('user-tree-stage5');
Route::get('/network-list', [PanelController::class, 'network'])->name('network-list');
Route::get('/user-Pofile', [DashboardController::class, 'profile'])->name('user.profile');
Route::put('/user-profile/{id}', [DashboardController::class, 'profileUpdate'])->name('profile.update');
Route::get('/user/dashboard/award', [PanelController::class, 'award'])->name('award');
Route::post('user-trees', [DashboardController::class, 'getUserSponsorInfos'])->name('getUser.SponsorInfos');
Route::get('user/dashboard/withdrawal-request', [DashboardController::class, 'WithdrawalRequest'])->name('withdrawal.request');
Route::post('user/dashboard/withdrawal', [DashboardController::class, 'Withdrawaluser'])->name('withdrawal.storeuser');
Route::get('/get-user-account', [DashboardController::class, 'getUserAccount'])->name('getUserAccount');
Route::get('user/dashboard/withdrawal-histoy', [DashboardController::class, 'WithdrawalHistory'])->name('withdrawal.history');
Route::get('user/dashboard/reward-histoy', [DashboardController::class, 'Reward'])->name('reward');
Route::get('user/dashboard/food-histoy', [DashboardController::class, 'Food'])->name('food');
Route::post('user/dashboard/food-request', [DashboardController::class, 'FoodStore'])->name('food.store');
});

/*------========================================== Website Route ================================================----*/

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/faq', [IndexController::class, 'faq'])->name('faq');
Route::get('/product', [IndexController::class, 'product'])->name('product');
Route::get('/product', [IndexController::class, 'product'])->name('product');
Route::get('/compensation-plan', [IndexController::class, 'testimonials'])->name('testimonials');
Route::get('/opportunity', [IndexController::class, 'opportunity'])->name('opportunity');
Route::get('/t&c', [IndexController::class, 'term'])->name('t&c');

/*------==========================================End Website Route ================================================----*/