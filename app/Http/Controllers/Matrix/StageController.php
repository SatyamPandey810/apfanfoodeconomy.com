<?php

namespace App\Http\Controllers\Matrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Matrix1s;
use App\Models\Matrix2s;
use App\Models\Matrix3s;
use App\Models\Matrix4s;
use App\Models\Matrix5s;
use App\Models\Reward;
use App\Models\Food;
use App\Services\MLMService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class StageController extends Controller
{
    public function getUserSponsorInfo()
{
    if (Auth::check()) {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->user_id;
        $userName = $currentUser->username;
        $fullName = $currentUser->first_name;
        $Name = $currentUser->first_name . ' ' . $currentUser->last_name;
        $currentUsers = Auth::user();
        return view('user.dashboard.pages.binary_tree', compact('currentUser', 'fullName','Name','currentUsers'));
    }
    return redirect()->route('login');
}

public function stage1()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $currentUser = Auth::user();
    $currentUserId = $currentUser->user_id;
    function getDescendants($parentId)
    {
        $descendants = User::where('user_posid', $parentId)->pluck('user_id')->toArray();
        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants($descendantId));
        }
        return array_unique($descendants);
    }
    function getFirstLevelDescendant($parentId, $position)
    {
        return User::where('user_posid', $parentId)
            ->where('user_position', $position)
            ->first();
    }
    function checkDescendantsStatus($userId)
    {
        $firstLeftUser = getFirstLevelDescendant($userId, 'L');
        $firstRightUser = getFirstLevelDescendant($userId, 'R');

        $secondLevelLeftFromLeftUser = $firstLeftUser ? getFirstLevelDescendant($firstLeftUser->user_id, 'L') : null;
        $secondLevelRightFromLeftUser = $firstLeftUser ? getFirstLevelDescendant($firstLeftUser->user_id, 'R') : null;
        $secondLevelLeftFromRightUser = $firstRightUser ? getFirstLevelDescendant($firstRightUser->user_id, 'L') : null;
        $secondLevelRightFromRightUser = $firstRightUser ? getFirstLevelDescendant($firstRightUser->user_id, 'R') : null;

        $response = [
            $firstLeftUser,
            $firstRightUser,
            $secondLevelLeftFromLeftUser,
            $secondLevelRightFromLeftUser,
            $secondLevelLeftFromRightUser,
            $secondLevelRightFromRightUser,
        ];
        // dd($response);
        foreach ($response as $value) {
            if (!$value) {
                return false;
            }
        }
        return true;
    }

    $leftUsers = User::where('user_posid', $currentUserId)
                ->where('user_position', 'L')->get();

    $rightUsers = User::where('user_posid', $currentUserId)
                ->where('user_position', 'R')->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants($leftUser->user_id));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants($rightUser->user_id));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

// dd($leftUserIdsAll,$rightUserIdsAll );

    $status = checkDescendantsStatus($currentUserId);
    $leftStatuses = [];
    foreach ($leftUserIdsAll as $leftUserId) {
        $leftStatuses[$leftUserId] = checkDescendantsStatus($leftUserId);
    }

    $rightStatuses = [];
    foreach ($rightUserIdsAll as $rightUserId) {
        $rightStatuses[$rightUserId] = checkDescendantsStatus($rightUserId);
    }


    $existsInMatrix1s = Matrix1s::where('user_id', $currentUser->user_id)
                                ->where('current_id',$currentUserId)->exists();

    if ($status && !$existsInMatrix1s) {
        $this->createMatrixAndReward($currentUser);
    } else {
        foreach ($leftStatuses as $leftUserId => $leftStatus) {
            if ($leftStatus) {
                $this->processMatrixForUser($leftUserId, $currentUser, 'L', 'left');
            }
        }

        foreach ($rightStatuses as $rightUserId => $rightStatus) {
            if ($rightStatus) {
                $this->processMatrixForUser($rightUserId, $currentUser, 'R', 'right');
            }
        }
        
      
    
    }
    $matrix1s = Matrix1s::where('user_id', $currentUser->user_id)
                        ->where('current_id',$currentUserId)->first();
    // dd($matrix1s);
if ($matrix1s) {
    
    function getDescendants2($parentId, $currentUserId) {
        $descendants = matrix1s::where('current_id', $currentUserId)
                               ->where('user_posid', $parentId)
                               ->pluck('user_id')
                               ->toArray();

        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants2($descendantId, $currentUserId));
        }
        return array_unique($descendants);
    }

    $leftUsers = Matrix1s::where('user_posid', $currentUserId)
                          ->where('current_id',$currentUser->user_id)
                         ->where('position', 'L')
                         ->where('option', 'left')
                         ->get();

    $rightUsers = Matrix1s::where('user_posid', $currentUserId)
                           ->where('current_id',$currentUser->user_id)
                          ->where('position', 'R')
                          ->where('option', 'right')
                          ->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants2($leftUser->user_id, $currentUserId));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants2($rightUser->user_id, $currentUserId));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

    $leftUserIdsAll = array_slice($leftUserIdsAll, 0, 7);
    $rightUserIdsAll = array_slice($rightUserIdsAll, 0, 7);

    $combinedUserIds = array_merge($leftUserIdsAll, $rightUserIdsAll);
    $rewardLimit = count($leftUserIdsAll) + count($rightUserIdsAll);

    $rewardCount = Reward::where('user_id', $currentUser->user_id)
                         ->where('option', 'stage-2')
                         ->count();

                        //  dd($combinedUserIds );
    $i = $rewardCount;
    while ($i < $rewardLimit) {
        if (isset($combinedUserIds[$i])) {
            $reward = new Reward();
            $reward->user_id = $currentUser->user_id;
            $reward->bonus = 1000;
            $reward->option = 'stage-2';
            $reward->status = 'success';
            $reward->save();

            if ($i + 1 == 14) {
                $food = new Food();
                $food->user_id = $currentUser->user_id;
                $food->bonus = 10000;
                $food->option = 'stage-2';
                $food->status = 'success';
                $food->save();

                $currentUser->total_food += 10000;
            }
            $currentUser->commission_account += 1000;
            $currentUser->save();
        }
        $i++;
    }
}

    return view('user.dashboard.pages.stage1_tree', compact('currentUser', 'status', 'matrix1s'));
}


private function createMatrixAndReward($currentUser)
{
    $matrix1 = new Matrix1s();
    $matrix1->current_id = $currentUser->user_id;
    $matrix1->username = $currentUser->username;
    $matrix1->user_id = $currentUser->user_id;
    $matrix1->user_posid = $currentUser->sponser_id;
    $matrix1->sponser_id = $currentUser->sponser_id;
    $matrix1->position = $currentUser->user_position;
    $matrix1->option = 'top';
    $matrix1->status = 'success';
    $matrix1->save();

    $reward = new Reward();
    $reward->user_id = $currentUser->user_id;
    $reward->bonus = 3000;
    $reward->option = 'stage-1';
    $reward->status = 'success';
    $reward->save();
    $currentUser->commission_account += 3000;
    $currentUser->save();
}

private function processMatrixForUser($userId, $currentUser, $position, $option)
{
    $existsInMatrix = Matrix1s::where('user_id', $userId)
                               ->where('current_id',$currentUser->user_id)->exists();
    if (!$existsInMatrix) {
        $usersWithoutSponsor = Matrix1s::where('current_id', $currentUser->user_id)
                                        ->where('option', $option)
                                        ->where('current_id',$currentUser->user_id)->get();

        $firstUserWithNoSponsor = $this->getFirstUserWithoutSponsor($usersWithoutSponsor);
        $aalId = Matrix1s::where('sponser_id', $currentUser->user_id)
                            ->where('position','L')
                            ->where('current_id',$currentUser->user_id)->exists();

        $alreadySponsor = Matrix1s::where('user_id', $userId)
                            ->where('sponser_id', optional($aalId)->user_id)
                            ->where('current_id',$currentUser->user_id)->exists();

        if (!$aalId) {
            $this->createMatrixEntry($currentUser, $userId, $position, $option);
        } else {
            $matrixPosition = $this->determinePosition($currentUser, $firstUserWithNoSponsor, $position, $option);
            if (!$alreadySponsor) {
                $this->createMatrixEntry($currentUser, $userId, $matrixPosition, $option, $firstUserWithNoSponsor);
            }
        }
    }
}

private function getFirstUserWithoutSponsor($usersWithoutSponsor)
{
    foreach ($usersWithoutSponsor as $user) {
        $isSponsor1 = Matrix1s::where('sponser_id', $user->user_id)
                               ->where('position','L')->where('position','R')
                                ->where('current_id',$user->current_id)->exists();

       $isSponsor2 = Matrix1s::where('sponser_id', $user->user_id)
                              ->where('position','L')
                              ->where('current_id',$user->current_id)->exists();

            $isSponsor3 = Matrix1s::where('sponser_id', $user->user_id)
                                   ->where('position','R')
                                   ->where('current_id',$user->current_id)->exists();
            
        if (!$isSponsor1 && (!$isSponsor2 || !$isSponsor3)) {
            return $user->user_id;
        }
    }
    return null;
}


private function determinePosition($currentUser, $firstUserWithNoSponsor, $defaultPosition, $option)
{
    $existingEntry = Matrix1s::where('current_id', $currentUser->user_id)
        ->where('sponser_id', $firstUserWithNoSponsor)
        ->where('option', $option)
        ->where('position', $defaultPosition)
        ->where('current_id',$currentUser->user_id)
        ->first();
if($option === 'left'){
    return $existingEntry ? 'R' : $defaultPosition;
}else{
    return $existingEntry ? 'L' : $defaultPosition;
}
    
}

private function createMatrixEntry($currentUser, $userId, $position, $option, $sponsorId = null)
{
    $matrixEntry = new Matrix1s();
    $matrixEntry->current_id = $currentUser->user_id;
    $matrixEntry->username = User::where('user_id', $userId)->first()->username;
    $matrixEntry->user_id = $userId;
    $matrixEntry->user_posid = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->sponser_id = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->position = $position;
    $matrixEntry->option = $option;
    $matrixEntry->status = 'success';
    $matrixEntry->save();
}

/**---------------------================ Start Stage-2 =====================----------------------- */
public function stage2()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $currentUser = Auth::user();
    $currentUserId = $currentUser->user_id;

    function getDescendants2($parentId , $currentUserId)
    {
        $descendants = matrix1s::where('current_id',$currentUserId)->where('user_posid', $parentId)->pluck('user_id')->toArray();
        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants2($descendantId,$currentUserId));
        }
        return array_unique($descendants);
    }

    function getFirstLevelDescendant2($parentId, $position , $currentUserId)
    {
        return Matrix1s::where('current_id', $currentUserId)->where('user_posid', $parentId)
                ->where('user_posid', $parentId)
            ->where('position', $position)
            ->first();
    }
    function checkDescendantsStatus2($userId , $currentUserId): bool
    {
        $firstLeftUser = getFirstLevelDescendant2($userId, 'L',$currentUserId);
        $firstRightUser = getFirstLevelDescendant2($userId, 'R',$currentUserId);
    
        $secondLevelLeftFromLeftUser = $firstLeftUser ? getFirstLevelDescendant2($firstLeftUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromLeftUser = $firstLeftUser ? getFirstLevelDescendant2($firstLeftUser->user_id, 'R',$currentUserId) : null;
        $secondLevelLeftFromRightUser = $firstRightUser ? getFirstLevelDescendant2($firstRightUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromRightUser = $firstRightUser ? getFirstLevelDescendant2($firstRightUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant2($secondLevelLeftFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant2($secondLevelLeftFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant2($secondLevelRightFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant2($secondLevelRightFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant2($secondLevelLeftFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant2($secondLevelLeftFromRightUser->user_id, 'R',$currentUserId) : null;
        $thirdLevelLeftFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant2($secondLevelRightFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant2($secondLevelRightFromRightUser->user_id, 'R',$currentUserId) : null;
    
        $response = [
            $firstLeftUser->username ?? 'no',
            $secondLevelLeftFromLeftUser->username ?? 'no',
            $secondLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromLeftUser->username ?? 'no',
            $thirdLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromRightUser->username ?? 'no',
            $thirdLevelRightFromRightUser->username ?? 'no',
    
            $firstRightUser->username ?? 'no',
            $secondLevelLeftFromRightUser->username ?? 'no',
            $secondLevelRightFromRightUser->username ?? 'no',
            $thirdLevelLeftFromLeftRightUser->username ?? 'no',
            $thirdLevelRightFromLeftRightUser->username ?? 'no',
            $thirdLevelLeftFromRightRightUser->username ?? 'no',
            $thirdLevelRightFromRightRightUser->username ?? 'no',
        ];

        foreach ($response as $value) {
            if ($value === 'no') {
                return false; 
            }
        }
        return true; 
    }
    $leftUsers = Matrix1s::where('user_posid', $currentUserId)->where('position', 'L')
                          ->where('option', 'left')->where('current_id',$currentUserId)->get();
    $rightUsers = Matrix1s::where('user_posid', $currentUserId)->where('position', 'R')
                          ->where('option', 'right')->where('current_id',$currentUserId)->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants2( $leftUser->user_id , $currentUserId));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants2( $rightUser->user_id , $currentUserId));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

    $status = checkDescendantsStatus2($currentUserId,$currentUserId);

    $leftStatuses = [];
    foreach ($leftUserIdsAll as $leftUserId) {
        $leftStatuses[$leftUserId] = checkDescendantsStatus2($leftUserId,$currentUserId);
    }

    $rightStatuses = [];
    foreach ($rightUserIdsAll as $rightUserId) {
        $rightStatuses[$rightUserId] = checkDescendantsStatus2($rightUserId,$currentUserId);
    }
    $existsInMatrix1s = Matrix2s::where('user_id', $currentUser->user_id)->where('current_id',$currentUserId)->exists();

    if ($status && !$existsInMatrix1s) {
        
        $this->createMatrixAndReward2($currentUser);
    } else {

        foreach ($leftStatuses as $leftUserId => $leftStatus) {
            if ($leftStatus) {
                $this->processMatrixForUser2($leftUserId, $currentUser, 'L', 'left');
            }
        }
        foreach ($rightStatuses as $rightUserId => $rightStatus) {
            if ($rightStatus) {
                $this->processMatrixForUser2($rightUserId, $currentUser, 'R', 'right');
            }
        }
    }
    $matrix2s = Matrix2s::where('current_id',$currentUser->user_id)->where('user_id', $currentUser->user_id)->first();
  
    if ($matrix2s) {
    
        function getDescendants3($parentId, $currentUserId) {
            $descendants = matrix2s::where('current_id', $currentUserId)
                                   ->where('user_posid', $parentId)
                                   ->pluck('user_id')
                                   ->toArray();
    
            foreach ($descendants as $descendantId) {
                $descendants = array_merge($descendants, getDescendants3($descendantId, $currentUserId));
            }
            return array_unique($descendants);
        }
    
        $leftUsers = Matrix2s::where('user_posid', $currentUserId)
                             ->where('position', 'L')
                             ->where('option', 'left')
                             ->where('current_id', $currentUserId)
                             ->get();
    
        $rightUsers = Matrix2s::where('user_posid', $currentUserId)
                              ->where('position', 'R')
                              ->where('option', 'right')
                              ->where('current_id', $currentUserId)
                              ->get();
    
        $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
        $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();
    
        $leftUserIds = [];
        foreach ($leftUsers as $leftUser) {
            $leftUserIds = array_merge($leftUserIds, getDescendants3($leftUser->user_id, $currentUserId));
        }
        $leftUserIds = array_unique($leftUserIds);
    
        $rightUserIds = [];
        foreach ($rightUsers as $rightUser) {
            $rightUserIds = array_merge($rightUserIds, getDescendants3($rightUser->user_id, $currentUserId));
        }
        $rightUserIds = array_unique($rightUserIds);
    
        $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
        $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);
    
        $leftUserIdsAll = array_slice($leftUserIdsAll, 0, 7);
        $rightUserIdsAll = array_slice($rightUserIdsAll, 0, 7);
    
        $combinedUserIds = array_merge($leftUserIdsAll, $rightUserIdsAll);
    
        $rewardLimit = count($leftUserIdsAll) + count($rightUserIdsAll);
    
        $rewardCount = Reward::where('user_id', $currentUser->user_id)
                             ->where('option', 'stage-3')
                             ->count();
        $i = $rewardCount;
        while ($i < $rewardLimit) {
            if (isset($combinedUserIds[$i])) {
                $reward = new Reward();
                $reward->user_id = $currentUser->user_id;
                $reward->bonus = 6000;
                $reward->option = 'stage-3';
                $reward->status = 'success';
                $reward->save();
    
                if ($i + 1 == 14) {
                    $food = new Food();
                    $food->user_id = $currentUser->user_id;
                    $food->bonus = 50000;
                    $food->option = 'stage-3';
                    $food->status = 'success';
                    $food->save();
    
                    $currentUser->total_food += 50000;
                }
                $currentUser->commission_account += 6000;
                $currentUser->save();
            }
            $i++;
        }
    }

    return view('user.dashboard.pages.stage2_tree', compact('currentUser', 'status', 'matrix2s'));
}
private function createMatrixAndReward2($currentUser)
{
    $matrix1 = new Matrix2s();
    $matrix1->current_id = $currentUser->user_id;
    $matrix1->username = $currentUser->username;
    $matrix1->user_id = $currentUser->user_id;
    $matrix1->user_posid = $currentUser->sponser_id;
    $matrix1->sponser_id = $currentUser->sponser_id;
    $matrix1->position = $currentUser->user_position;
    $matrix1->option = 'top';
    $matrix1->status = 'success';
    $matrix1->save();
}

private function processMatrixForUser2($userId, $currentUser, $position, $option)
{
    $existsInMatrix = Matrix2s::where('current_id',$currentUser->user_id)
                               ->where('user_id', $userId)->exists();
    if (!$existsInMatrix) {
        $usersWithoutSponsor = Matrix2s::where('current_id', $currentUser->user_id)
                                        ->where('option', $option)
                                        ->where('current_id',$currentUser->user_id)->get();

        $firstUserWithNoSponsor = $this->getFirstUserWithoutSponsor2($usersWithoutSponsor);
        $aalId = Matrix1s::where('sponser_id', $currentUser->user_id)
                          ->where('position','L')
                          ->where('current_id',$currentUser->user_id)->exists();
        

        $alreadySponsor = Matrix2s::where('user_id', $userId)
                                   ->where('sponser_id', optional($aalId)->user_id)
                                   ->where('current_id',$currentUser->user_id)->exists();

        if (!$aalId) {
            $this->createMatrixEntry2($currentUser, $userId, $position, $option);
        } else {
            $matrixPosition = $this->determinePosition2($currentUser, $firstUserWithNoSponsor, $position, $option);
            if (!$alreadySponsor) {
                $this->createMatrixEntry2($currentUser, $userId, $matrixPosition, $option, $firstUserWithNoSponsor);
            }
        }
    }
}

private function getFirstUserWithoutSponsor2($usersWithoutSponsor)
{
    foreach ($usersWithoutSponsor as $user) {
        $isSponsor1 = Matrix2s::where('sponser_id', $user->user_id)
                               ->where('position','L')
                               ->where('position','R')
                               ->where('current_id',$user->current_id)->exists();

        $isSponsor2 = Matrix2s::where('sponser_id', $user->user_id)
                               ->where('position','L')
                               ->where('current_id',$user->current_id)->exists();

        $isSponsor3 = Matrix2s::where('sponser_id', $user->user_id)
                              ->where('position','R')
                              ->where('current_id',$user->current_id)->exists();

        if (!$isSponsor1 && (!$isSponsor2 || !$isSponsor3)) {
            return $user->user_id;
        }
    }
    return null;
}
private function determinePosition2($currentUser, $firstUserWithNoSponsor, $defaultPosition, $option)
{
    $existingEntry = Matrix2s::where('current_id', $currentUser->user_id)
                               ->where('sponser_id', $firstUserWithNoSponsor)
                               ->where('option', $option)
                               ->where('position', $defaultPosition)
                               ->where('current_id',$currentUser->user_id)->first();

    if($option === 'left'){
        return $existingEntry ? 'R' : $defaultPosition;
    }else{
         return $existingEntry ? 'L' : $defaultPosition;
    }
}

private function createMatrixEntry2($currentUser, $userId, $position, $option, $sponsorId = null)
{
    $matrixEntry = new Matrix2s();
    $matrixEntry->current_id = $currentUser->user_id;
    $matrixEntry->username = User::where('user_id', $userId)->first()->username;
    $matrixEntry->user_id = $userId;
    $matrixEntry->user_posid = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->sponser_id = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->position = $position;
    $matrixEntry->option = $option;
    $matrixEntry->status = 'success';
    $matrixEntry->save();
}
/**---------------------================Start Stage-3 =====================----------------------- */

public function stage3()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $currentUser = Auth::user();
    $currentUserId = $currentUser->user_id;

    function getDescendants3($parentId , $currentUserId)
    {
        $descendants = matrix2s::where('current_id',$currentUserId)->where('user_posid', $parentId)->pluck('user_id')->toArray();
        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants3($descendantId,$currentUserId));
        }
        return array_unique($descendants);
    }

    function getFirstLevelDescendant3($parentId, $position , $currentUserId)
    {
        return Matrix2s::where('current_id', $currentUserId)->where('user_posid', $parentId)
                       ->where('user_posid', $parentId)
                       ->where('position', $position)
                       ->where('current_id',$currentUserId)->first();
    }
    function checkDescendantsStatus3($userId , $currentUserId): bool
    {
        $firstLeftUser = getFirstLevelDescendant3($userId, 'L',$currentUserId);
        $firstRightUser = getFirstLevelDescendant3($userId, 'R',$currentUserId);
    
        $secondLevelLeftFromLeftUser = $firstLeftUser ? getFirstLevelDescendant3($firstLeftUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromLeftUser = $firstLeftUser ? getFirstLevelDescendant3($firstLeftUser->user_id, 'R',$currentUserId) : null;
        $secondLevelLeftFromRightUser = $firstRightUser ? getFirstLevelDescendant3($firstRightUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromRightUser = $firstRightUser ? getFirstLevelDescendant3($firstRightUser->user_id, 'R', $currentUserId) : null;
     
        $thirdLevelLeftFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant3($secondLevelLeftFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant3($secondLevelLeftFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant3($secondLevelRightFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant3($secondLevelRightFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant3($secondLevelLeftFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant3($secondLevelLeftFromRightUser->user_id, 'R',$currentUserId) : null;
        $thirdLevelLeftFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant3($secondLevelRightFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant3($secondLevelRightFromRightUser->user_id, 'R',$currentUserId) : null;
    
        $response = [
            $firstLeftUser->username ?? 'no',
            $secondLevelLeftFromLeftUser->username ?? 'no',
            $secondLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromLeftUser->username ?? 'no',
            $thirdLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromRightUser->username ?? 'no',
            $thirdLevelRightFromRightUser->username ?? 'no',
    
            $firstRightUser->username ?? 'no',
            $secondLevelLeftFromRightUser->username ?? 'no',
            $secondLevelRightFromRightUser->username ?? 'no',
            $thirdLevelLeftFromLeftRightUser->username ?? 'no',
            $thirdLevelRightFromLeftRightUser->username ?? 'no',
            $thirdLevelLeftFromRightRightUser->username ?? 'no',
            $thirdLevelRightFromRightRightUser->username ?? 'no',
        ];
    
        foreach ($response as $value) {
            if ($value === 'no') {
                return false; 
            }
        }
    
        return true; 
    }
    $leftUsers = Matrix2s::where('user_posid', $currentUserId)->where('position', 'L')
                          ->where('option', 'left')
                          ->where('current_id',$currentUser->user_id)->get();

    $rightUsers = Matrix2s::where('user_posid', $currentUserId)->where('position', 'R')
                          ->where('option', 'right')
                          ->where('current_id',$currentUser->user_id)->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants3( $leftUser->user_id , $currentUserId));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants3( $rightUser->user_id , $currentUserId));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

    $status = checkDescendantsStatus3($currentUserId,$currentUserId);

    $leftStatuses = [];
    foreach ($leftUserIdsAll as $leftUserId) {
        $leftStatuses[$leftUserId] = checkDescendantsStatus3($leftUserId,$currentUserId);
    }

    $rightStatuses = [];
    foreach ($rightUserIdsAll as $rightUserId) {
        $rightStatuses[$rightUserId] = checkDescendantsStatus3($rightUserId,$currentUserId);
    }
    $existsInMatrix1s = Matrix3s::where('user_id', $currentUser->user_id)
                                ->where('current_id',$currentUser->user_id)->exists();

    if ($status && !$existsInMatrix1s) {
        
        $this->createMatrixAndReward3($currentUser);
    } else {

        foreach ($leftStatuses as $leftUserId => $leftStatus) {
            if ($leftStatus) {
                $this->processMatrixForUser3($leftUserId, $currentUser, 'L', 'left');
            }
        }
        foreach ($rightStatuses as $rightUserId => $rightStatus) {
            if ($rightStatus) {
                $this->processMatrixForUser3($rightUserId, $currentUser, 'R', 'right');
            }
        }
    }
    $matrix3s = Matrix3s::where('current_id',$currentUser->user_id)
                        ->where('user_id', $currentUser->user_id)->first();
    
    if ($matrix3s) {
    
        function getDescendants4($parentId, $currentUserId) {
            $descendants = matrix3s::where('current_id', $currentUserId)
                                   ->where('user_posid', $parentId)
                                   ->where('current_id',$currentUserId)->pluck('user_id')
                                   ->toArray();
    
            foreach ($descendants as $descendantId) {
                $descendants = array_merge($descendants, getDescendants4($descendantId, $currentUserId));
            }
            return array_unique($descendants);
        }
    
        $leftUsers = Matrix3s::where('user_posid', $currentUserId)
                             ->where('position', 'L')
                             ->where('option', 'left')
                             ->where('current_id',$currentUser->user_id)->get();
    
        $rightUsers = Matrix3s::where('user_posid', $currentUserId)
                              ->where('position', 'R')
                              ->where('option', 'right')
                              ->where('current_id',$currentUser->user_id)->get();
    
        $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
        $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();
    
        $leftUserIds = [];
        foreach ($leftUsers as $leftUser) {
            $leftUserIds = array_merge($leftUserIds, getDescendants4($leftUser->user_id, $currentUserId));
        }
        $leftUserIds = array_unique($leftUserIds);
    
        $rightUserIds = [];
        foreach ($rightUsers as $rightUser) {
            $rightUserIds = array_merge($rightUserIds, getDescendants4($rightUser->user_id, $currentUserId));
        }
        $rightUserIds = array_unique($rightUserIds);
    
        $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
        $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);
    
        $leftUserIdsAll = array_slice($leftUserIdsAll, 0, 7);
        $rightUserIdsAll = array_slice($rightUserIdsAll, 0, 7);
    
        $combinedUserIds = array_merge($leftUserIdsAll, $rightUserIdsAll);
    
        $rewardLimit = count($leftUserIdsAll) + count($rightUserIdsAll);
    
        $rewardCount = Reward::where('user_id', $currentUser->user_id)
                             ->where('option', 'stage-4')
                             ->count();
        $i = $rewardCount;
        while ($i < $rewardLimit) {
            if (isset($combinedUserIds[$i])) {
                $reward = new Reward();
                $reward->user_id = $currentUser->user_id;
                $reward->bonus = 38000;
                $reward->option = 'stage-4';
                $reward->status = 'success';
                $reward->save();
    
                if ($i + 1 == 14) {
                    $food = new Food();
                    $food->user_id = $currentUser->user_id;
                    $food->bonus = 218000;
                    $food->option = 'stage-4';
                    $food->status = 'success';
                    $food->save();
    
                    $currentUser->total_food += 218000;
                }
                $currentUser->commission_account += 38000;
                $currentUser->save();
            }
            $i++;
        }
    }
    return view('user.dashboard.pages.stage3_tree', compact('currentUser', 'status', 'matrix3s'));
}
private function createMatrixAndReward3($currentUser)
{
    $matrix1 = new Matrix3s();
    $matrix1->current_id = $currentUser->user_id;
    $matrix1->username = $currentUser->username;
    $matrix1->user_id = $currentUser->user_id;
    $matrix1->user_posid = $currentUser->sponser_id;
    $matrix1->sponser_id = $currentUser->sponser_id;
    $matrix1->position = $currentUser->user_position;
    $matrix1->option = 'top';
    $matrix1->status = 'success';
    $matrix1->save();

}

private function processMatrixForUser3($userId, $currentUser, $position, $option)
{
    $existsInMatrix = Matrix3s::where('current_id',$currentUser->user_id)
                              ->where('user_id', $userId)->exists();
    if (!$existsInMatrix) {
        $usersWithoutSponsor = Matrix3s::where('current_id', $currentUser->user_id)
                                       ->where('option', $option)
                                       ->where('current_id',$currentUser->user_id)->get();

        $firstUserWithNoSponsor = $this->getFirstUserWithoutSponsor3($usersWithoutSponsor);
        $aalId = Matrix2s::where('sponser_id', $currentUser->user_id)
                         ->where('position','L')
                         ->where('current_id',$currentUser->user_id)->exists();
        

        $alreadySponsor = Matrix3s::where('user_id', $userId)
                                  ->where('sponser_id', optional($aalId)->user_id)
                                  ->where('current_id',$currentUser->user_id)->exists();

        if (!$aalId) {
            $this->createMatrixEntry3($currentUser, $userId, $position, $option);
        } else {
            $matrixPosition = $this->determinePosition3($currentUser, $firstUserWithNoSponsor, $position, $option);
            if (!$alreadySponsor) {
                $this->createMatrixEntry3($currentUser, $userId, $matrixPosition, $option, $firstUserWithNoSponsor);
            }
        }
    }
}

private function getFirstUserWithoutSponsor3($usersWithoutSponsor)
{
    foreach ($usersWithoutSponsor as $user) {
        $isSponsor1 = Matrix3s::where('sponser_id', $user->user_id)
                              ->where('position','L')
                              ->where('position','R')
                              ->where('current_id',$user->current_id)->exists();

        $isSponsor2 = Matrix3s::where('sponser_id', $user->user_id)
                              ->where('position','L')
                              ->where('current_id',$user->current_id)->exists();

        $isSponsor3 = Matrix3s::where('sponser_id', $user->user_id)
                                ->where('position','R')
                                ->where('current_id',$user->current_id)->exists();

        // $isSponsor = Matrix1s::where('sponser_id', $user->user_id)->exists();
        if (!$isSponsor1 && (!$isSponsor2 || !$isSponsor3)) {
            return $user->user_id;
        }
    }
    return null;
}


private function determinePosition3($currentUser, $firstUserWithNoSponsor, $defaultPosition, $option)
{
    $existingEntry = Matrix3s::where('current_id', $currentUser->user_id)
                             ->where('sponser_id', $firstUserWithNoSponsor)
                             ->where('option', $option)
                             ->where('position', $defaultPosition)
                             ->where('current_id',$currentUser->user_id)
                             ->first();

        if($option === 'left'){
            return $existingEntry ? 'R' : $defaultPosition;
        }else{
            return $existingEntry ? 'L' : $defaultPosition;
        }
}

private function createMatrixEntry3($currentUser, $userId, $position, $option, $sponsorId = null)
{
    $matrixEntry = new Matrix3s();
    $matrixEntry->current_id = $currentUser->user_id;
    $matrixEntry->username = User::where('user_id', $userId)->first()->username;
    $matrixEntry->user_id = $userId;
    $matrixEntry->user_posid = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->sponser_id = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->position = $position;
    $matrixEntry->option = $option;
    $matrixEntry->status = 'success';
    $matrixEntry->save();
}

/**---------------------================Start Stage-4 =====================----------------------- */

public function stage4()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $currentUser = Auth::user();
    $currentUserId = $currentUser->user_id;

    function getDescendants4($parentId , $currentUserId)
    {
        $descendants = matrix3s::where('current_id',$currentUserId)
                               ->where('user_posid', $parentId)->pluck('user_id')->toArray();
        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants4($descendantId,$currentUserId));
        }
        return array_unique($descendants);
    }

    function getFirstLevelDescendant4($parentId, $position , $currentUserId)
    {
        return Matrix3s::where('current_id', $currentUserId)->where('user_posid', $parentId)
                       ->where('user_posid', $parentId)
                       ->where('position', $position)
                       ->where('current_id',$currentUserId)->first();
    }
    function checkDescendantsStatus4($userId , $currentUserId): bool
    {
        // Get first level descendants
        $firstLeftUser = getFirstLevelDescendant4($userId, 'L',$currentUserId);
        $firstRightUser = getFirstLevelDescendant4($userId, 'R',$currentUserId);
    
        // Get second level descendants
        $secondLevelLeftFromLeftUser = $firstLeftUser ? getFirstLevelDescendant4($firstLeftUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromLeftUser = $firstLeftUser ? getFirstLevelDescendant4($firstLeftUser->user_id, 'R',$currentUserId) : null;
        $secondLevelLeftFromRightUser = $firstRightUser ? getFirstLevelDescendant4($firstRightUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromRightUser = $firstRightUser ? getFirstLevelDescendant4($firstRightUser->user_id, 'R', $currentUserId) : null;
    
        // Get third level descendants
        $thirdLevelLeftFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant4($secondLevelLeftFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant4($secondLevelLeftFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant4($secondLevelRightFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant4($secondLevelRightFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant4($secondLevelLeftFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant4($secondLevelLeftFromRightUser->user_id, 'R',$currentUserId) : null;
        $thirdLevelLeftFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant4($secondLevelRightFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant4($secondLevelRightFromRightUser->user_id, 'R',$currentUserId) : null;
    
        $response = [
            $firstLeftUser->username ?? 'no',
            $secondLevelLeftFromLeftUser->username ?? 'no',
            $secondLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromLeftUser->username ?? 'no',
            $thirdLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromRightUser->username ?? 'no',
            $thirdLevelRightFromRightUser->username ?? 'no',
    
            $firstRightUser->username ?? 'no',
            $secondLevelLeftFromRightUser->username ?? 'no',
            $secondLevelRightFromRightUser->username ?? 'no',
            $thirdLevelLeftFromLeftRightUser->username ?? 'no',
            $thirdLevelRightFromLeftRightUser->username ?? 'no',
            $thirdLevelLeftFromRightRightUser->username ?? 'no',
            $thirdLevelRightFromRightRightUser->username ?? 'no',
        ];
    
        foreach ($response as $value) {
            if ($value === 'no') {
                return false; 
            }
        }
    
        return true; 
    }
    $leftUsers = Matrix3s::where('user_posid', $currentUserId)->where('position', 'L')
                          ->where('option', 'left')
                          ->where('current_id',$currentUser->user_id)->get();

    $rightUsers = Matrix3s::where('user_posid', $currentUserId)->where('position', 'R')
                          ->where('option', 'right')
                          ->where('current_id',$currentUser->user_id)->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants4( $leftUser->user_id , $currentUserId));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants4( $rightUser->user_id , $currentUserId));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

    $status = checkDescendantsStatus4($currentUserId,$currentUserId);

    $leftStatuses = [];
    foreach ($leftUserIdsAll as $leftUserId) {
        $leftStatuses[$leftUserId] = checkDescendantsStatus4($leftUserId,$currentUserId);
    }

    $rightStatuses = [];
    foreach ($rightUserIdsAll as $rightUserId) {
        $rightStatuses[$rightUserId] = checkDescendantsStatus4($rightUserId,$currentUserId);
    }
    $existsInMatrix1s = Matrix4s::where('user_id', $currentUser->user_id)
                                ->where('current_id',$currentUser->user_id)->exists();

    if ($status && !$existsInMatrix1s) {
        
        $this->createMatrixAndReward4($currentUser);
    } else {

        foreach ($leftStatuses as $leftUserId => $leftStatus) {
            if ($leftStatus) {
                $this->processMatrixForUser4($leftUserId, $currentUser, 'L', 'left');
            }
        }
        foreach ($rightStatuses as $rightUserId => $rightStatus) {
            if ($rightStatus) {
                $this->processMatrixForUser4($rightUserId, $currentUser, 'R', 'right');
            }
        }
    }
    $matrix4s = Matrix4s::where('current_id',$currentUser->user_id)
                        ->where('user_id', $currentUser->user_id)->first();
    
    if ($matrix4s) {
    
        function getDescendants5($parentId, $currentUserId) {
            $descendants = matrix3s::where('current_id', $currentUserId)
                                   ->where('user_posid', $parentId)
                                   ->pluck('user_id')->toArray();
    
            foreach ($descendants as $descendantId) {
                $descendants = array_merge($descendants, getDescendants5($descendantId, $currentUserId));
            }
            return array_unique($descendants);
        }
    
        $leftUsers = Matrix4s::where('user_posid', $currentUserId)
                             ->where('position', 'L')
                             ->where('option', 'left')
                             ->where('current_id',$currentUser->user_id)->get();
    
        $rightUsers = Matrix4s::where('user_posid', $currentUserId)
                              ->where('position', 'R')
                              ->where('option', 'right')
                              ->where('current_id',$currentUser->user_id)->get();
    
        $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
        $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();
    
        $leftUserIds = [];
        foreach ($leftUsers as $leftUser) {
            $leftUserIds = array_merge($leftUserIds, getDescendants5($leftUser->user_id, $currentUserId));
        }
        $leftUserIds = array_unique($leftUserIds);
    
        $rightUserIds = [];
        foreach ($rightUsers as $rightUser) {
            $rightUserIds = array_merge($rightUserIds, getDescendants5($rightUser->user_id, $currentUserId));
        }
        $rightUserIds = array_unique($rightUserIds);
    
        $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
        $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);
    
        $leftUserIdsAll = array_slice($leftUserIdsAll, 0, 7);
        $rightUserIdsAll = array_slice($rightUserIdsAll, 0, 7);
    
        $combinedUserIds = array_merge($leftUserIdsAll, $rightUserIdsAll);
    
        $rewardLimit = count($leftUserIdsAll) + count($rightUserIdsAll);
    
        $rewardCount = Reward::where('user_id', $currentUser->user_id)
                             ->where('option', 'stage-5')
                             ->count();
        $i = $rewardCount;
        while ($i < $rewardLimit) {
            if (isset($combinedUserIds[$i])) {
                $reward = new Reward();
                $reward->user_id = $currentUser->user_id;
                $reward->bonus = 200000;
                $reward->option = 'stage-5';
                $reward->status = 'success';
                $reward->save();
    
                if ($i + 1 == 14) {
                    $food = new Food();
                    $food->user_id = $currentUser->user_id;
                    $food->bonus = 700000;
                    $food->option = 'stage-5';
                    $food->status = 'success';
                    $food->save();
    
                    $currentUser->total_food += 700000;
                }
                $currentUser->commission_account += 200000;
                $currentUser->save();
            }
            $i++;
        }
    }
    return view('user.dashboard.pages.stage4_tree', compact('currentUser', 'status', 'matrix4s'));
}
private function createMatrixAndReward4($currentUser)
{
    $matrix1 = new Matrix4s();
    $matrix1->current_id = $currentUser->user_id;
    $matrix1->username = $currentUser->username;
    $matrix1->user_id = $currentUser->user_id;
    $matrix1->user_posid = $currentUser->sponser_id;
    $matrix1->sponser_id = $currentUser->sponser_id;
    $matrix1->position = $currentUser->user_position;
    $matrix1->option = 'top';
    $matrix1->status = 'success';
    $matrix1->save();

}

private function processMatrixForUser4($userId, $currentUser, $position, $option)
{
    $existsInMatrix = Matrix4s::where('current_id',$currentUser->user_id)
                              ->where('user_id', $userId)->exists();
    if (!$existsInMatrix) {
        $usersWithoutSponsor = Matrix4s::where('current_id', $currentUser->user_id)
                                       ->where('option', $option)
                                       ->where('current_id',$currentUser->user_id)->get();

        $firstUserWithNoSponsor = $this->getFirstUserWithoutSponsor4($usersWithoutSponsor);
        $aalId = Matrix3s::where('sponser_id', $currentUser->user_id)
                         ->where('position','L')
                         ->where('current_id',$currentUser->user_id)->exists();
        

        $alreadySponsor = Matrix4s::where('user_id', $userId)
                                  ->where('sponser_id', optional($aalId)->user_id)
                                  ->where('current_id',$currentUser->user_id)->exists();

        if (!$aalId) {
            $this->createMatrixEntry4($currentUser, $userId, $position, $option);
        } else {
            $matrixPosition = $this->determinePosition4($currentUser, $firstUserWithNoSponsor, $position, $option);
            if (!$alreadySponsor) {
                $this->createMatrixEntry4($currentUser, $userId, $matrixPosition, $option, $firstUserWithNoSponsor);
            }
        }
    }
}

private function getFirstUserWithoutSponsor4($usersWithoutSponsor)
{
    foreach ($usersWithoutSponsor as $user) {
        $isSponsor1 = Matrix4s::where('sponser_id', $user->user_id)
            ->where('position','L')->where('position','R')->exists();

        $isSponsor2 = Matrix4s::where('sponser_id', $user->user_id)
                              ->where('position','L')
                              ->where('current_id',$user->user_id)->exists();

        $isSponsor3 = Matrix4s::where('sponser_id', $user->user_id)
                              ->where('position','R')
                              ->where('current_id',$user->user_id)->exists();

        // $isSponsor = Matrix1s::where('sponser_id', $user->user_id)->exists();
        if (!$isSponsor1 && (!$isSponsor2 || !$isSponsor3)) {
            return $user->user_id;
        }
    }
    return null;
}


private function determinePosition4($currentUser, $firstUserWithNoSponsor, $defaultPosition, $option)
{
    $existingEntry = Matrix4s::where('current_id', $currentUser->user_id)
                             ->where('sponser_id', $firstUserWithNoSponsor)
                             ->where('option', $option)
                             ->where('position', $defaultPosition)
                             ->where('current_id',$currentUser->user_id)->first();

        if($option === 'left'){
            return $existingEntry ? 'R' : $defaultPosition;
        }else{
            return $existingEntry ? 'L' : $defaultPosition;
        }
}

private function createMatrixEntry4($currentUser, $userId, $position, $option, $sponsorId = null)
{
    $matrixEntry = new Matrix4s();
    $matrixEntry->current_id = $currentUser->user_id;
    $matrixEntry->username = User::where('user_id', $userId)->first()->username;
    $matrixEntry->user_id = $userId;
    $matrixEntry->user_posid = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->sponser_id = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->position = $position;
    $matrixEntry->option = $option;
    $matrixEntry->status = 'success';
    $matrixEntry->save();
}

/**---------------------================Start Stage-5 =====================----------------------- */

public function stage5()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $currentUser = Auth::user();
    $currentUserId = $currentUser->user_id;

    function getDescendants5($parentId , $currentUserId)
    {
        $descendants = matrix4s::where('current_id',$currentUserId)
                               ->where('user_posid', $parentId)->pluck('user_id')->toArray();
        foreach ($descendants as $descendantId) {
            $descendants = array_merge($descendants, getDescendants5($descendantId,$currentUserId));
        }
        return array_unique($descendants);
    }

    function getFirstLevelDescendant5($parentId, $position , $currentUserId)
    {
        return Matrix4s::where('current_id', $currentUserId)->where('user_posid', $parentId)
                       ->where('user_posid', $parentId)
                       ->where('position', $position)->first();
    }
    function checkDescendantsStatus5($userId , $currentUserId): bool
    {
        $firstLeftUser = getFirstLevelDescendant5($userId, 'L',$currentUserId);
        $firstRightUser = getFirstLevelDescendant5($userId, 'R',$currentUserId);
    
        $secondLevelLeftFromLeftUser = $firstLeftUser ? getFirstLevelDescendant5($firstLeftUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromLeftUser = $firstLeftUser ? getFirstLevelDescendant5($firstLeftUser->user_id, 'R',$currentUserId) : null;
        $secondLevelLeftFromRightUser = $firstRightUser ? getFirstLevelDescendant5($firstRightUser->user_id, 'L',$currentUserId) : null;
        $secondLevelRightFromRightUser = $firstRightUser ? getFirstLevelDescendant5($firstRightUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant5($secondLevelLeftFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromLeftUser = $secondLevelLeftFromLeftUser ? getFirstLevelDescendant5($secondLevelLeftFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant5($secondLevelRightFromLeftUser->user_id, 'L', $currentUserId) : null;
        $thirdLevelRightFromRightUser = $secondLevelRightFromLeftUser ? getFirstLevelDescendant5($secondLevelRightFromLeftUser->user_id, 'R', $currentUserId) : null;
    
        $thirdLevelLeftFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant5($secondLevelLeftFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromLeftRightUser = $secondLevelLeftFromRightUser ? getFirstLevelDescendant5($secondLevelLeftFromRightUser->user_id, 'R',$currentUserId) : null;
        $thirdLevelLeftFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant5($secondLevelRightFromRightUser->user_id, 'L',$currentUserId) : null;
        $thirdLevelRightFromRightRightUser = $secondLevelRightFromRightUser ? getFirstLevelDescendant5($secondLevelRightFromRightUser->user_id, 'R',$currentUserId) : null;
    
        $response = [
            $firstLeftUser->username ?? 'no',
            $secondLevelLeftFromLeftUser->username ?? 'no',
            $secondLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromLeftUser->username ?? 'no',
            $thirdLevelRightFromLeftUser->username ?? 'no',
            $thirdLevelLeftFromRightUser->username ?? 'no',
            $thirdLevelRightFromRightUser->username ?? 'no',
    
            $firstRightUser->username ?? 'no',
            $secondLevelLeftFromRightUser->username ?? 'no',
            $secondLevelRightFromRightUser->username ?? 'no',
            $thirdLevelLeftFromLeftRightUser->username ?? 'no',
            $thirdLevelRightFromLeftRightUser->username ?? 'no',
            $thirdLevelLeftFromRightRightUser->username ?? 'no',
            $thirdLevelRightFromRightRightUser->username ?? 'no',
        ];
    
        foreach ($response as $value) {
            if ($value === 'no') {
                return false; 
            }
        }
    
        return true; 
    }
    $leftUsers = Matrix4s::where('user_posid', $currentUserId)->where('position', 'L')
                          ->where('option', 'left')
                          ->where('current_id',$currentUser->user_id)->get();

    $rightUsers = Matrix4s::where('user_posid', $currentUserId)->where('position', 'R')
                          ->where('option', 'right')
                          ->where('current_id',$currentUser->user_id)->get();

    $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
    $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();

    $leftUserIds = [];
    foreach ($leftUsers as $leftUser) {
        $leftUserIds = array_merge($leftUserIds, getDescendants5( $leftUser->user_id , $currentUserId));
    }
    $leftUserIds = array_unique($leftUserIds);

    $rightUserIds = [];
    foreach ($rightUsers as $rightUser) {
        $rightUserIds = array_merge($rightUserIds, getDescendants5( $rightUser->user_id , $currentUserId));
    }
    $rightUserIds = array_unique($rightUserIds);

    $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
    $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);

    $status = checkDescendantsStatus5($currentUserId,$currentUserId);

    $leftStatuses = [];
    foreach ($leftUserIdsAll as $leftUserId) {
        $leftStatuses[$leftUserId] = checkDescendantsStatus5($leftUserId,$currentUserId);
    }

    $rightStatuses = [];
    foreach ($rightUserIdsAll as $rightUserId) {
        $rightStatuses[$rightUserId] = checkDescendantsStatus5($rightUserId,$currentUserId);
    }
    $existsInMatrix1s = Matrix5s::where('user_id', $currentUser->user_id)
                                ->where('current_id',$currentUser->user_id)->exists();

    if ($status && !$existsInMatrix1s) {
        
        $this->createMatrixAndReward5($currentUser);
    } else {

        foreach ($leftStatuses as $leftUserId => $leftStatus) {
            if ($leftStatus) {
                $this->processMatrixForUser5($leftUserId, $currentUser, 'L', 'left');
            }
        }
        foreach ($rightStatuses as $rightUserId => $rightStatus) {
            if ($rightStatus) {
                $this->processMatrixForUser5($rightUserId, $currentUser, 'R', 'right');
            }
        }
    }
    $matrix5s = Matrix5s::where('current_id',$currentUser->user_id)->where('user_id', $currentUser->user_id)->first();
    if ($matrix5s) {
        function getDescendants6($parentId, $currentUserId) {
            $descendants = matrix3s::where('current_id', $currentUserId)
                                   ->where('user_posid', $parentId)
                                   ->pluck('user_id')
                                   ->toArray();
    
            foreach ($descendants as $descendantId) {
                $descendants = array_merge($descendants, getDescendants6($descendantId, $currentUserId));
            }
            return array_unique($descendants);
        }
        $leftUsers = Matrix4s::where('user_posid', $currentUserId)
                             ->where('position', 'L')
                             ->where('option', 'left')
                             ->where('current_id',$currentUser->user_id)->get();
    
        $rightUsers = Matrix4s::where('user_posid', $currentUserId)
                              ->where('position', 'R')
                              ->where('option', 'right')
                              ->where('current_id',$currentUser->user_id)->get();
    
        $leftUserIdsDirect = $leftUsers->pluck('user_id')->toArray();
        $rightUserIdsDirect = $rightUsers->pluck('user_id')->toArray();
    
        $leftUserIds = [];
        foreach ($leftUsers as $leftUser) {
            $leftUserIds = array_merge($leftUserIds, getDescendants6($leftUser->user_id, $currentUserId));
        }
        $leftUserIds = array_unique($leftUserIds);
    
        $rightUserIds = [];
        foreach ($rightUsers as $rightUser) {
            $rightUserIds = array_merge($rightUserIds, getDescendants6($rightUser->user_id, $currentUserId));
        }
        $rightUserIds = array_unique($rightUserIds);
    
        $leftUserIdsAll = array_merge($leftUserIdsDirect, $leftUserIds);
        $rightUserIdsAll = array_merge($rightUserIdsDirect, $rightUserIds);
    
        $leftUserIdsAll = array_slice($leftUserIdsAll, 0, 7);
        $rightUserIdsAll = array_slice($rightUserIdsAll, 0, 7);
    
        $combinedUserIds = array_merge($leftUserIdsAll, $rightUserIdsAll);
    
        $rewardLimit = count($leftUserIdsAll) + count($rightUserIdsAll);
    
        $rewardCount = Reward::where('user_id', $currentUser->user_id)
                             ->where('option', 'stage-6')
                             ->count();
        $i = $rewardCount;
        while ($i < $rewardLimit) {
            if (isset($combinedUserIds[$i])) {
                $reward = new Reward();
                $reward->user_id = $currentUser->user_id;
                $reward->bonus = 500000;
                $reward->option = 'stage-6';
                $reward->status = 'success';
                $reward->save();
    
                if ($i + 1 == 14) {
                    $food = new Food();
                    $food->user_id = $currentUser->user_id;
                    $food->bonus = 1000000;
                    $food->option = 'stage-6';
                    $food->status = 'success';
                    $food->save();
    
                    $currentUser->total_food += 1000000;
                }
                $currentUser->commission_account += 500000;
                $currentUser->save();
            }
            $i++;
        }
    }
   
    return view('user.dashboard.pages.stage5_tree', compact('currentUser', 'status', 'matrix5s'));
}
private function createMatrixAndReward5($currentUser)
{
    $matrix1 = new Matrix5s();
    $matrix1->current_id = $currentUser->user_id;
    $matrix1->username = $currentUser->username;
    $matrix1->user_id = $currentUser->user_id;
    $matrix1->user_posid = $currentUser->sponser_id;
    $matrix1->sponser_id = $currentUser->sponser_id;
    $matrix1->position = $currentUser->user_position;
    $matrix1->option = 'top';
    $matrix1->status = 'success';
    $matrix1->save();

}

private function processMatrixForUser5($userId, $currentUser, $position, $option)
{
    $existsInMatrix = Matrix5s::where('current_id',$currentUser->user_id)
                              ->where('user_id', $userId)->exists();
    if (!$existsInMatrix) {
        $usersWithoutSponsor = Matrix5s::where('current_id', $currentUser->user_id)
                                       ->where('option', $option)->get();

        $firstUserWithNoSponsor = $this->getFirstUserWithoutSponsor4($usersWithoutSponsor);
        $aalId = Matrix4s::where('sponser_id', $currentUser->user_id)
                         ->where('position','L')
                         ->where('current_id',$currentUser->user_id)->exists();
        

        $alreadySponsor = Matrix5s::where('user_id', $userId)
                                  ->where('sponser_id', optional($aalId)->user_id)
                                  ->where('current_id',$currentUser->user_id)->exists();

        if (!$aalId) {
            $this->createMatrixEntry5($currentUser, $userId, $position, $option);
        } else {
            $matrixPosition = $this->determinePosition5($currentUser, $firstUserWithNoSponsor, $position, $option);
            if (!$alreadySponsor) {
                $this->createMatrixEntry5($currentUser, $userId, $matrixPosition, $option, $firstUserWithNoSponsor);
            }
        }
    }
}

private function getFirstUserWithoutSponsor5($usersWithoutSponsor)
{
    foreach ($usersWithoutSponsor as $user) {
        $isSponsor1 = Matrix5s::where('sponser_id', $user->user_id)
                              ->where('position','L')
                              ->where('position','R')
                              ->where('current_id',$user->user_id)->exists();

        $isSponsor2 = Matrix5s::where('sponser_id', $user->user_id)
                              ->where('position','L')->exists();

        $isSponsor3 = Matrix5s::where('sponser_id', $user->user_id)
                              ->where('position','R')
                              ->where('current_id',$user->user_id)->exists();

        // $isSponsor = Matrix1s::where('sponser_id', $user->user_id)->exists();
        if (!$isSponsor1 && (!$isSponsor2 || !$isSponsor3)) {
            return $user->user_id;
        }
    }
    return null;
}


private function determinePosition5($currentUser, $firstUserWithNoSponsor, $defaultPosition, $option)
{
    $existingEntry = Matrix5s::where('current_id', $currentUser->user_id)
                             ->where('sponser_id', $firstUserWithNoSponsor)
                             ->where('option', $option)
                             ->where('position', $defaultPosition)
                             ->where('current_id',$currentUser->user_id)->first();

        if($option === 'left'){
            return $existingEntry ? 'R' : $defaultPosition;
        }else{
            return $existingEntry ? 'L' : $defaultPosition;
        }
}

private function createMatrixEntry5($currentUser, $userId, $position, $option, $sponsorId = null)
{
    $matrixEntry = new Matrix5s();
    $matrixEntry->current_id = $currentUser->user_id;
    $matrixEntry->username = User::where('user_id', $userId)->first()->username;
    $matrixEntry->user_id = $userId;
    $matrixEntry->user_posid = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->sponser_id = $sponsorId ?? $currentUser->user_id;
    $matrixEntry->position = $position;
    $matrixEntry->option = $option;
    $matrixEntry->status = 'success';
    $matrixEntry->save();
}

}
