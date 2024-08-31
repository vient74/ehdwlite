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
                        <h4>Informasi Desa</h4>

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
                            
                            <label for="desa_id">Pilih Tahun</label>
                            <select name="tahun" id="tahun" class="form-control w-25">
                                <option value=""></option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>

                            <label for="validasi">Pilih Kategori</label>
                            <select name="validasi" id="validasi" class="form-control w-25">
                                <option value=""></option>
                                <option value="1">Belum Tervalidasi</option>
                                <option value="2">Tervalidasi</option>
                            </select>

                            <label for="desa_id">Pilih Triwulan</label>
                            <select name="tw" id="tw" class="form-control w-25">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>

                        </div> 

                        <button type="submit" class="btn btn-md btn-primary">Cari</button>
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

