@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2>daftar barang keluar</h2>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barangkeluar.create') }}" class="btn btn-md btn-success mb-3">tambah barang</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th> Tanggal keluar</th>
                            <th> qty keluar</th>
                            <th> merk</th>
                            <th> seri</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rsetBarangkeluar as $barangkeluar)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $barangkeluar->tgl_keluar }}</td>
                                <td>{{ $barangkeluar->qty_keluar}}</td>
                                <td>{{ $barangkeluar->barang->merk }}</td> 
                                <td>{{ $barangkeluar->barang->seri }}</td>
                                
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangkeluar.destroy', $barangkeluar->id) }}" method="POST">
                                        <a href="{{ route('barangkeluar.show', $barangkeluar->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barangkeluar.edit', $barangkeluar->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($rsetBarangkeluar->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Data kategori belum tersedia!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {!! $rsetBarangkeluar->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
@endsection