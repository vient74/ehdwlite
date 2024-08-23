@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px">
        <a href="{{ url('/provinsi') }}">Master Provinsi</a> &nbsp;
        <a href="{{ url('/kabupaten') }}">Master Kabupaten</a> &nbsp;
        <a href="{{ url('/kecamatan') }}">Master Kecamatan</a> 
    </div> 
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
                        <h2>Layanan Anak 0-59 Bulan</h2>
                        <!-- Form Pencarian -->
                        <form action="{{ route('layanananak.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari Layanan Anak..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                         
                        <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">KK</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nama Kepala Keluarga</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Task Ava</th>
                                    <th scope="col">Task Val</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($anaks as $data)
                                <tr>
                                    <td>{{ $data->kk }}</td>
                                    <td>
                                        <span class="badge {{ $data->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span><br>
                                        
                                    </td>
                                    <td> </td>
                                    <td>
                                        {{ $data->desa }}
                                          <br>
                                        {{ $data->desa_id }}
                                    </td>
                                    <td> </td>
                                    <td class="text-end"> </td>
                                    <td class="text-end"> <br>
                                         
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="5">Data layanan anak tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $anaks->links() }}

                        <a href="{{ route('desa.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
