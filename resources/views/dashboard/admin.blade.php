@extends('layouts.app')

@section('content')

{{-- =======================
    HEADER
======================= --}}
<div class="bg-white p-5 rounded-xl shadow flex items-center gap-4 mb-6">
    <span class="w-12 h-12 flex items-center justify-center
                 rounded-lg bg-indigo-100 text-indigo-600">
        <span class="material-symbols-outlined text-3xl">
            dashboard
        </span>
    </span>

    <div>
        <h2 class="text-xl font-bold text-gray-800">
            Dashboard Admin
        </h2>
        <p class="text-sm text-gray-500">
            Rekap absensi, guru, siswa, dan tempat PKL
        </p>
    </div>
</div>

{{-- =======================
    STATISTIK ATAS
======================= --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

    {{-- Total Guru --}}
    <div class="bg-white p-4 rounded-xl shadow flex items-center gap-4 border-l-4 border-blue-500">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined">server_person</span>
        </span>
        <div>
            <p class="text-gray-500 text-sm">Total Guru</p>
            <h2 class="text-2xl font-bold text-blue-600">{{ $totalGuru }}</h2>
        </div>
    </div>

    {{-- Total Siswa --}}
    <div class="bg-white p-4 rounded-xl shadow flex items-center gap-4 border-l-4 border-green-500">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-green-100 text-green-600">
            <span class="material-symbols-outlined">school</span>
        </span>
        <div>
            <p class="text-gray-500 text-sm">Total Siswa</p>
            <h2 class="text-2xl font-bold text-green-600">{{ $totalSiswa }}</h2>
        </div>
    </div>

    {{-- Total Absensi --}}
    <div class="bg-white p-4 rounded-xl shadow flex items-center gap-4 border-l-4 border-orange-500">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-orange-100 text-orange-600">
            <span class="material-symbols-outlined">check_circle</span>
        </span>
        <div>
            <p class="text-gray-500 text-sm">Total Absensi</p>
            <h2 class="text-2xl font-bold text-orange-600">{{ $totalAbsensi }}</h2>
        </div>
    </div>

    {{-- Total Izin --}}
    <div class="bg-white p-4 rounded-xl shadow flex items-center gap-4 border-l-4 border-purple-500">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600">
            <span class="material-symbols-outlined">mail_outline</span>
        </span>
        <div>
            <p class="text-gray-500 text-sm">Pengajuan Izin</p>
            <h2 class="text-2xl font-bold text-purple-600">{{ $totalIzin }}</h2>
        </div>
    </div>

</div>

{{-- =======================
    REKAP & GRAFIK
======================= --}}
<div class="space-y-6">

    {{-- Rekap Guru --}}
    <div class="bg-white rounded-xl shadow p-4">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            Rekap Guru Pendamping
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-3 py-2 text-left">Guru</th>
                        <th class="border px-3 py-2 text-center">Jumlah Siswa</th>
                        <th class="border px-3 py-2 text-center">Total Hadir</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rekapGuru as $g)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-3 py-2 font-medium">{{ $g->nama }}</td>
                        <td class="border px-3 py-2 text-center">{{ $g->siswas_count }}</td>
                        <td class="border px-3 py-2 text-center font-semibold text-green-600">
                            {{ $g->total_hadir }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Rekap Bengkel --}}
    <div class="bg-white rounded-xl shadow p-4">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            Rekap Bengkel PKL
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-3 py-2 text-left">Bengkel</th>
                        <th class="border px-3 py-2 text-center">Jumlah Siswa</th>
                        <th class="border px-3 py-2 text-center">Total Hadir</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rekapBengkel as $b)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-3 py-2 font-medium">{{ $b->nama }}</td>
                        <td class="border px-3 py-2 text-center">{{ $b->siswas_count }}</td>
                        <td class="border px-3 py-2 text-center font-semibold text-green-600">
                            {{ $b->total_hadir }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="bg-white rounded-xl shadow p-4">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">
            Tren Kehadiran Bulanan
        </h3>

        <div class="relative h-72">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>

</div>

{{-- =======================
    CHART JS (TIDAK DIUBAH)
======================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chartBulanan'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Jumlah Hadir',
            data: @json($values),
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

@endsection
