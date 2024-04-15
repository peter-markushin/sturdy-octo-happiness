<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\Shared\ValueObject\DateTimeInterface;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Domain\User\Aggregate\User;
use App\Domain\User\UserSearchCriteria;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Id;
use App\Domain\User\ValueObject\Name;
use App\Infrastructure\Account\AccountRepository;
use App\Infrastructure\Laravel\Models\AccountModel;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UserRepository implements \App\Domain\User\UserRepository
{
    public function create(User $user, string $password): void
    {
        $userModel = new UserModel();

        $userModel->id = $user->id()->value();
        $userModel->email = $user->email()->value();
        $userModel->name = $user->name()->value();
        $userModel->password = $password;
        $userModel->created_at = DateTimeValueObject::now()->value();

        $userModel->save();
    }

    public function update(User $user, ?string $password = null): void
    {
        $userModel = UserModel::findOrFail($user->id()->value());

        $userModel->email = $user->email()->value();
        $userModel->name = $user->name()->value();

        if (isset($password)) {
            $userModel->password = $password;
        }

        $userModel->save();
    }

    /**
     * @inheritDoc
     */
    public function getById(Id $userId): User
    {
        $userModel = UserModel::findOrFail($userId->value());

        return self::map($userModel);
    }

    public function findById(Id $userId): ?User
    {
        try {
            return $this->getById($userId);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    public function findByCriteria(UserSearchCriteria $criteria): array
    {
        $userModel = new UserModel();

        if (!empty($criteria->email())) {
            $userModel = $userModel->where('email', 'LIKE', '%' . $criteria->email() . '%');
        }

        if ($criteria->pagination() !== null) {
            $userModel = $userModel->take($criteria->pagination()->limit()->value())
                ->skip($criteria->pagination()->offset()->value());
        }

        if ($criteria->sort() !== null) {
            $userModel = $userModel->orderBy(
                $criteria->sort()->field()->value(),
                $criteria->sort()->direction()->value()
            );
        }

        return array_map(
            static fn(UserModel $user) => self::map($user),
            $userModel->get()->all()
        );
    }

    private static function map(UserModel $userModel): User
    {
        return User::create(
            Id::fromPrimitives($userModel->id),
            Email::fromString($userModel->email),
            Name::fromString($userModel->name),
            $userModel->accounts->map(static fn(AccountModel $accountModel) => AccountRepository::map($accountModel))->toArray(),
            DateTimeValueObject::fromPrimitives($userModel->created_at->format(DateTimeInterface::DATETIME_FORMAT)),
            $userModel->updated_at ? DateTimeValueObject::fromPrimitives($userModel->updated_at->format(DateTimeInterface::DATETIME_FORMAT)) : null,
        );
    }
}
