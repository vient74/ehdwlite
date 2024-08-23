@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Data KPM') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                         <h3>Informasi KPM</h3>
                        <form action="{{ route('kpm.update', $kpm) }}" method="POST">
                        @csrf
                        @method('PUT')

 

                        <div class="mb-3">
                            <label for="desa_id">Pilih Desa</label>
                            <select id="selectDesa" name="desa_id" class="form-select" aria-label="Default select">
                                @if(isset($kpm) && $kpm->desa)
                                    <option value="{{ $kpm->desa_id }}" selected>{{ $kpm->desa->long_name }}</option>
                                @endif
                            </select>

                            @error('desa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="mb-3">
                            <label for="name">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                name="nik" value="{{ $kpm->nik }}">

                            <!-- error message untuk name -->
                            @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                                        
                         <div class="mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $kpm->name }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                         <div class="mb-3 col-md-3">
                            <label for="name">No HP</label>
                            <input type="text" class="form-control @error('nomor_telpon') is-invalid @enderror"
                                name="nomor_telpon" value="{{ $kpm->nomor_telpon }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('nomor_telpon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="name">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ $kpm->username }}">

                            <!-- error message untuk name -->
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="status">Status Pengguna</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ old('status', $user->status ?? '') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status', $user->status ?? '') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>



                        <div class="mb-3">
                            <label for="name">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $kpm->email }}">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <input type="hidden" name="password_hidden" value="{{ $kpm->password }}">
                        <button type="submit" id="1" class="btn btn-md btn-primary">Save</button>
                        <a href="{{ route('kpm.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                    
                     <div class="mb-3 col-md-12">
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Wilayah</th>
                                    <th>Nama</th>
                                    <th class="text-center">Input KK</th>
                                    <th class="text-center">Input Sasaran</th>
                                    <th class="text-center">Tgl Bergabung</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                 <tr>
                                    <td class="text-center">1</td>
                                    <td>{{  $kpm->desa_id  }}</td>
                                    <td>{{  $kpm->desa->name ?  $kpm->desa->name : '' }}</td>
                                    <td class="text-end">{{  $countKk }}</td>
                                    <td class="text-end">{{  $countSs }}</td>
                                    <td class="text-center">{{ $kpm->created_at ? $kpm->created_at->format('d-m-Y H:i:s') : 'N/A' }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('desa.index', ['query' => $kpm->desa_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr> 
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

      
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 
<script>
$(document).ready(function(){
    $("#selectDesa").select2({
        placeholder: 'Pilih Desa',
        ajax: {
            url: "{{ route('desa.autodesa') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                if (params.term.length < 3) {
                    return {
                        q: '' 
                    };
                }

                return {
                    q: params.term  
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Set the selected option if editing a user
    @if(isset($user) && $user->desa_id)
        var desaOption = new Option("{{ $user->desa->long_name }}", "{{ $user->desa_id }}", true, true);
        $('#selectDesa').append(desaOption).trigger('change');
    @endif
});
</script>

