<label class="block font-semibold mb-1">Tempat PKL</label>
<select name="tempat_pkl_id"
        class="w-full border p-2 rounded"
        required>
    <option value="">-- Pilih Tempat PKL --</option>

    @foreach($tempatPkls as $t)
        <option value="{{ $t->id }}">
            {{ $t->nama }}
        </option>
    @endforeach
</select>
