@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboards') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        
                        <form action="{{ route('provinsi.update', $provinsi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id">Kode Provinsi</label>
                            <input type="text" class="form-control @error('id') is-invalid @enderror"
                                   name="id" value="{{ old('id', $provinsi->id) }}" required>

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
                                   name="kode_bps" value="{{ old('kode_bps', $provinsi->kode_bps) }}" required>

                            <!-- error message untuk email -->
                            @error('kode_bps')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name">Nama Provinsi</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $provinsi->name) }}">

                            <!-- error message untuk name -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-md btn-primary">Update</button>
                        <a href="{{ route('provinsi.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                       

                   

                    </div>    

 
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
