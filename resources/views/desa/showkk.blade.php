@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px; margin-left:20px">
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
                        <h2>Master Meta Kepala Keluarga</h2>
                        Jumlah Kepala Keluarga yang telah diinput {{ $jumlahKk }} data 
                        <!-- Form Pencarian -->
                        <form action="{{ route('desa.showkk', $id) }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari ..." value="{{ request('query') }}">
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
                                    <th scope="col">Terjadwal</th>
                                    <th scope="col">Realisasi</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($desas as $data)
                                <tr>
                                    <td>{{ $data->kk }}</td>
                                    <td>
                                        <span class="badge {{ $data->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span><br>
                                        <small>Tgl aktivasi<br>{{ \Carbon\Carbon::parse($data->actived_at)->format('d-m-Y') }}</small>
                                    </td>
                                    <td>{{ $data->nama_kepala_keluarga }}</td>
                                    <td>
                                        {{ $data->desa }}
                                          <br>
                                        {{ $data->desa_id }}
                                    </td>
                                    <td>{{ $data->alamat }}</td>
                                    <td class="text-end">{{ $data->task_ava }}</td>
                                    <td class="text-end">{{ $data->task_val }}<br>
                                         <small>Last Evaluation <br>
                                        {{ \Carbon\Carbon::parse($data->last_eval)->format('d-m-Y') }}<br></small>
                                    </td>
                                    <td>
                                        <small>Last updated <br>
                                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i:s') }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="5">Data Master KK tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $desas->links() }}

                        <a href="{{ route('desa.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
