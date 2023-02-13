<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SubCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        //
        return $user->hasPermissionTo('Read-SubCategories')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, SubCategory $subCategory)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        //
        return $user->hasPermissionTo('Create-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, SubCategory $subCategory)
    {
        //
        return $user->hasPermissionTo('Update-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, SubCategory $subCategory)
    {
        //
        return $user->hasPermissionTo('Delete-SubCategory')
        ? $this->allow()
        : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, SubCategory $subCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, SubCategory $subCategory)
    {
        //
    }
}
