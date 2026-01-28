<form action="{{ route('siswa.absensi.checkout') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="lat" id="lat">
    <input type="hidden" name="lng" id="lng">

    <div class="mb-3">
        <label class="text-sm font-medium">Foto Check-out</label>
        <input type="file" name="foto" required
               class="w-full text-sm border rounded px-2 py-1">
    </div>

    <button type="submit"
            class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">
        Check-out
    </button>
</form>
