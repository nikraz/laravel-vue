<?php

namespace App\Http\Repositories;

use App\User;

class UsersRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @param string $name
     * @return void
     */
    public function updateNameById(int $id, string $name): void
    {
        $user = User::find($id);

        $user->name = $name;
        $user->save();
    }
}
