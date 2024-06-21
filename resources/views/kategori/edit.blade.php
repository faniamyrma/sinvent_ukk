@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <h1>Edit Kategori</h1>
        <form action="{{ route('kategori.update', $rsetKategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="ddeskripsi" class="form-control" value="{{ $rsetKategori->deskripsi }}" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    @foreach($aKategori as $key => $value)
                        <option value="{{ $key }}" {{ $key == $rsetKategori->kategori ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
@endsection
