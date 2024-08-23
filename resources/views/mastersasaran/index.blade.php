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
                <div class="card-header">{{ __('Dashboards') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Informasi Data Sasaran</h2>
                        Jumlah Sasaran yang telah diinput {{ $formattedAngka = number_format($jumlahSasaran, 0, ',', '.') }} 
                        <!-- Form Pencarian -->
                        <form action="{{ route('mastersasaran.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari ..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                         
                        <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nama Sasaran</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Tgl Lahir</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Hub. Keluarga</th>
                                    <th scope="col">Nama KPM</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($sasaran as $data)
                                <tr>
                                    <td>
                                        {{ $data->nik }}
                                        <br><small>No. Kartu Keluarga<br>
                                         {{ $data->kk }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $data->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td><b>{{ strtoupper($data->nama) }}</b></td>
                                    <td>
                                        @if ($data->jenis_kelamin == true)
                                            Laki-laki
                                        @elseif ($data->jenis_kelamin == false)
                                            Perempuan
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td class="text-center"> {{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}</td>
                                    <td class="text-end"> {{ $data->umur }}</td>
                                    <td> 
                                        @if ($data->status_keluarga == 1)
                                            Kepala Keluarga
                                        @elseif ($data->status_keluarga == 2)
                                            Ibu/Istri
                                        @elseif ($data->status_keluarga == 3)
                                            Anak
                                        @elseif ($data->status_keluarga == 5)
                                            Nenek
                                        @elseif ($data->status_keluarga == 7)
                                            Nenek Buyut
                                        @elseif ($data->status_keluarga == 8)
                                            Sudara Lain
                                        @else
                                            Tidak Diketahui
                                        @endif

                                    </td>
                                    <td>{{ strtoupper($data->nama_kpm) }}</td>
                                    <td>
                                        {{ $data->desa }} <br>
                                        <small>{{ $data->desa_id }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}</small></td>
                                    <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i:s') }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="11">Data Sasaran tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    
                         <div class="pagination">
                                @if($sasaran->previousPageUrl())
                                    <a href="{{ $sasaran->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                @endif

                                @if($sasaran->nextPageUrl())
                                    <a href="{{ $sasaran->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                @endif
                            </div>
                            <br> 
                        <a href="{{ route('mastersasaran.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
