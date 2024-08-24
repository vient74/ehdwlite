@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Memperbaharui ID Pengguna') }}</div>

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
                        <h3>Informasi Pengguna</h3>
                        <form action="{{ route('user.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')


                           @if (Auth::user()->role->tag == 'sadmin')
                           <div class="mb-3">
                            <label for="role_id">Level Pengguna</label>
                            <select name="role_id" class="form-select">
                                @foreach($roles as $role)
                                    <option value="{{ $role->kode }}" 
                                        {{ $user->role_id == $role->kode ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @else
                            <input type="hidden" name='role_id' value="{{ $user->role_id }}">
                        @endif

                        

                       
                        <div class="mb-3">
                            <label for="desa_id">Pilih Desa</label>
                            <select id="selectDesa" name="desa_id" class="form-select" aria-label="Default select">
                                @if(isset($user) && $user->desa)
                                    <option value="{{ $user->desa_id }}" selected>{{ $user->desa->long_name }}</option>
                                @endif
                            </select>

                            @error('desa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                       


                                        
                         <div class="mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ $user->name }}" oninput="this.value = this.value.toUpperCase();">

                            <!-- error message untuk name -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="name">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ $user->username }}">

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
                                name="email" value="{{ $user->email }}">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <input type="hidden" name="password_hidden" value="{{ $user->password }}">
                        <button type="submit" id="1" class="btn btn-md btn-primary">Save</button>
                        <a href="{{ route('user.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                       
                    <div class="mb-3 col-md-12">
                        <table class="table table-bordered table-small table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Wilayah</th>
                                    <th>Nama</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>{{ $user->provinsi_id  }}</td>
                                    <td>{{ optional($user->provinsi)->name  }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('provinsi.index', ['query' => $user->provinsi_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>    
                                 <tr>
                                    <td class="text-center">2</td>
                                    <td>{{ $user->kabkot_id  }}</td>
                                    <td>{{ optional($user->kabupaten)->name }}</td>
                       
                                    <td class="text-center">
                                         <a href="{{ route('kabupaten.index', ['query' => $user->kabkot_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>  
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>{{ $user->kecamatan_id  }}</td>
                                    <td>{{ optional($user->kecamatan)->name }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('kecamatan.index', ['query' => $user->kecamatan_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr>   
                                 <tr>
                                    <td class="text-center">4</td>
                                    <td>{{  $user->desa_id  }}</td>
                                    <td>{{  optional($user->desa)->name }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('desa.index', ['query' => $user->desa_id]) }}" class="btn btn-sm btn-success">LIHAT</a>
                                    </td>
                                </tr> 
                            </tbody>
                        </table> 
                    </div>  


                    <a href="{{ route('user.editpassword', $user->id) }}" class="btn btn-sm btn-danger">UBAH PASSWORD</a>

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
   
    @if(isset($user) && $user->desa_id && $user->desa)

    var desaOption = new Option("{{ $user->desa->long_name }}", "{{ $user->desa_id }}", true, true);

    $('#selectDesa').append(desaOption).trigger('change');

    @endif

});
</script>

