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
                <div class="card-header">{{ __('Master Data') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        <h2>Master Data Kabupaten</h2>
                        <a href="{{ route('kabupaten.create') }}" class="btn btn-md btn-success mb-3 float-end">Tambah</a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('kabupaten.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Cari kabupaten..." value="{{ request('query') }}">
                                <button class="btn btn-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                         <table class="table table-bordered mt-1 table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Kode BPS</th>
                                    <th scope="col">Kabupaten</th>
                                    <th scope="col" class="text-center">Updated</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($kabupatens as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->kode_bps }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td class="text-center">{{ $data->updated_at ? $data->updated_at->format('d-m-Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('kabupaten.edit', $data->id) }}" class="btn btn-sm btn-warning">EDIT</a>
                                        @csrf
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="8">Data kabupaten tidak tersedia</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                      
                            {!! $kabupatens->withPath(url()->current())->links() !!}

                    </div>    

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
