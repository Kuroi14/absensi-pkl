@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Grafik Rekap Bimbingan</h2>

<canvas id="chartGuru"></canvas>

<script>
new Chart(document.getElementById('chartGuru'), {
    type: 'bar',
    data: {
        labels: ['Hadir','Alpha'],
        datasets: [{
            label: 'Jumlah',
            data: [{{ $hadir }}, {{ $alpha }}],
            backgroundColor: ['#3b82f6','#ef4444']
        }]
    }
});
</script>
@endsection