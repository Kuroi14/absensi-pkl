@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Grafik Kehadiran Saya</h2>

<canvas id="chartSiswa"></canvas>

<script>
new Chart(document.getElementById('chartSiswa'), {
    type: 'doughnut',
    data: {
        labels: ['Hadir','Alpha','Izin'],
        datasets: [{
            data: [{{ $hadir }}, {{ $alpha }}, {{ $izin }}],
            backgroundColor: ['#22c55e','#ef4444','#facc15']
        }]
    }
});
</script>
@endsection