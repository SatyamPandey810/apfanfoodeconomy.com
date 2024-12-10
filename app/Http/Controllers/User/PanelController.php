<?php
namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matrix1s;
use App\Models\Reward;
use App\Services\MLMService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;    

class PanelController extends Controller
{
public function network()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $Name = $currentUser->first_name . ' ' . $currentUser->last_name;
        $directReferrals = User::where('sponser_id', $currentUser->user_id)->paginate(6);
        $perPage = 6;
        $currentPage = request()->query('page', 1);
        $pagedData = $directReferrals->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $allReferrals = new LengthAwarePaginator($pagedData, count($directReferrals), $perPage);
        $allReferrals->setPath(route('network-list'));

        $user = User::where('user_id', $currentUser->user_id)->first();
        return view('user.dashboard.pages.network_list', compact('user','directReferrals', 'userName', 'Name','allReferrals'));
    } else {
        return response()->json(['error' => 'User is not authenticated'], 401);
    }
}



/*=======================------------start Matching bonus -----------===========================>*/
protected $mlmService;

public function __construct(MLMService $mlmService)
{
    $this->mlmService = $mlmService;
}
public function calculateMatchingBonusForUser()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $Name = $currentUser->first_name . ' ' . $currentUser->last_name;
        $userId = $currentUser->id;
    $user = User::find($userId);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    $mlmService = new MLMService();
    [$carryLeft, $carryRight] = $mlmService->calculateMatchingBonus($user);
    $mlmService->calculateBonusForDescendants($user);
    $leftChild = $user->leftChild;
    $rightChild = $user->rightChild;
    $leftDescendants = $this->getDescendants($leftChild);
    $rightDescendants = $this->getDescendants($rightChild);

    $responseData = [
        'user' => $user,
        'carryLeft' => $carryLeft,
        'carryRight' => $carryRight,
        'leftChild' => $leftChild ? [
            'id' => $leftChild->id,
            'name' => $leftChild->name,
            'bv' => $leftChild->bv,
            'descendants' => $leftDescendants,
        ] : null,
        'rightChild' => $rightChild ? [
            'id' => $rightChild->id,
            'name' => $rightChild->name,
            'bv' => $rightChild->bv,
            'descendants' => $rightDescendants,
        ] : null,
    ];
    return response()->json($responseData);
}
    else{
        return response()->json(['error' => 'User not found'], 404);
    }
}
protected function getDescendants($user)
{
    if (!$user) {
        return [];
    }
    return $user->children()->with(['children' => function ($query) {
        $query->with('children'); 
    }])->get()->map(function ($child) {
        return [
            'id' => $child->id,
            'name' => $child->name,
            'bv' => $child->bv,
            'children' => $this->getDescendants($child),
        ];
    });
}

/*=======================---------------------End Matching bonus -------------------===========================>*/

/*============================================Start Encashment====================================================*/
public function Encashment(){
    if (Auth::check()) {
        $currentUser = Auth::user();
        $userName = $currentUser->username;
        $Name = $currentUser->first_name . ' ' . $currentUser->last_name;
        $userId = $currentUser->user_id;
        
      
       
    return view('user.dashboard.pages.encashment', compact('currentUser','userName','Name'));
    }
    else{
        return response()->json(['error' => 'User not found'], 404);
    }
}
}

