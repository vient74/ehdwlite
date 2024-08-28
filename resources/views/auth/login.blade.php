@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 100px">
        <div class="col-md-5">
              @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                

                  
                <div class="card-body">
                   
                    <form action="{{ route('actionlogin') }}" method="post">
                        @csrf

                        <div class="row mb-2">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required  autocomplete="name" autofocus>
                                    
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                              
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                      

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                         
                    </form>
                     <p style="margin-top: 20px">version 1.0</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
