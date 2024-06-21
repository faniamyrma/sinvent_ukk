@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2>Barang Masuk</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">TANGGAL MASUK</label>
                                <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" name="tgl_masuk" value="{{ old('tgl_masuk') }}" placeholder="Masukkan Tanggal Masuk...">
                           
                                <!-- error message untuk tanggal masuk -->
                                @error('tgl_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">QTY MASUK</label>
                                <input type="number" class="form-control @error('qty_masuk') is-invalid @enderror" name="qty_masuk" value="{{ old('qty_masuk') }}" placeholder="Masukkan Qty Masuk...">
                               
                                <!-- error message untuk qty masuk -->
                                @error('qty_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">merk BARANG</label>
                                <select class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" aria-label="Default select example">
                                    <option value="blank">Pilih Seri</option>
                                    @foreach ($abarang as $rowbarang)
                                        <option value="{{ $rowbarang->id }}">{{ $rowbarang->merk }} - {{ $rowbarang->seri }}</option>
                                    @endforeach
                                </select>
                               
                                <!-- error message untuk barang_id -->
                                @error('barang_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- <div class="form-group">
                                <label class="font-weight-bold">SERI BARANG</label>
                                <select class="form-control @error('barang_id') is-invalid @enderror" name="barang_id" aria-label="Default select example">
                                    <option value="blank">Pilih Seri</option>
                                    @foreach ($abarang as $rowbarang)
                                        <option value="{{ $rowbarang->id }}"></option>
                                    @endforeach
                                </select>
                               
                                error message untuk barang_id
                                @error('barang_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection