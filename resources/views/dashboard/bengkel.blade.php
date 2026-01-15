@extends('layouts.app')

@section('content')

@php
    $labels = $labels ?? [];
    $values = $values ?? [];
@endphp

<div class="p-4">

    <h2 class="text-xl font-bold mb-4">
        Grafik Kehadiran per Bengkel
    </h2>

    <div class="bg-white p-4 rounded shadow">

        @if(count($labels) > 0)
            <canvas id="chartBengkel" height="120"></canvas>
        @else
            <p class="text-gray-500 italic text-center">
                Belum ada data absensi.
            </p>
        @endif

    </div>

</div>

@if(count($labels) > 0)
<script>
    new Chart(document.getElementById('chartBengkel'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Kehadiran',
                data: @json($values),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endif

@endsection
