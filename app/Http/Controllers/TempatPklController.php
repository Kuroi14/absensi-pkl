<?php

namespace App\Http\Controllers;

use App\Models\TempatPkl;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TempatPklController extends Controller
{
    public function index()
    {
        $data = TempatPkl::all();
        return view('tempat-pkl.index',['tempatPkls'=>TempatPkl::all()]);
    }

    public function create()
    {
        return view('admin.tempat-pkl.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'radius' => 'required|numeric'
    ]);

    TempatPkl::create($request->all());

    return redirect()->route('admin.tempat-pkl.index')
        ->with('success','Tempat PKL berhasil ditambahkan');
}

   public function edit(TempatPkl $tempatPkl)
{
    return response()->json($tempatPkl);
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|numeric',
        ]);

        TempatPkl::findOrFail($id)->update($request->all());

        return redirect('/admin/tempat-pkl')
            ->with('success', 'Tempat PKL berhasil diperbarui');
    }

    public function destroy($id)
    {
        TempatPkl::destroy($id);
        return redirect('/admin/tempat-pkl')
            ->with('success', 'Tempat PKL berhasil dihapus');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    $rows = Excel::toArray([], $request->file('file'))[0];

    DB::transaction(function () use ($rows) {
        foreach ($rows as $i => $row) {
            if ($i === 0) continue; // skip header
            if (!isset($row[0])) continue;

            TempatPkl::create([
                'nama'       => $row[0],
                'pembimbing' => $row[1] ?? null,
                'telp'       => $row[2] ?? null,
                'alamat'     => $row[3] ?? null,
                'latitude'   => $row[4] ?? null,
                'longitude'  => $row[5] ?? null,
                'radius'     => 100,
            ]);
        }
    });

    return back()->with('success', 'Data bengkel berhasil diimport');
}
public function template()
{
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=template_bengkel.csv',
    ];

    $callback = function () {
        $file = fopen('php://output', 'w');
        fputcsv($file, [
            'nama',
            'pembimbing',
            'telp',
            'alamat',
            'latitude',
            'longitude'
        ]);
        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
}

}
