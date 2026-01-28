<div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">
    <h2 class="text-lg font-bold text-green-600">
        Izin {{ ucfirst($izin->jenis) }} Disetujui
    </h2>

    <p class="text-sm text-gray-600 mt-2">
        Anda telah mengajukan izin pada tanggal
        <strong>{{ $izin->tanggal }}</strong>
    </p>

    <p class="mt-4 text-xs text-gray-500">
        Absensi hari ini otomatis tercatat.
    </p>
</div>
