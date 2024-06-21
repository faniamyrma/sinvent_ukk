<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Barangmasuk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB; 

class BarangmasukController extends Controller
{
    public function index()
    {
        $rsetBarangmasuk = Barangmasuk::with('barang')->latest()->paginate(10);

        return view('barangmasuk.index', compact('rsetBarangmasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarang = Barang::all();
        return view('barangmasuk.create',compact('abarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk' => 'required|after_or_equal:today',
            'qty_masuk' => 'required|numeric|min:1',
            'barang_id' => 'required|not_in:blank',
        ]);

         // Cari record barang masuk dengan tanggal dan merk yang sama
        $existingBarangMasuk = Barangmasuk::where('tgl_masuk', $request->tgl_masuk)
                                        ->whereHas('barang', function ($query) use ($request) {
                                            $query->where('id', $request->barang_id);
                                        })
                                        ->first();

        if ($existingBarangMasuk) {
            // Jika barang masuk sudah ada, tambahkan jumlah masuk
            $existingBarangMasuk->update([
                'qty_masuk' => $existingBarangMasuk->qty_masuk + $request->qty_masuk,
            ]);
        } else {
            // Jika barang masuk belum ada, buat record baru
            Barangmasuk::create([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id,
            ]);
        }

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Barang Masuk Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarangmasuk = Barangmasuk::find($id);
        return view('barangmasuk.show', compact('rsetBarangmasuk'));
    }

    public function edit(string $id)
    {
        $abarang = Barang::all();
        $rsetBarangmasuk = Barangmasuk::find($id);
        $selectedBarang = Barang::find($rsetBarangmasuk->barang_id);

        return view('barangmasuk.edit', compact('rsetBarangmasuk', 'abarang', 'selectedBarang'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tgl_masuk'    => 'required|after_or_equal:today',
            'qty_masuk'    => 'required|numeric|min:1',
            'barang_id'     => 'required|not_in:blank',
        ]);

        $rsetBarangmasuk = Barangmasuk::find($id);

        $rsetBarangmasuk->update([
            'tgl_masuk'    => $request->tgl_masuk,
            'qty_masuk'    => $request->qty_masuk,
            'barang_id'     => $request->barang_id
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $barangmasuk = Barangmasuk::find($id);

            if (!$barangmasuk) {
                return redirect()->route('barangmasuk.index')->with(['error' => 'Data tidak ditemukan!']);
            }

            $barangmasuk->delete();

            DB::commit();

            return redirect()->route('barangmasuk.index')->with(['success' => 'Data Barang Masuk Berhasil Dihapus!']);
        } catch (\Exception $e) {
            DB::rollback();
            report($e);
            return redirect()->route('barangmasuk.index')->with(['error' => 'Terjadi kesalahan. Data Barang Masuk tidak berhasil dihapus.']);
        }
    }
}
