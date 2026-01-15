@extends('layouts.app')

@section('content')

@php
    $labels = $labels ?? [];
    $values = $values ?? [];
    $bulan  = $bulan  ?? now()->format('Y-m');

    $totalGuru    = $totalGuru    ?? 0;
    $totalSiswa   = $totalSiswa   ?? 0;
    $totalAbsensi = $totalAbsensi ?? 0;
    $totalIzin    = $totalIzin    ?? 0;

    $rekapGuru    = $rekapGuru    ?? collect();
    $rekapBengkel = $rekapBengkel ?? collect();
    
@endphp


<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Total Guru</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $totalGuru }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-green-500">
    <p class="text-gray-500 text-sm">Total Siswa</p>
    <h2 class="text-2xl font-bold text-green-600">{{ $totalSiswa }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
    <p class="text-gray-500 text-sm">Total Absensi</p>
    <h2 class="text-2xl font-bold text-orange-600">{{ $totalAbsensi }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-purple-500">
    <p class="text-gray-500 text-sm">Pengajuan Izin</p>
    <h2 class="text-2xl font-bold text-purple-600">{{ $totalIzin }}</h2>
</div>

</div>

<div class="bg-white p-4 rounded shadow mb-6">
<h3 class="font-semibold mb-3">Rekap Guru Pendamping</h3>

<table class="w-full border">
<thead class="bg-gray-100">
<tr>
    <th class="border p-2">Guru</th>
    <th class="border p-2">Jumlah Siswa</th>
    <th class="border p-2">Total Hadir</th>
</tr>
</thead>
<tbody>
@foreach($rekapGuru as $g)
<tr>
    <td class="border p-2">{{ $g->nama }}</td>
    <td class="border p-2 text-center">{{ $g->siswas_count }}</td>
    <td class="border p-2 text-center">{{ $g->total_hadir }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="bg-white p-4 rounded shadow">
<h3 class="font-semibold mb-3">Rekap Bengkel PKL</h3>

<table class="w-full border">
<thead class="bg-gray-100">
<tr>
    <th class="border p-2">Bengkel</th>
    <th class="border p-2">Jumlah Siswa</th>
    <th class="border p-2">Total Hadir</th>
</tr>
</thead>
<tbody>
@foreach($rekapBengkel as $b)
<tr>
    <td class="border p-2">{{ $b->nama }}</td>
    <td class="border p-2 text-center">{{ $b->siswas_count }}</td>
    <td class="border p-2 text-center">{{ $b->total_hadir }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="bg-white p-4 rounded shadow mb-6">
    <h3 class="font-semibold mb-3">Grafik Kehadiran Bulanan</h3>

    <form method="GET" action="/dashboard" class="mb-4">
        <input type="month" name="bulan"
               value="{{ $bulan }}"
               class="border p-2 rounded">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Tampilkan
        </button>
    </form>

    <canvas id="chartBulanan" height="120"></canvas>
</div>

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
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>


@endsection
