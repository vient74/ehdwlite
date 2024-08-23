@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Informasi Desa') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        
                        <form action="{{ route('desa.update', $desa) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="kode_desa_lama" value="{{ $desa->id }}">
                        <div class="mb-3">
                            <label for="id">Kode Desa</label>
                            <input type="text" class="form-control @error('id') is-invalid @enderror"
                                   name="id" value="{{ old('id', $desa->id) }}" required>

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
                                   name="kode_bps" value="{{ old('kode_bps', $desa->kode_bps) }}" required>

                            <!-- error message untuk email -->
                            @error('kode_bps')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name">Nama Desa</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $desa->name) }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="mb-3">
                            <label for="long_name">Desa Lengkap</label>
                            <input type="text" class="form-control @error('long_name') is-invalid @enderror"
                                name="long_name" value="{{ old('long_name', $desa->long_name) }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('long_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-md btn-primary">Update</button>
                        <a href="{{ route('desa.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                     <div class="mb-3 col-md-12" style="margin-top:20px">
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Kode Wilayah</th>
                                    <th>Nama</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Provinsi</td>
                                    <td>{{ $prov->id  }}</td>
                                    <td>{{ $prov->provinsi  }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('provinsi.index', ['query' => $desa->provinsi_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>    
                                 <tr>
                                    <td class="text-center">2</td>
                                    <td>Kabupaten/Kota</td> 
                                        @if ($kab)
                                            <td>{{ $kab->id }}</td>
                                        @else
                                            <td>No data</td>
                                        @endif
                                    
                                     
                                        @if ($kab)
                                            <td>{{ $kab->kabupaten }}</td>
                                        @else
                                            <td>No data</td>
                                        @endif

                                     
                       
                                    <td class="text-center">
                                         <a href="{{ route('kabupaten.index', ['query' => $desa->kabkot_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>  
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Kecamatan</td>
                                    @if ($kec)
                                        <td>{{ $kec->id }}</td>
                                    @else
                                        <td>No data</td>
                                    @endif

                                    @if ($kec)
                                        <td>{{ $kec->kecamatan }}</td>
                                    @else
                                        <td>No data</td>
                                    @endif

                                    <td class="text-center">
                                         <a href="{{ route('kecamatan.index', ['query' => $desa->kecamatan_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>   
                                 <tr>
                                    <td class="text-center">4</td>
                                    <td>Desa/Kelurahan</td>
                                    <td>{{  $desa->id  }}</td>
                                    <td>{{  $desa->name }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('desa.index', ['query' => $desa->desa_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr> 
                            </tbody>
                        </table> 
                    </div>  
                       

                   

                    </div>    

 
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
