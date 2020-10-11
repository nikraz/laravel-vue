<?php

namespace App\Http\Repositories;

use App\User;

class UsersRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @param string $name
     * @return bool
     */
    public function updateNameById(int $id, string $name): bool
    {
        $user = User::find($id);

        if ($user) {
            $user->name = $name;
            $user->save();
            return true;
        }

        return false;
    }
}
