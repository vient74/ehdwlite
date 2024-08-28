@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                  
                   

                    <!-- {{ __('You are logged in!') }} -->
                       
                        @if(Auth::user()->role->tag == 'admin_prov') <!-- prov -->
                             
                            <h3>Master Data</h3>
                            <div class="row-fluid">
                                <ul>
                                    <li><a href="{{ url('/user') }}">User ID Pengguna </a></li>
                                    <li><a href="{{ url('/kpm') }}">User ID KPM </a></li>
                                    <li><a href="{{ url('/provinsi') }}">Master Provinsi</a></li>
                                    <li><a href="{{ url('/kabupaten') }}">Master Kabupaten</a></li>
                                    <li><a href="{{ url('/kecamatan') }}">Master Kecamatan</a></li>
                                    <li><a href="{{ url('/desa') }}">Master Desa</a></li>
                                </ul>    
                            </div>  
                        @elseif (Auth::user()->role->tag == 'admin_kabkota') <!-- kab -->
                            <div class="row-fluid">
                                <ul>
                                    <li><a href="{{ url('/user') }}">Daftar User ID Pengguna </a></li>
                                    <li><a href="{{ url('/kabupaten') }}">Master Kabupaten</a></li>
                                    <li><a href="{{ url('/kecamatan') }}">Master Kecamatan</a></li>
                                    <li><a href="{{ url('/desa') }}">Master Desa</a></li>
                                </ul>    
                            </div>  
                        @elseif (Auth::user()->role->tag == 'admin_kec') <!-- kec -->    
                            <div class="row-fluid">
                                <ul>
                                    <li><a href="{{ url('/user') }}">Daftar User ID Pengguna </a></li>
                                    <li><a href="{{ url('/kecamatan') }}">Master Kecamatan</a></li>
                                    <li><a href="{{ url('/desa') }}">Master Desa</a></li>
                                </ul>    
                            </div>  
                        @elseif (Auth::user()->role == 'admin_desa') <!-- desa -->    
                            <div class="row-fluid">
                                <ul>
                                    <li><a href="{{ url('/user') }}">Daftar User ID Pengguna </a></li>
                                    <li><a href="{{ url('/kpm') }}">Daftar User ID KPM </a></li>
                                    <li><a href="{{ url('/desa') }}">Master Desa</a></li>
                                    <li><a href="{{ url('/desa/rekap_data_desa') }}">Informasi Desa</a></li>
                                </ul>    
                            </div>   
                        @elseif (Auth::user()->role->tag == 'sadmin')
                        <h3>Pendataan</h3>    
                        <div class="row-fluid">
                        <ul>
                            <li><a href="{{ url('/masterkk') }}">Informasi Kepala Keluarga </a></li>
                            <li><a href="{{ url('/mastersasaran') }}">Informasi Sasaran </a></li>
                            <li><a href="{{ url('/desa/rekap_data_desa_form') }}">Informasi Desa</a></li>
                            <li><a href="{{ url('/chart') }}">Dashboard </a></li>
                             
                        </ul>    
                    </div>    

                     <h3>Penerima Manfaat</h3>
                     <div class="row-fluid">
                        <ul>
                            <li><a href="{{ url('/user') }}">Keluarga </a></li>
                            <li><a href="{{ url('/pmanak') }}">Anak Balita (0-59 Bulan)</a></li>
                            <li><a href="{{ url('/pmremaja_putri') }}">Remaja Putri</a></li>
                            <li><a href="{{ url('/pmcatin') }}">Calon Pengantin </a></li>
                            <li><a href="{{ url('/pmibu_hamil') }}">Ibu Hamil dan Nifas </a></li>
                        </ul>    
                    </div>    

                      <h3>Master Kode</h3>
                      <div class="row-fluid">
                        <ul>
                            <li><a href="{{ url('/user') }}">User ID Pengguna </a></li>
                            <li><a href="{{ url('/kpm') }}">User ID KPM </a></li>
                            <li><a href="{{ url('/provinsi') }}">Master Provinsi</a></li>
                            <li><a href="{{ url('/kabupaten') }}">Master Kabupaten</a></li>
                            <li><a href="{{ url('/kecamatan') }}">Master Kecamatan</a></li>
                            <li><a href="{{ url('/desa') }}">Master Desa</a></li>
                        </ul>    
                    </div>   

                    @endif

                     
                 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
