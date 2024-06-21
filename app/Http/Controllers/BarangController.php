<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('merk', 'like', '%' . $search . '%')
                ->orWhere('seri', 'like', '%' . $search . '%')
                ->orWhere('spesifikasi', 'like', '%' . $search . '%');
        }

    $rsetBarang = $query->latest()->paginate(10);

    return view('barang.index', compact('rsetBarang'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            'kategori_id'   => 'required|not_in:blank',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DB::transaction(function () use ($request) {
            //upload image
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());

            //create post
            Barang::create([
                'merk'             => $request->merk,
                'seri'             => $request->seri,
                'spesifikasi'      => $request->spesifikasi,
                'kategori_id'      => $request->kategori_id,
                'foto'             => $foto->hashName()
            ]);
        });
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        $rsetBarang = Barang::with(['barangmasuk', 'barangkeluar'])->find($id);

        if (!$rsetBarang) {
            return redirect()->route('barang.index')->with(['error' => 'Barang tidak ditemukan']);
        }

        
        return view('barang.show', compact('rsetBarang'));
    }

    public function edit(string $id)
    {
        $akategori = Kategori::all();
        $rsetBarang = Barang::find($id);
        $selectedKategori = Kategori::find($rsetBarang->kategori_id);

        return view('barang.edit', compact('rsetBarang', 'akategori', 'selectedKategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'merk'        => 'required',
            'seri'        => 'required',
            'spesifikasi' => 'required',
            'kategori_id' => 'required|not_in:blank',
            'foto'        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        DB::transaction(function () use ($request, $id) {
            $rsetBarang = Barang::find($id);

            if ($request->hasFile('foto')) {

                //upload new image
                $foto = $request->file('foto');
                $foto->storeAs('public/foto', $foto->hashName());

                //delete old image
                Storage::delete('public/foto/'.$rsetBarang->foto);

                //update post with new image
                $rsetBarang->update([
                    'merk'          => $request->merk,
                    'seri'          => $request->seri,
                    'spesifikasi'   => $request->spesifikasi,
                    'kategori_id'   => $request->kategori_id,
                    'foto'          => $foto->hashName()
                ]);

            } else {

                $rsetBarang->update([
                    'merk'          => $request->merk,
                    'seri'          => $request->seri,
                    'spesifikasi'   => $request->spesifikasi,
                    'kategori_id'   => $request->kategori_id,
                ]);
            }
        });
        // Redirect to the index page with a success message
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $rsetBarang = Barang::find($id);

        if (!$rsetBarang) {
            return redirect()->route('barang.index')->with(['gagal' => 'Data tidak ditemukan!']);
        }

        if ($rsetBarang->stok > 0) {
            return redirect()->route('barang.index')->with(['gagal' => 'Data Gagal Dihapus karena barang memiliki stok.']);
        }

        DB::transaction(function () use ($rsetBarang, $id) {
            if (DB::table('barangmasuk')->where('barang_id', $id)->exists() ||
                DB::table('barangkeluar')->where('barang_id', $id)->exists()){
                    throw new \Exception('Data Gagal Dihapus karena barang terdapat pada barangmasuk/barangkeluar');
            } else {
                // $rsetBarang = Barang::find($id);
                $rsetBarang->delete();
                // return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
            }
        });
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
        // Deklarasi relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id'); // Sesuaikan 'kategori_id' dengan nama kolom yang menyimpan ID kategori pada tabel barang
    }

}
