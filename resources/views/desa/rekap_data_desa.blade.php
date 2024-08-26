@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<div class="container justify-content-center">
    <div class="row-fluid justify-content-center" style="margin-bottom: 20px; margin-left:40px">
        <a href="{{ url('/provinsi') }}">Master Provinsi</a> &nbsp;
        <a href="{{ url('/kabupaten') }}">Master Kabupaten</a> &nbsp;
        <a href="{{ url('/kecamatan') }}">Master Kecamatan</a> 
    </div> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Master Data') }}</div>

                <div class="card-body">

       

                    <div class="row-fluid">
                        <h2>Informasi Data Desa</h2>

                        <form action="{{ route('desa.rekap_data_desa') }}" method="POST">
                        @csrf
                        @method('POST')

                      
                        <div class="mb-3">
                            <select id="selectDesa" name="desa_id" class="form-select" aria-label="Default select"></select>
                            @error('desa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> 

                        <button type="submit" class="btn btn-md btn-primary">Cari</button>
                        <a href="{{ route('user.index') }}" class="btn btn-md btn-secondary">back</a>

                        </form>    
                        
                        <div class="container">
                            <div class="row">
                                <div class="col">

                                    <table class="table table-bordered mt-1 table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Desa</th>
                                                <th scope="col">Info Lengkap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <td>{{ $desa->id }}</td>
                                                <td>{{ $desa->name }}</td>
                                                <td>{{ $desa->long_name }}</td>
                                            </tr>
                                         </tbody>
                                    </table>    


                                </div>
                                <div class="col">
                                      <table class="table table-bordered mt-1 table-hover table-striped w-50">
                                        <thead>
                                            <tr>
                                                <th scope="col">Triwulan</th>
                                                <th scope="col">Tahun</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <td>{{ $score->meta_tw }}</td>
                                                <td>{{ $score->meta_tahun }}</td>
                                            </tr>
                                         </tbody>
                                    </table>   
                                </div>
                            </div>


                             <div class="row">
                                <div class="col">

                                     <table class="table table-bordered mt-1 table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Waktu Pembaharuan Data</td>
                                                <td class="text-end">{{ $score->meta_updated_at }}</td>
                                            </tr>
                                            <tr>
                                                <td>Konvergensi Tahun Lalu</td>
                                                <td class="text-end">{{ $score->meta_angka_konvergensi_tahun_lalu }}</td>
                                            </tr>
                                             <tr>
                                                <td>Melakukan Rembug Stunting</td>
                                                <td class="text-end">
                                                    <span class="badge {{ $score->meta_rembuk_menyelenggarakan == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $score->status == 1 ? 'Ya' : 'Tidak' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Desa Melibatkan Warga dan Multi Pihak Dalam Rembuk Stunting Desa ?</td>
                                                <td class="text-end">
                                                    <span class="badge {{ $score->meta_rembuk_multi_sector == 1 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $score->status == 1 ? 'Ya' : 'Tidak' }}
                                                    </span>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Keterangan Desa Melibatkan Warga dan Multi Pihak Dalam Rembuk Stunting Desa</td>
                                                <td class="text-end">{{ $score->meta_rembuk_multi_sector_ket }}</td>
                                            </tr>
                                             <tr>
                                                <td>Keterangan Desa Melibatkan Warga dan Multi Pihak Dalam Rembuk Stunting Desa</td>
                                                <td class="text-end">{{ $score->meta_rembuk_multi_sector_ket }}</td>
                                            </tr>

                                         </tbody>

                                    </table>   


                                </div>
                                 <div class="col">

                                 </div>
                             </div>   
                             
                             <div class="row">
                                <div class="col">
                                    <h3>Layanan</h3>
                                </div>
                                 <div class="col"></div>
                             </div>   


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

