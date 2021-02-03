<?php

namespace App\Models;

use System\DB;

class User extends Model
{
    public static $table = 'users';

    public static function create(array $input): bool
    {
        $password = $input['password'];
        $input['password'] = password_hash($password, PASSWORD_BCRYPT);

        //todo send email to user with credentials
        return parent::create($input);
    }

    public static function update($id, array $input): bool
    {
        if (!empty($input['password'])) {
            $password = $input['password'];
            $input['password'] = password_hash($password, PASSWORD_BCRYPT);
            //todo resend email to user with credentials
        }

        return parent::update($id, $input);
    }

    public static function checkCredentials(array $input): ?int
    {
        $query = DB::prepare('SELECT id, password FROM users WHERE email = :email');

        $query->execute([':email' => $input['email']]);

        $user = $query->fetch();

        if (empty($user)) {
            return null;
        }

        return password_verify($input['password'], $user['password']) ? $user['id'] : null;
    }
}