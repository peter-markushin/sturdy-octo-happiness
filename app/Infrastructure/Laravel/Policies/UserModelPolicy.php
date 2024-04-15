<?php

namespace App\Infrastructure\Laravel\Policies;

use App\Infrastructure\Laravel\Models\UserModel;

final class UserModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $userModel, UserModel $userModelModel): bool
    {
        return $userModel->id === $userModelModel->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $userModel, UserModel $userModelModel): bool
    {
        return $userModel->id === $userModelModel->id;
    }
}
