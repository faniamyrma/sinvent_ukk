@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <h1>Detail Kategori</h1>
        <div class="form-group">
            <label for="deskripsi">deskripsi</label>
            <input type="text" id="deskripsi" class="form-control" value="{{ $rsetKategori->kategori }}" readonly>
        </div>
        <div class="form-group">
            <label for="kategori">kategori</label>
            <input type="text" id="kategori" class="form-control" value="{{ $rsetKategori->kategori }}" readonly>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
