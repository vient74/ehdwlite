@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px">
        
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Info Layanan diTerima') }}</div>
                <div class="card-body">

                    <div class="row-fluid">

                        <h2>Daftar Manfaat yang Diterima - Score 
                            <span class="badge bg-primary">
                                {{ $manfaat ? $manfaat->task_val : 'N/A' }}
                            </span>
                        </h2>

               
                        Total layanan yang harus diterima <h5 style="display:inline;"><span class="badge bg-secondary">{{ $manfaat ? $manfaat->task_ava : 'N/A'}} </h5><br> 
                        Total layanan yang diterima <h5 style="display:inline;"><span class="badge bg-secondary" style="display:inline;">{{ $manfaat ? $manfaat->task_val : 'N/A' }}  </span></h5>  
                        

                        <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col">Jadwal Pertanyaan</th>
                                    <th scope="col">Type</th>
                                    <th scope="col" class="text-center">Mulai</th>
                                    <th scope="col" class="text-center">Akhir</th>
                                    <th scope="col" class="text-end">Score</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $no=1;     
                            @endphp   

                            @forelse ($layanans as $data)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $data->quest }}</td>
                                <td>
                                    @php
                                    $parts = explode('|', $data->type);
                                    @endphp
                                    <small>{{ $parts[0] }}</small>
                                </td>
                                <td class="text-center"><small>{{ \Carbon\Carbon::parse($data->start)->format('d-m-Y') }}</small></td>
                                <td class="text-center"><small>{{ \Carbon\Carbon::parse($data->end)->format('d-m-Y') }}</small></td>
                                <td class="text-end">{{ $data->val }}</td>
                                <td class="text-center">
                                    @if ($data->val == 1)
                                        <span class="badge bg-success">Terima</span>
                                    @elseif ($data->val == 0)
                                        <span class="badge bg-danger">Tidak Terima</span>
                                    @else
                                        Belum diisi
                                    @endif

                                </td>
                                <td></td>
                            </tr>
                                
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="8">Data Layanan tidak tersedia</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                     

                        <a href="{{ route('pmremaja_putri.index') }}" class="btn btn-md btn-warning">back</a>

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
