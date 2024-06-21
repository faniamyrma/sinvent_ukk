@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2>daftar barang masuk</h2>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barangmasuk.create') }}" class="btn btn-md btn-success mb-3">tambah barang</a>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th> Tanggal masuk</th>
                            <th> qty masuk</th>
                            <th> merk</th>
                            <th> seri</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rsetBarangmasuk as $barangmasuk)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $barangmasuk->tgl_masuk }}</td>
                                <td>{{ $barangmasuk->qty_masuk}}</td>
                                <td>{{ $barangmasuk->barang->merk }}</td> 
                                <td>{{ $barangmasuk->barang->seri }}</td>
                                
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangmasuk.destroy', $barangmasuk->id) }}" method="POST">
                                        <a href="{{ route('barangmasuk.show', $barangmasuk->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barangmasuk.edit', $barangmasuk->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($rsetBarangmasuk->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Data kategori belum tersedia!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {!! $rsetBarangmasuk->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
@endsection