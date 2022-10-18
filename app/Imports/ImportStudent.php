<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportStudent implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $date = date('d-m-Y', strtotime($row[3]));

        $pass = str_replace('-', '', $date);

        return new Student([
            'name' => $row[0],
            'email' => $row[1],
            'phone_number' => $row[2],
            'birth' => $row[3],
            'number' => $row[4],
            'school_origin' => $row[5],
            'password' => Hash::make($pass),
        ]);
    }
}
