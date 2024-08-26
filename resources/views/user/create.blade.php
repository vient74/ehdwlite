@extends('layouts.app')

@section('content')

 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Membuat ID Pengguna') }}</div>

                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row-fluid">
                        
                        <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        @if (Auth::user()->role->tag == 'sadmin')
                        
                            <div class="mb-3">
                                <label for="role_id">Level Pengguna</label>
                                <select name="role_id" class="form-select">
                                    <option value="" disabled selected>Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->kode }}">{{ $role->name}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                     

                        <div class="mb-3">
                            <label for="desa_id">Pilih Desa</label>
                            <select id="selectDesa" name="desa_id" class="form-select" aria-label="Default select"></select>
                            @error('desa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> 
                                 
                        @endif 
                         <div class="mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" oninput="this.value = this.value.toUpperCase();">

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
                                name="username" value="{{ old('username') }}">

                            <!-- error message untuk name -->
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                           
                        </div>

                        <div class="mb-3">
                            <label for="name">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>



                        <button type="submit" class="btn btn-md btn-primary">Save</button>
                        <a href="{{ route('user.index') }}" class="btn btn-md btn-secondary">back</a>

                    </form>
                        
                       

                   

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
            data: function (params) {
                return {
                    q: params.term // Term pencarian
                };
            },
            processResults: function (data) {
                console.log(data); // Debug: Periksa data yang diterima dari server
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    })
                };
            }
        }
    });
});

</script>

