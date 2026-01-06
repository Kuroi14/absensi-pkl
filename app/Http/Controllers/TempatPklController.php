<?php

namespace App\Http\Controllers;

use App\Models\TempatPkl;
use Illuminate\Http\Request;

class TempatPklController extends Controller
{
    public function index()
    {
        $data = TempatPkl::all();
        return view('tempat-pkl.index', compact('data'));
    }

    public function create()
    {
        return view('tempat-pkl.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|numeric',
        ]);

        TempatPkl::create($request->all());

        return redirect('/tempat-pkl')
            ->with('success', 'Tempat PKL berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tempat = TempatPkl::findOrFail($id);
        return view('tempat-pkl.edit', compact('tempat'));
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

        return redirect('/tempat-pkl')
            ->with('success', 'Tempat PKL berhasil diperbarui');
    }

    public function destroy($id)
    {
        TempatPkl::destroy($id);
        return redirect('/tempat-pkl')
            ->with('success', 'Tempat PKL berhasil dihapus');
    }
}
