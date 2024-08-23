@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Informasi Kecamatan') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        
                        <form action="{{ route('kecamatan.update', $kecamatan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="kode_area_lama" value="{{ $kecamatan->id }}">
                        <div class="mb-3">
                            <label for="id">Kode Kecamatan</label>
                            <input type="text" class="form-control @error('id') is-invalid @enderror"
                                   name="id" value="{{ old('id', $kecamatan->id) }}" required>

                            <!-- error message untuk name -->
                            @error('id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kode_bps">Kode BPS</label>
                            <input type="kode_bps" class="form-control @error('kode_bps') is-invalid @enderror"
                                   name="kode_bps" value="{{ old('kode_bps', $kecamatan->kode_bps) }}" required>

                            <!-- error message untuk email -->
                            @error('kode_bps')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name">Nama Kecamatan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $kecamatan->name) }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="mb-3">
                            <label for="long_name">Info Kecamatan</label>
                            <input type="text" class="form-control @error('long_name') is-invalid @enderror"
                                name="long_name" value="{{ old('long_name', $kecamatan->long_name) }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('long_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-md btn-primary">Update</button>
                        <a href="{{ route('kecamatan.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                    </div>    

 
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
