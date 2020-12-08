<?php

namespace App\Models;

use System\DB;

class Model
{
    public static $table;

    public static function all()
    {
        $query = DB::query('SELECT * FROM '.static::$table.';');

        return $query->fetchAll();
    }

    public static function find($id)
    {
        $query = DB::prepare('SELECT * FROM '.static::$table.' WHERE id = :id;');

        $query->execute([':id' => $id]);

        return $query->fetch();
    }

    public static function create(array $input): bool
    {
        $preparedInput = [];

        foreach ($input as $fieldName => $value) {
            $preparedInput[':'.$fieldName] = $value;
        }

        $query = DB::prepare('INSERT INTO '.static::$table.' ('.implode(",", array_keys($input)).') 
                              VALUES ('.implode(",", array_keys($preparedInput)).');');

        return $query->execute($preparedInput);
    }

    public static function update($id, array $input)
    {
        $preparedInput = [];
        $params = [];

        foreach ($input as $fieldName => $value) {
            $preparedInput[':'.$fieldName] = $value;
            $params[] = $fieldName.'=:'.$fieldName;
        }

        $query = DB::prepare('UPDATE '.static::$table.' SET '.implode(",", $params).' WHERE id=:id;');

        $preparedInput[':id'] = $id;

        return $query->execute($preparedInput);
    }

    public static function delete(int $id): bool
    {
        //todo
        return false;
    }
}