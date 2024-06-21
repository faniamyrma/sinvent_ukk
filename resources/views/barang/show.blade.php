@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="pull-left">
            <h2>DETAIL BARANG</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>MERK</td>
                                <td>{{ $rsetBarang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $rsetBarang->seri }}</td>
                            </tr>
                            <tr>
                                <td>SPESIFIKASI</td>
                                <td>{{ $rsetBarang->spesifikasi }}</td>
                            </tr>
                            <tr>
                                <td>STOK</td>
                                <td>{{ $rsetBarang->stok }}</td>
                            </tr>
                            <tr>
                                <td>KATEGORI</td>
                                <td>{{ $rsetBarang->kategori->kategori }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
<br>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('storage/foto/'.$rsetBarang->foto) }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <h2>Riwayat Barang Masuk</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>TANGGAL MASUK</th>
                                    <th>JUMLAH MASUK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rsetBarang->barangMasuk as $index => $masuk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $masuk->tgl_masuk }}</td>
                                        <td>{{ $masuk->qty_masuk }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada riwayat barang masuk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h2>Riwayat Barang Keluar</h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>TANGGAL KELUAR</th>
                                    <th>JUMLAH KELUAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rsetBarang->barangKeluar as $index => $keluar)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $keluar->tgl_keluar }}</td>
                                        <td>{{ $keluar->qty_keluar }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada riwayat barang keluar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection
