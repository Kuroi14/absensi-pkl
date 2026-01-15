@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Grafik Kehadiran Siswa</h2>

<form method="GET" class="mb-4">
    <input type="month" name="bulan"
           value="{{ $bulan }}"
           class="border p-2 rounded">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Tampilkan
    </button>
</form>

<canvas id="chartSiswaDetail" height="120"></canvas>

<script>
new Chart(document.getElementById('chartSiswaDetail'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Hadir',
            data: @json($values),
            borderColor: '#16a34a',
            backgroundColor: 'rgba(22,163,74,0.2)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});
</script>
@endsection
