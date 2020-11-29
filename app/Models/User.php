<?php
namespace App\Models;

use System\DB;

class User
{
    public static function create($input):bool
    {
        $password = $input['password'];
        $input['password'] = password_hash($password, PASSWORD_BCRYPT);

        //todo send email to user with credentials

        $query = DB::prepare('INSERT INTO users (first_name, last_name, email, password) 
                              VALUES (:first_name, :last_name, :email, :password)');

        return $query->execute([
            ':first_name' => $input['first_name'],
            ':last_name'  => $input['last_name'],
            ':password'   => $input['password'],
            ':email'      => $input['email']
        ]);
    }

    public static function checkCredentials($input):bool
    {
        $query = DB::prepare('SELECT password FROM users WHERE email = :email');

        $query->execute([':email' => $input['email']]);

        $user = $query->fetch();

        if(empty($user)){
            return false;
        }

        return password_verify($input['password'], $user['password']);
    }
}