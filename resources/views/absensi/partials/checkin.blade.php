<form action="{{ route('siswa.absensi.checkin') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">

    <div class="mb-3">
        <label class="text-sm font-medium">Foto Check-in</label>
        <input type="file" name="foto" required
               class="w-full text-sm border rounded px-2 py-1">
    </div>

    <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
        Check-in
    </button>
</form>
