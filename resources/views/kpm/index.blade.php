@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboards') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Master Data KPM</h2>
                        Jumlah akun KPM {{ htmlspecialchars($jumlahkpm) }} akun 
                        @if (Auth::user()->role->tag == 'sadmin')
                        <a href="{{ route('kpm.create') }}" class="btn btn-md btn-primary mb-3 float-end">Tambah</a>
                        @endif

                        <!-- Form Pencarian -->
                        <form action="{{ route('kpm.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari KPM..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                       <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                  
                                    <th scope="col">ID KPM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Kode Desa</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col" class="text-center">No HP</th>
                                    <th scope="col" class="text-center">Aktifitas</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Pembaharuan</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                           @forelse($kpms as $index => $data)
                                <tr>
                                      
                                    <td>{{ $data->id }}</td>  
                                    <td>
                                        <b>{{ strtoupper($data->name) }} </b> <br>
                                        <small>{{ $data->nik }} (NIK)</small>

                                    </td>
                                    <td>{{ $data->username }}<br>{{ $data->email }}</td>
                                    <td>{{ $data->desa_id }}</td>
                                    <td>{{ $data->desa }}</td>
                                    
                                    <td>{{ $data->nomor_telpon }}</td>
                                    <td class="text-center"> 

                                        <a href="{{ route('masterkk.inputbykpm', ['query' => $data->id])}}" class="btn btn-sm btn-light">Lihat Input KK</a>
                                        <a href="{{ route('mastersasaran.inputbykpm', ['query' => $data->id])}}" class="btn btn-sm btn-secondary">Lihat Input Sasaran</a>

                                    </td>
                                     
                                    <td class="text-center">
                                        <span class="badge {{ $data->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $data->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $data->updated_at ? $data->updated_at->format('d-m-Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('kpm.edit', $data->id) }}" class="btn btn-sm btn-warning">EDIT</a>
                                        @csrf
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="10">Data KPM tidak tersedia</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                        <div class="pagination">
                            @if($kpms->previousPageUrl())
                                <a href="{{ $kpms->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                            @endif

                            @if($kpms->nextPageUrl())
                                <a href="{{ $kpms->nextPageUrl() }}" class="btn btn-primary">Next</a>
                            @endif
                        </div>

                    <h3 style="margin-top: 40px">5 KPM ID terakhir yang dibuat</h3>        
                    <div class="mb-3 col-md-6" style="margin-top: 10px">
                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Tgl Pembuatan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @php 
                                $no=1;
                                @endphp

                                @foreach($lastid as $d)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td>{{ $d->name }} </td>
                                    <td class="text-center">{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('kpm.edit', $d->id) }}" class="btn btn-sm btn btn-secondary">LIHAT</a>        
                                    </td>
                                </tr> 
                                @endforeach   
                               
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
