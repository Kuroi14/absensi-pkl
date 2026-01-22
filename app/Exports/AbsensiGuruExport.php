<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiGuruExport implements FromCollection, WithHeadings
{
    protected $guruId;
    protected $bulan;

    public function __construct($guruId, $bulan)
    {
        $this->guruId = $guruId;
        $this->bulan  = $bulan;
    }

    public function collection(): Collection
    {
        [$year, $month] = explode('-', $this->bulan);

        return Absensi::with(['siswa', 'siswa.tempatPkl'])
            ->whereHas('siswa', fn ($q) =>
                $q->where('guru_id', $this->guruId)
            )
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->orderBy('tanggal')
            ->get()
            ->map(function ($a) {
                return [
                    'Tanggal'     => $a->tanggal,
                    'Nama Siswa'  => $a->siswa->nama ?? '-',
                    'Bengkel'     => $a->siswa->tempatPkl->nama ?? '-',
                    'Check In'    => $a->check_in,
                    'Check Out'   => $a->check_out,
                    'Latitude'    => $a->latitude,
                    'Longitude'   => $a->longitude,
                    'Status'      => $a->status ?? 'hadir',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Bengkel PKL',
            'Check In',
            'Check Out',
            'Latitude',
            'Longitude',
            'Status',
        ];
    }
}
