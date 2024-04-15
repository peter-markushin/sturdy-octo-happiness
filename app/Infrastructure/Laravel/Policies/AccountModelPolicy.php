<?php

namespace App\Infrastructure\Laravel\Policies;

use App\Infrastructure\Laravel\Models\AccountModel;
use App\Infrastructure\Laravel\Models\UserModel;

class AccountModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserModel $userModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $userModel, AccountModel $accountModel): bool
    {
        return $accountModel->user === null || $accountModel->user->id === $userModel->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserModel $userModel): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $userModel, AccountModel $accountModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserModel $userModel, AccountModel $accountModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserModel $userModel, AccountModel $accountModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserModel $userModel, AccountModel $accountModel): bool
    {
        return false;
    }
}
