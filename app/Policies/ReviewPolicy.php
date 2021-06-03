<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
    */
    public function before(User $user, $ability)
    {
        if ($user->is_admin === true) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return mixed
     */
    public function view(User $user, Review $review)
    {
        //anybody can view
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $item_id)
    {
        //see if user has not already done a review  //TODO see if is the way to catch user_id
        if (Review::where('client_id','=',$user_id)->where('$item_id','=',$item_id)->exists()){
            return false;
        }

        //only allow if user as purchased it
        $item_purchases_ids=DB::table('item_purchase')->where('item_id','=',$item_id)->get('purchase_id');
        
        foreach($item_purchases_ids as $id){

            $client_id=Purchase::where('id','=',$id)->get('client_id');
            
            if ($client_id===$user()){//TODO
                return true;
            }
            
            
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return mixed
     */
    public function update(User $user, Review $review)
    {
        //only author
        return $user->id === $review->client_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return mixed
     */
    public function delete(User $user, Review $review)
    {

        //only author and administrator can remove //TODO check if is proper way of user id
        return $user->id === $review->client_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return mixed
     */
    public function restore(User $user, Review $review)
    {
        //
        return $user->isAdministrator;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Review  $review
     * @return mixed
     */
    public function forceDelete(User $user, Review $review)
    {
        //
        return $user->isAdministrator;
    }
}
