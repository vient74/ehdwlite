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
                        <h2>Master Data Desa</h2>
                        Jumlah Desa yang telah diinput {{ $formattedAngka = number_format($jumlahDesa, 0, ',', '.') }} desa
                        <a href="{{ route('desa.create') }}" class="btn btn-md btn-success mb-3 float-end">Tambah</a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('desa.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari desa..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                        <table class="table table-bordered mt-1 table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col">Info Lengkap</th>
                                    <th scope="col" class="text-end">Jumlah User</th>
                                    <th scope="col" class="text-end">Jumlah User KPM</th>
                                    <th scope="col" class="text-center">Updated</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($desas as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->long_name }}</td>
                                    <td class="text-end">{{ $data->jumlah_user }}</td>
                                    <td class="text-end">{{ $data->jumlah_kpm }}</td>
                                    <td class="text-center">{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('desa.edit', $data->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        <form action="{{ url('/desa/showkk/' . $data->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <a href="{{ route('desa.showkk', $data->id) }}" class="btn btn-sm p-1 btn-secondary">LIHAT KK</a>
                                        </form>
                                        <form action="{{ url('/desa/showsasaran/' . $data->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <a href="{{ route('desa.showsasaran', $data->id) }}" class="btn btn-sm btn-warning">LIHAT SASARAN</a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="9">Data desa tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

          
 

                        {{ $desas->links() }}

                

                        

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
