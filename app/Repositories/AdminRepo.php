<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AdminRepo
{
    // Reusable insert function for ANY table
    public function insertData($table, array $data)
    {
        return DB::table($table)->insert($data);
    }

    public function updateData($table, $id, array $data)
    {
        return DB::table($table)->where('id', $id)->update($data);
    }


    public function deleteData($table, $id)
    {
        return DB::table($table)->where('id', $id)->delete();
    }
}
