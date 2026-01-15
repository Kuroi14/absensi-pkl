<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:5px; }
        th { background:#eee; }
    </style>
</head>
<body>

<h3>Rekap Absensi PKL - {{ $bulan }}</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Hadir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensis as $items)
        @php $siswa = $items->first()->siswa; @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $siswa->nama }}</td>
            <td>{{ $siswa->kelas }}</td>
            <td>{{ $items->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
