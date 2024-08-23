@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="row-fluid justify-content-center" style="margin-bottom: 20px; margin-left:40px">
        <a href="{{ url('/provinsi') }}">Master Provinsi</a> &nbsp;
        <a href="{{ url('/kecamatan') }}">Master Kecamatan</a> &nbsp;
        <a href="{{ url('/desa') }}">Master Desa</a> 
    </div> 

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Data Kepala Keluarga') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Informasi Kepala Keluarga</h2>
                        Jumlah Kepala Keluarga yang telah diinput {{ $formattedAngka = number_format($jumlahKk, 0, ',', '.') }} 
                        <a href="{{ route('masterkk.create') }}" class="btn btn-md btn-success mb-3 float-end">Tambah</a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('masterkk.inputbykpm') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari ..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                        <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">KK</th>
                                    <th scope="col">Nama Kepala Keluarga</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col" class="text-end">Pelayanan</th>
                                    <th scope="col" class="text-end">Terima Pelayanan</th>
                                    <th scope="col">KPM</th>
                                    <th scope="col" class="text-center">Created</th>
                                    <th scope="col" class="text-center">Updated</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($kks as $data)
                                <tr>
                                    <td></td>
                                    <td>{{ $data->kk }}</td>
                                    <td>
                                        <b>{{ strtoupper($data->nama_kepala_keluarga) }}</b> <br>
                                        <small>
                                             {{ $data->alamat }}
                                             {{ $data->rw }}  {{ $data->rt }}    
                                        </small>    
                                    </td>
                                    <td>
                                        {{ $data->nama_desa  }} <br>
                                        <small>{{ $data->kode_desa  }}</small>
                                    </td>
                                    <td class="text-end">{{ $data->task_ava }}</td>
                                    <td class="text-end">{{ $data->task_val }}</td>
                                    <td>{{ $data->nama_kpm }}</td>
                                    <td class="text-center">{{ $data->created_at ? $data->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                    <td class="text-center">{{ $data->updated_at ? $data->updated_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('masterkk.edit', $data->kk) }}" class="btn btn-sm btn-warning">EDIT</a>
                                        @csrf
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="10">Data kepala keluarga tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $kks->links() }}

                        <a href="{{ url('home') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
