<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nama Guru',
            'NIP',
            'Username',
            'Password',
            'Mapel',
            'No HP',
            'Jenis Ketenagaan',
            'Alamat',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Muharyono Hari Sayogo, S.Pd',
                '1987654321',
                'muharyono',
                'password123',
                'Matematika',
                '08123456789',
                'Guru Normatif',
                'Jl. Contoh No. 1',
            ],
        ];
    }
}
