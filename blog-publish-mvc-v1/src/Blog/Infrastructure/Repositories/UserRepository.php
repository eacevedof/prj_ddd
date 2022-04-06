<?php
namespace App\Blog\Infrastructure\Repositories;

use App\Blog\Domain\UserEntity;

final class UserRepository
{
    public function ofIdOrFail(int $id): UserEntity
    {
        return new UserEntity($id, "some@email.com");
    }

    public function save(UserEntity $userEntity): void
    {
        echo "user saved ...<br/>";
    }
}