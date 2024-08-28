@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px">
        
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Penerima Manfaat') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Penerima Manfaat Calon Pengantin</h2>
                        Jumlah penerima manfaat yang telah diinput {{ $formattedAngka = number_format($jumlahPm, 0, ',', '.') }} data  
                        <!-- Form Pencarian -->
                        <form action="{{ route('pmcatin.index') }}" method="GET" class="mb-4">
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
                                    <th scope="col" class="text-end">Terjadwal</th>
                                    <th scope="col" class="text-end">Realisasi</th>
                                    <th scope="col" class="text-end">%</th>
                                    <th scope="col">Nama KPM</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                            @forelse ($catins as $data)
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

                                    <a href="{{ route('layanan_catin.show_layanan', $data->nik) }}">
                                        <span class="badge bg-primary">Lihat Layanan Diterima</span>
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
                                    <td class="text-end"><h5><span class="badge bg-danger">{{ $data->task_ava }}</span></h5></td>
                                    <td class="text-end"><h5><span class="badge bg-secondary">{{ $data->task_val }}</span></h5></td>
                                    <td class="text-end">
                                        @php
                                        $persen = 0;
                                        if ($data->task_ava >= 1 && $data->task_val >= 1)
                                            $persen = round(($data->task_val/$data->task_ava) * 100);

                                        if ($persen == 0)
                                            $persen=0;
                                        else
                                            $persen=$persen;
                                        @endphp

                                        {{ $persen }}
                                    </td>
                                    <td>{{ strtoupper($data->nama_kpm) }}</td>
                                    <td>{{ $data->desa }} </td>
                                    <td>
                                        <small>Kalkulasi Terakhir<br>
                                             {{ \Carbon\Carbon::parse($data->last_calculate)->format('d-m-Y') }}
                                        </small><br>
                                        <small>Pembaharuan Terakhir<br>
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
                                @if($catins->previousPageUrl())
                                    <a href="{{ $catins->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                @endif

                                @if($catins->nextPageUrl())
                                    <a href="{{ $catins->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                @endif
                            </div>
                            <br> 

                        <a href="{{ route('pmcatin.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
