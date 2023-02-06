<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny($user)
    {
        return $user->hasPermissionTo('Read-Notes')
            ? $this->allow()
            : $this->deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($user, Note $note)
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
        return $user->hasPermissionTo('Create-Note')
            ? $this->allow()
            : $this->deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, Note $note)
    {
        return $user->hasPermissionTo('Update-Note') && $user->id == $note->user_id
            ? $this->allow()
            : $this->deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, Note $note)
    {
        return $user->hasPermissionTo('Delete-Note') &&
        (auth('admin')->check() || $user->id == $note->user_id)
            ? $this->allow()
            : $this->deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore($user, Note $note)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete($user, Note $note)
    {
        //
    }
}
