@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Master Pengguna') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Master Data Pengguna</h2>
                        Jumlah akun pengguna {{ $jumlahuser }} akun
                        @if (Auth::user()->role->tag == 'sadmin')
                            <a href="{{ route('user.create') }}" class="btn btn-md btn-primary mb-3 float-end">Tambah</a>
                        @endif

                        <!-- Form Pencarian -->
                        <form action="{{ route('user.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari Pengguna..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                         <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th class="text-center">Status</th>
                                        <th>Kode Desa</th>
                                        <th class="text-center">Updated At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentIndex = 1; 
                                    @endphp
                                    @foreach($users as $data)
                                        <tr>
                                            <td>
                                               {{ $currentIndex++ }}
                                            </td>
                                            <td>
                                                {{ strtoupper($data->name) }} <br>
                                                <small>{{ $data->email }}</small><br>
                                            </td>
                                            <td>{{ $data->username }}</td>
                                            <td>{{ $data->role ? $data->role->name : 'Unknown' }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $data->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $data->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                 {{ $data->desa ? strtoupper($data->desa->name) : 'Desa Tidak Ditemukan' }}<br>
                                                {{ $data->desa_id }}
                                            </td>
                                            <td class="text-center">{{ $data->updated_at ? $data->updated_at->format('d-m-Y') : 'N/A' }}</td>
                                            <td class="text-center">
                                                @if (Auth::user()->role->tag == 'sadmin')
                                                <a href="{{ route('user.edit', $data->id) }}" class="btn btn-sm btn-warning">EDIT</a>
                                                @endif
                                                <a href="{{ route('user.editpassword', $data->id) }}" class="btn btn-sm btn-danger">UBAH PASSWORD</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if($users->isEmpty())
                                        <tr>
                                            <td class="text-center text-muted" colspan="8">Data Pengguna tidak tersedia</td>
                                        </tr>
                                    @endif
                                    
                                </tbody>
                            </table>

                            @component('components.pagination', ['paginator' => $users]) @endcomponent

                    <h3 style="margin-top: 40px">5 User ID terakhir yang dibuat</h3>        
                    <div class="mb-3 col-md-6" style="margin-top: 10px">
                        <table class="table table-bordered table-sm table-hover">
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
                                        <a href="{{ route('user.edit', $d->id) }}" class="btn btn-sm btn btn-secondary">LIHAT</a>        
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
