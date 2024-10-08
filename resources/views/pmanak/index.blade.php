@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px">
        
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Remaja Putri') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Penerima Manfaat Anak Usia 0-59 Bulan</h2>
                        Jumlah penerima manfaat yang telah diinput {{ $formattedAngka = number_format($jumlahPm, 0, ',', '.') }} data  
                        <!-- Form Pencarian -->
                        <form action="{{ route('pmanak.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari penerima manfaat..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>
                         
                        <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">NIK</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Tgl Lahir</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Terjadwal</th>
                                    <th scope="col">Realisasi</th>
                                    <th scope="col">Nama KPM</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse ($anaks as $data)
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
                                    <td>
                                        <b>{{ strtoupper($data->nama) }}</b><br>

                                        <a href="{{ route('layanananak.showLayananIndividu', $data->nik) }}">
                                            <span class="badge bg-secondary">Lihat Layanan</span>
                                        </a>

                                    </td>
                                    <td>
                                        @if ($data->status_keluarga == true)
                                            Laki-laki
                                        @elseif ($data->status_keluarga == false)
                                            Perempuan
                                        @else
                                            Tidak Diketahui
                                        @endif
                                        
                                    </td>
                               
                                    <td class="text-center"> {{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}</td>
                                    <td class="text-end"> {{ $data->umur }}</td>
                                    <td class="text-end">{{ $data->task_ava }}</td>
                                    <td class="text-end">{{ $data->task_val }}</td>
                                    <td>{{ strtoupper($data->nama_kpm) }}</td>
                                    <td>{{ $data->desa }} </td>
                                    <td>
                                        <small>Last calculate<br>
                                             {{ \Carbon\Carbon::parse($data->last_calculate)->format('d-m-Y') }}
                                        </small><br>

                                        <small>Last update<br>
                                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i:s') }}
                                        </small>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="5">Data Sasaran tidak tersedia</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                    
                         <div class="pagination">
                                @if($anaks->previousPageUrl())
                                    <a href="{{ $anaks->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                @endif

                                @if($anaks->nextPageUrl())
                                    <a href="{{ $anaks->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                @endif
                            </div>
                            <br> 

                        <a href="{{ route('pmanak.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
