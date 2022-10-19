<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportStudent implements ToModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $dateExc = Date::excelToDateTimeObject($row[3])->format('Y-m-d');
        // dd($dateExc->format('Y-m-d'));

        $date = date('d-m-Y', strtotime($dateExc));

        $pass = str_replace('-', '', $date);

        return new Student([
            'name' => $row[0],
            'email' => $row[1],
            'phone_number' => $row[2],
            'birth' => $dateExc,
            'number' => $row[4],
            'school_origin' => $row[5],
            'password' => Hash::make($pass),
        ]);
    }
}
