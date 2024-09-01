@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px; margin-left:40px">
        <a href="{{ url('/provinsi') }}">Master Provinsi</a> &nbsp;
        <a href="{{ url('/kabupaten') }}">Master Kabupaten</a> &nbsp;
        <a href="{{ url('/kecamatan') }}">Master Kecamatan</a> 
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Master Data') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Daftar Kecamatan</h2>
                       
                   
                        <table class="table table-bordered mt-1 table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Info Lengkap</th>
                                    <th scope="col"></th>
                                    <th scope="col" class="text-end">Jumlah Desa</th>
                                    <th scope="col" class="text-end">Jumlah User</th>
                                    <th scope="col" class="text-end">Jumlah User KPM</th>
                                    <th scope="col" class="text-end">Jumlah KK</th>
                                    <th scope="col" class="text-end">Jumlah Sasaran(NIK)</th>
                                    <th scope="col" class="text-center">Updated</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $no=1;
                            @endphp 
                            
                            @forelse ($kecamatans as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->long_name }}</td>
                                    <td class="text-center"><a href="{{ route('desa.listdesa', $data->id) }}">Lihat Desa</a></td>
                                    <td class="text-end">{{ $data->jumlah_desa }}</td>
                                    <td class="text-end">{{ $data->jumlah_user }}</td>
                                    <td class="text-end">{{ $data->jumlah_kpm }}</td>
                                    <td class="text-end">{{ $data->jumlah_kk }}</td>
                                    <td class="text-end">{{ $data->jumlah_sasaran }}</td>
                                    <td class="text-center">{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        
                                       
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="9">Data desa tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                         {!! $kecamatans->withPath(url()->current())->links() !!}

                       <a href="{{ route('kabupaten.index') }}" class="btn btn-md btn-secondary">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
