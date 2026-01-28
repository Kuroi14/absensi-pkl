@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center
                     rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                person
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Dashboard Siswa
            </h2>
            <p class="text-sm text-gray-500">
                Ringkasan kehadiran dan informasi PKL
            </p>
        </div>
    </div>

    {{-- =====================
        STATISTIK ATAS
    ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Hadir --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-green-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-green-100 text-green-600">
                <span class="material-symbols-outlined text-2xl">
                    check_circle
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">Hadir</p>
                <h2 class="text-2xl font-bold text-green-600">
                    {{ $hadir }}
                </h2>
            </div>
        </div>

        {{-- Izin --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-yellow-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-yellow-100 text-yellow-600">
                <span class="material-symbols-outlined text-2xl">
                    mail
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">Izin</p>
                <h2 class="text-2xl font-bold text-yellow-600">
                    {{ $izin }}
                </h2>
            </div>
        </div>

        {{-- Alpha --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-red-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-red-100 text-red-600">
                <span class="material-symbols-outlined text-2xl">
                    cancel
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">Alpha</p>
                <h2 class="text-2xl font-bold text-red-600">
                    {{ $alpha }}
                </h2>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-blue-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-blue-100 text-blue-600">
                <span class="material-symbols-outlined text-2xl">
                    hourglass_empty
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">Pending</p>
                <h2 class="text-2xl font-bold text-blue-600">
                    {{ $pending }}
                </h2>
            </div>
        </div>

    </div>

    {{-- =====================
        GRAFIK & PROFIL
    ===================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Grafik Kehadiran --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold mb-3 text-gray-700">
                Statistik Kehadiran
            </h3>

            <div class="relative h-72">
                <canvas id="chartKehadiran"></canvas>
            </div>
        </div>

        {{-- Profil PKL --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-sm font-semibold mb-4 text-gray-700">
                Profil PKL
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                {{-- Informasi Siswa --}}
                <div>
                    <p class="font-semibold text-blue-600 border-b pb-1 mb-3">
                        Informasi Siswa
                    </p>

                    <div class="space-y-2">
                        <div>
                            <p class="text-gray-500">NIS</p>
                            <p class="font-medium">{{ $siswa->nis }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Nama</p>
                            <p class="font-medium">{{ $siswa->nama }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">No. HP</p>
                            <p class="font-medium">{{ $siswa->no_telp_siswa ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">No. HP Orang Tua</p>
                            <p class="font-medium">{{ $siswa->no_telp_ortu ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Kelas</p>
                            <p class="font-medium">{{ $siswa->kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Guru Pembimbing --}}
                <div>
                    <p class="font-semibold text-blue-600 border-b pb-1 mb-3">
                        Guru Pembimbing
                    </p>

                    <div class="space-y-2">
                        <div>
                            <p class="text-gray-500">Nama</p>
                            <p class="font-medium">
                                {{ optional($siswa->guru)->nama ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">NIP</p>
                            <p class="font-medium">
                                {{ optional($siswa->guru)->nip ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">No. HP</p>
                            <p class="font-medium">
                                {{ optional($siswa->guru)->no_hp ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- =====================
        TEMPAT PKL
    ===================== --}}
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="text-sm font-semibold mb-4 text-gray-700">
            Tempat PKL
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
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

</div>

{{-- =====================
    CHART JS (TIDAK DIUBAH)
===================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chartKehadiran'), {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Izin', 'Alpha'],
        datasets: [{
            data: [{{ $hadir }}, {{ $izin }}, {{ $alpha }}],
            backgroundColor: ['#22c55e', '#facc15', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    font: { size: 11 }
                }
            }
        }
    }
});
</script>

@endsection
