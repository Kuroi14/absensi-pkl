<?php

namespace App\Exports;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapBulananExport implements FromCollection, WithHeadings
{
    protected $bulan;

    public function __construct($bulan)
{
    if (!$bulan || !preg_match('/^\d{4}-\d{2}$/', $bulan)) {
        $this->bulan = now()->format('Y-m');
    } else {
        $this->bulan = $bulan;
    }
}

    public function collection()
    {
        $start = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
        $end   = Carbon::createFromFormat('Y-m', $this->bulan)->endOfMonth();


        $query = Absensi::with('siswa')
            ->whereBetween('tanggal', [$start, $end]);

        if (auth()->user()->role === 'guru') {
            $query->whereHas('siswa', function ($q) {
                $q->where('guru_id', auth()->user()->guru->id);
            });
        }

        $data = $query->get()->groupBy('siswa_id');

        return $data->map(function ($items) {
            $siswa = $items->first()->siswa;
            return [
                'nama'  => $siswa->nama,
                'kelas' => $siswa->kelas,
                'hadir' => $items->count(),
            ];
        });
    }

    public function bulanan(Request $request)
{
    $bulan = $this->bulan;

    $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
    $end   = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();

    $query = Absensi::with('siswa')
        ->whereBetween('tanggal', [$start, $end]);

    if (auth()->user()->role === 'guru') {
        $query->whereHas('siswa', function ($q) {
            $q->where('guru_id', auth()->user()->guru->id);
        });
    }

    $absensis = $query->get()->groupBy('siswa_id');

    return view('rekap.bulanan', compact('absensis','bulan'));
}

    public function headings(): array
    {
        return ['Nama Siswa', 'Kelas', 'Jumlah Hadir'];
    }
}
