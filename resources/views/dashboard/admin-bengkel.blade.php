@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Grafik Kehadiran per Bengkel</h2>

<form method="GET" class="mb-4">
    <input type="month" name="bulan" value="{{ $bulan }}"
           class="border p-2 rounded">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Tampilkan
    </button>
</form>

<canvas id="chartBengkel" height="120"></canvas>

<script>
new Chart(document.getElementById('chartBengkel'), {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Total Kehadiran',
            data: @json($values),
            backgroundColor: '#22c55e'
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            x: { beginAtZero: true }
        }
    }
});
</script>
@endsection