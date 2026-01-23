@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Dashboard Siswa</h2>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Hadir</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $hadir }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Hadir</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $hadir }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Izin</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $izin }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Alpha</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $alpha }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Pending</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $pending }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Disetujui</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $disetujui }}</h2>
</div>
<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Ditolak</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $ditolak }}</h2>
</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">

    {{-- GRAFIK --}}
    <div class="bg-white rounded-lg shadow-sm p-4 h-72">
        <h3 class="text-sm font-semibold mb-3">Grafik Kehadiran</h3>
        <div class="relative h-56">
            <canvas id="chartKehadiran"></canvas>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('chartKehadiran').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Hadir', 'Izin', 'Alpha'],
            datasets: [{
                data: [
                    {{ $hadir ?? 0 }},
                    {{ $izin ?? 0 }},
                    {{ $alpha ?? 0 }}
                ],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: { // ⬅️ DI SINI
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

});
</script>


    {{-- PROFIL PKL --}}
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="text-sm font-semibold mb-3">Profil PKL</h3>

        <div class="grid grid-cols-2 gap-4 text-sm">

            {{-- Informasi Siswa --}}
            <div>
                <p class="font-semibold text-blue-600 border-b pb-1 mb-2">
                    Informasi Siswa
                </p>

                <p class="text-gray-500">NIS</p>
                <p class="font-medium">{{ $siswa->nis }}</p>

                <p class="text-gray-500 mt-2">Nama</p>
                <p class="font-medium">{{ $siswa->nama }}</p>

                <p class="text-gray-500 mt-2">No. HP</p>
                <p class="font-medium">{{ $siswa->no_telp_siswa ?? '-' }}</p>
            </div>

            {{-- Guru Pembimbing --}}
            <div>
                <p class="font-semibold text-blue-600 border-b pb-1 mb-2">
                    Guru Pembimbing
                </p>

                <p class="text-gray-500">Nama</p>
                <p class="font-medium">{{ optional($siswa->guru)->nama ?? '-' }}</p>

                <p class="text-gray-500 mt-2">NIP</p>
                <p class="font-medium">{{ optional($siswa->guru)->nip ?? '-' }}</p>

                <p class="text-gray-500 mt-2">No. HP</p>
                <p class="font-medium">{{ optional($siswa->guru)->no_hp ?? '-' }}</p>
            </div>

        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-4">
    <h3 class="text-sm font-semibold mb-3">Tempat PKL</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div>
            <p class="text-gray-500">Nama Bengkel</p>
            <p class="font-medium text-blue-600">
                {{ optional($siswa->tempatPkl)->nama ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-500">Pemilik / PIC</p>
            <p class="font-medium">
                {{ optional($siswa->tempatPkl)->pembimbing ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-500">No. Telepon</p>
            <p class="font-medium">
                {{ optional($siswa->tempatPkl)->telp ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-500">Alamat</p>
            <p class="font-medium">
                {{ optional($siswa->tempatPkl)->alamat ?? '-' }}
            </p>
        </div>
    </div>
</div>
@endsection