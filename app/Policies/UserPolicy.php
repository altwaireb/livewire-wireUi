<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('browse_users');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermission('view_users') and
            (
                !$model->hasPermission('administrator')
                or
                $user->id === $model->id
                or
                $user->id === 1
            );

    }

    public function create(User $user)
    {
        return $user->hasPermission('create_users');
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermission('update_users')
            and
            (
                !$model->hasPermission('administrator')
                or
                $user->id === $model->id
                or
                $user->id === 1
            );

    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermission('delete_users')
            and
            $model->id != 1
            and
            (
                !$model->hasPermission('administrator')
                or
                $user->id === $model->id
                or
                $user->id === 1
            );
    }

    public function restore(User $user, User $model)
    {
        return $user->hasPermission('restore_users');

    }

    public function forceDelete(User $user, User $model)
    {
        return $user->hasPermission('forceDelete_users');
    }
}
