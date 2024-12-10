<?php

namespace App\Services;

use App\Models\User;
use App\Models\Bonus_payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class MLMService
{
    /**
     * Calculate total BV for a user's left and right descendants.
     *
     * @param User $user
     * @return array
     */
    public function calculateDescendantsBV(User $user)
    {
        $leftChild = $user->leftChild;
        $rightChild = $user->rightChild;
    
        // dd($leftChild, $rightChild);

        $leftTotalBV = 0;
        $rightTotalBV = 0;
    
        if ($leftChild && is_object($leftChild)) {

            $leftDescendants = $this->getDescendants($leftChild->user_id);
            
            $leftTotalBV = $leftChild->bv + collect($leftDescendants)->sum('bv');
    
            if (!$this->descendantAlreadyStored($user->id, $leftChild->id)) {
                $this->storeDescendant($user->id, $leftChild->id); 
            }
    
            foreach ($leftDescendants as $descendant) {
                if (!$this->descendantAlreadyStored($user->id, $descendant->id)) {
                    $this->storeDescendant($user->id, $descendant->id);
                }
            }
        }
    
        if ($rightChild && is_object($rightChild)) {

            $rightDescendants = $this->getDescendants($rightChild->user_id);
            
            $rightTotalBV = $rightChild->bv + collect($rightDescendants)->sum('bv');
    
            if (!$this->descendantAlreadyStored($user->id, $rightChild->id)) {
                $this->storeDescendant($user->id, $rightChild->id); 
            }
    
            foreach ($rightDescendants as $descendant) {
                if (!$this->descendantAlreadyStored($user->id, $descendant->id)) {
                    $this->storeDescendant($user->id, $descendant->id);
                }
            }
        }
    
        return [$leftTotalBV, $rightTotalBV];
    }
    


    

    /**
     * Fetch descendants of a given user.
     *
     * @param User|null $user
     * @return \Illuminate\Support\Collection
     */
    public function getDescendants($parentId, $generation = 1, $maxGenerations = 20)
{
    if ($generation > $maxGenerations) {
        return [];
    }

    $descendants = User::where('user_posid', $parentId)->get(); 

    $allDescendants = [];

    foreach ($descendants as $descendant) {
        $allDescendants[] = $descendant;  
        $allDescendants = array_merge($allDescendants, $this->getDescendants($descendant->user_id, $generation + 1, $maxGenerations));
    }

    return $allDescendants; 
}


    /**
     * Store descendant information if not already stored.
     *
     * @param int $parentId
     * @param int $childId
     * @return void
     */
    private function storeDescendant($parentId, $childId)
    {
        DB::table('descendants')->insert([
            'user_id' => $parentId,
            'child_id' => $childId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Check if a descendant is already stored for a given user.
     *
     * @param int $parentId
     * @param int $childId
     * @return bool
     */
    private function descendantAlreadyStored($parentId, $childId)
    {
        return DB::table('descendants')
            ->where('user_id', $parentId)
            ->where('child_id', $childId)
            ->exists();
    }


    /**
     * Calculate and store matching bonus for the user.
     *
     * @param User $user
     * @param User $leftChild
     * @param User $rightChild
     * @param int $leftTotalBV
     * @param int $rightTotalBV
     * @return void
     */


    /**
     * Update the bonus level for the user.
     *
     * @param int $userId
     * @param int $newLevel
     * @return void
     */
    private function updateBonusLevel($userId, $newLevel)
    {
        // Update the bonus level, if required for future calculations
        // For simplicity, this is a no-op; you might want to log or perform further actions
    }

    /**
     * Calculate matching bonuses starting from level 1.
     *
     * @param User $user
     * @return array
     */
    public function calculateMatchingBonus(User $user)
    {
        // Your existing implementation of matching bonus calculation
    }

    /**
     * Calculate bonuses for all descendants.
     *
     * @param User $user
     * @return void
     */
    public function calculateBonusForDescendants(User $user)
    {
        // Your existing implementation of calculating bonuses for all descendants
    }
}
