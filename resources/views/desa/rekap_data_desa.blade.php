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
                        
                        @php
                        if (!empty($desa)) {
                        @endphp
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
                                                <td>{{ $score ? ($score->meta_tw ?? 0) : 0 }}</td>
                                                <td>{{ $score ? ($score->meta_tahun ?? 0) : 0 }}</td>
                                              
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
                                                <td>{{ $score ? ($score->meta_updated_at ?? 0) : 0 }}</td>
                  
                                            </tr>
                                            <tr>
                                                <td>Konvergensi Tahun Lalu</td>
                                                <td class="text-end">{{ $score ? ($score->meta_angka_konvergensi_tahun_lalu ?? 0) : 0 }}</td>
                                            </tr>
                                             <tr>
                                                <td>Melakukan Rembug Stunting</td>
                                                <td class="text-end">
                                                    @php
                                                    if (!empty($score->meta_rembuk_menyelenggarakan)) { 
                                                    @endphp   
                                                        <span class="badge {{ $score->meta_rembuk_menyelenggarakan == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $score->status == 1 ? 'Ya' : 'Tidak' }}
                                                        </span>
                                                    @php
                                                    }
                                                    @endphp    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Desa Melibatkan Warga dan Multi Pihak Dalam Rembuk Stunting Desa ?</td>
                                                <td class="text-end">
                                                    
                                                    @php
                                                    if (!empty($score->meta_rembuk_multi_sector)) { 
                                                    @endphp    
                                                        <span class="badge {{ $score->meta_rembuk_multi_sector == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $score->status == 1 ? 'Ya' : 'Tidak' }}
                                                        </span>
                                                    @php
                                                    }
                                                    @endphp

                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Keterangan Desa Melibatkan Warga dan Multi Pihak Dalam Rembuk Stunting Desa</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->meta_rembuk_multi_sector_ket ?? 0) : 0 }}
                                                    
                                                </td>
                                            </tr>
                                           

                                         </tbody>

                                    </table>   


                                </div>
                                 <div class="col">

                                 </div>
                             </div>   
                             
                             <div class="row">
                                <div class="col">
                                    

                                      <table class="table table-bordered mt-1 table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col" class="text-end">Terjadwal</th>
                                                <th scope="col" class="text-end">Realisasi</th>
                                                <th scope="col" class="text-end"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="fw-bold fs-6"></b>A n a k</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Anak</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_ava ?? 0) : 0 }}
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Anak mendapatkan Imunisasi Campak</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_campak_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_campak ?? 0) : 1 }}
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $anak_i_campak = $score->anak_i_campak ?? 0;
                                                        $anak_i_campak_ava = $score->anak_i_campak_ava ?? 1;  // Avoid division by zero
                                                        $ipersen = round(($anak_i_campak / $anak_i_campak_ava) * 100);  
                                                    @endphp
                                                    {{ $ipersen . '%' }}
                                                </td>
                                            </tr>

                                           
                                             <tr>
                                                <td>Anak Giji Buruk</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_gizi_buru ?? 0) : 0 }}
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Anak Giji Kurang</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_gizi_kurang ?? 0) : 0 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Anak Stunting</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_gizi_stunting ?? 0) : 0 }}
                                                </td>
                                            </tr>
                                             <tr>
                                                <td colspan="4" class="fw-bold fs-6">Layanan PAUD</td>
                                            </tr>
                                            <tr>
                                                <td>Anak PAUD</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_ikut_paud_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end"> 
                                                     {{ $score ? ($score->anak_i_ikut_paud ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $anak_i_paud = $score->anak_i_ikut_paud ?? 0;
                                                        $anak_i_paud_ava = $score->anak_i_ikut_paud_ava ?? 1;  // Avoid division by zero
                                                        $ipaud = round(($anak_i_paud / $anak_i_paud_ava) * 100);  
                                                    @endphp
                                                    {{ $ipaud . '%' }}
 
                                                </td>
                                            </tr>

                                             <tr>
                                                <td colspan="4" class="fw-bold fs-6">Imunisasi</td>
                                            </tr>

                                            <tr>
                                                <td>Imunisasi 1 Terjadwal</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_1_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_1 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $imun1 = $score->anak_i_ikut_paud ?? 0;
                                                        $imun1_ava = $score->anak_i_ikut_paud_ava ?? 1;  // Avoid division by zero
                                                        $imun_1 = round(($imun1 / $imun1_ava) * 100);  
                                                    @endphp
                                                    {{ $imun_1 . '%' }}
 
            
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Imunisasi 2 Terjadwal</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_2_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_2 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $imun2     = $score->anak_i_imun_2 ?? 0;
                                                        $imun2_ava = $score->anak_i_imun_2_ava ?? 1;  // Avoid division by zero
                                                        $imun_2    = round(($imun2 / $imun2_ava) * 100);  
                                                    @endphp
                                                    {{ $imun_2 . '%' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Imunisasi 3 Terjadwal</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_3_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_3 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $imun3     = $score->anak_i_imun_3 ?? 0;
                                                        $imun3_ava = $score->anak_i_imun_3_ava ?? 1;  // Avoid division by zero
                                                        $imun_3    = round(($imun3 / $imun3_ava) * 100);  
                                                    @endphp
                                                    {{ $imun_3 . '%' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Imunisasi 4 Terjadwal</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_4_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_4 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $imun4     = $score->anak_i_imun_4 ?? 0;
                                                        $imun4_ava = $score->anak_i_imun_4_ava ?? 1;  // Avoid division by zero
                                                        $imun_4    = round(($imun4 / $imun4_ava) * 100);  
                                                    @endphp
                                                    {{ $imun_4 . '%' }}
 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Imunisasi 5 Terjadwal</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_5_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_imun_5 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $imun5     = $score->anak_i_imun_5 ?? 0;
                                                        $imun5_ava = $score->anak_i_imun_5_ava ?? 1;  // Avoid division by zero
                                                        $imun_5    = round(($imun5 / $imun5_ava) * 100);  
                                                    @endphp
                                                    {{ $imun_5 . '%' }}

                                      
                                                </td>
                                            </tr>

                                             <tr>
                                                <td colspan="4" class="fw-bold fs-6">Gizi dan Anak</td>
                                            </tr>

                                            <tr>
                                                <td>Anak Tambah Gizi</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_tambah_gizi_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_tambah_gizi ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $tambah_gizi     = $score->anak_i_tambah_gizi ?? 0;
                                                        $tambah_gizi_ava = $score->anak_i_tambah_gizi_ava ?? 1;  // Avoid division by zero
                                                        $tambah_gizi     = round(($tambah_gizi / $tambah_gizi_ava) * 100);  
                                                    @endphp
                                                    {{ $tambah_gizi . '%' }}
                   
              
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Anak Tumbuh Kembang</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_tumbuh_kembang_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_i_tumbuh_kembang ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $tumbuh_kembang     = $score->anak_i_tumbuh_kembang ?? 0;
                                                        $tumbuh_kembang_ava = $score->anak_i_tumbuh_kembang_ava ?? 1;  // Avoid division by zero
                                                        $tumbuh_kembang_1   = round(($tumbuh_kembang / $tumbuh_kembang_ava) * 100);  
                                                    @endphp
                                                    {{ $tumbuh_kembang_1 . '%' }}

                                  
                                                </td>
                                            </tr>

                                             

                                            <tr>
                                                <td>Anak Imunisasi Lengkap</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_imunisasi_lengkap ?? 0) : 0 }}
                                                 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Anak Indikasi Gizi</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_indikasi_gizi ?? 0) : 0 }}
                                              
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Anak Indikasi Gizi dan Mendapatkan Asupan</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->anak_indikasi_gizi_dan_mendapatkan_asupan ?? 0) : 0 }}
               
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Skor Anak</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">

                                                    {{ $score ? number_format(floor($score->anak_score * 100) / 100, 2) : '0.00' }}
 
 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Total Anak Penerima Manfaat</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
        
                                                    {{ $score ? number_format(floor($score->anak_total_pm * 100) / 100, 2) : '0.00' }}
 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Total Anak (?)</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                
                                                    {{ $score ? number_format(floor($score->anak_val * 100) / 100, 2) : '0.00' }}
 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" class="fw-bold fs-6">Ibu Hamil dan Nifas</td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil dan Nifas</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                  
                                                    {{ $score ? number_format(floor($score->bumil_ava * 100) / 100, 2) : '0.00' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil KB</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_kb_ava ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_kb ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">
                                                
                                                    @php
                                                        $bumil_kb     = $score->bumil_i_kb ?? 0;
                                                        $bumil_kb_ava = $score->bumil_i_kb_ava ?? 1;  // Avoid division by zero
                                                        $bumil_kb_1   = round(($bumil_kb / $bumil_kb_ava) * 100);  
                                                    @endphp
                                                    {{ $bumil_kb_1 . '%' }}


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil KEK</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_kek_ava ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_kek ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                

                                                    @php
                                                        $bumil_kek     = $score->bumil_i_kek ?? 0;
                                                        $bumil_kek_ava = $score->bumil_i_kek_ava ?? 1;  // Avoid division by zero
                                                        $bumil_kek_1   = round(($bumil_kek / $bumil_kek_ava) * 100);  
                                                    @endphp
                                                    {{ $bumil_kek_1 . '%' }}



                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Periksa Kehamilan 1</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa     = $score->bumil_i_periksa_1 ?? 0;
                                                        $bumil_periksa_ava = $score->bumil_i_periksa_1_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_1   = round(($bumil_periksa / $bumil_periksa_ava) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_1 . '%' }}
                                               
                                                </td>
                                            </tr> 


                                              <tr>
                                                <td>Periksa Kehamilan 1 2</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1_2_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1_2 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_1_2     = $score->bumil_i_periksa_1_2 ?? 0;
                                                        $bumil_periksa_ava_1_2 = $score->bumil_i_periksa_1_2_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_1_2     = round(($bumil_periksa_1_2 / $bumil_periksa_ava_1_2) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_1_2 . '%' }}
                                               
                                                </td>
                                            </tr> 
                                                      
                                             <tr>
                                                <td>Periksa Kehamilan 1 3</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1_3_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_1_3 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_1_3     = $score->bumil_i_periksa_1_3 ?? 0;
                                                        $bumil_periksa_ava_1_3 = $score->bumil_i_periksa_1_3_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_1_3     = round(($bumil_periksa_1_3 / $bumil_periksa_ava_1_3) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_1_3 . '%' }}
                                               
                                                </td>
                                            </tr> 
                                            
                                             <tr>
                                                <td>Periksa Kehamilan 2</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_2     = $score->bumil_i_periksa_2 ?? 0;
                                                        $bumil_periksa_ava_2 = $score->bumil_i_periksa_2_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_2    = round(($bumil_periksa_2 / $bumil_periksa_ava_2) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_2 . '%' }}
                                               
                                                </td>
                                            </tr> 
                                           

                                             <tr>
                                                <td>Periksa Kehamilan 2 2</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2_2_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2_2 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_2_2     = $score->bumil_i_periksa_2_2 ?? 0;
                                                        $bumil_periksa_ava_2_2 = $score->bumil_i_periksa_2_2_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_2_2     = round(($bumil_periksa_2_2 / $bumil_periksa_ava_2_2) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_2_2 . '%' }}
                                               
                                                </td>
                                            </tr> 
            
                                              <tr>
                                                <td>Periksa Kehamilan 2 3</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2_3_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_2_3 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_2_3     = $score->bumil_i_periksa_2_3 ?? 0;
                                                        $bumil_periksa_ava_2_3 = $score->bumil_i_periksa_2_3_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_2_3     = round(($bumil_periksa_2_3 / $bumil_periksa_ava_2_3) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_2_3 . '%' }}
                                               
                                                </td>
                                            </tr> 


                                              <tr>
                                                <td>Periksa Kehamilan 3</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_3     = $score->bumil_i_periksa_3 ?? 0;
                                                        $bumil_periksa_ava_3 = $score->bumil_i_periksa_3_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_3     = round(($bumil_periksa_3 / $bumil_periksa_ava_3) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_3 . '%' }}
                                               
                                                </td>
                                            </tr> 


                
                                             <tr>
                                                <td>Periksa Kehamilan 3 2</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3_2_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3_2 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_3_2     = $score->bumil_i_periksa_3_2 ?? 0;
                                                        $bumil_periksa_ava_3_2 = $score->bumil_i_periksa_3_2_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_3_2     = round(($bumil_periksa_3_2 / $bumil_periksa_ava_3_2) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_3_2 . '%' }}
                                               
                                                </td>
                                            </tr> 


                                             <tr>
                                                <td>Periksa Kehamilan 3 3</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3_3_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_periksa_3_3 ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        $bumil_periksa_3_3     = $score->bumil_i_periksa_3_3 ?? 0;
                                                        $bumil_periksa_ava_3_3 = $score->bumil_i_periksa_3_3_ava ?? 1;  // Avoid division by zero
                                                        $bumil_periksa_3_3     = round(($bumil_periksa_3_3 / $bumil_periksa_ava_3_3) * 100);  
                                                    @endphp
                                                    {{ $bumil_periksa_3_3 . '%' }}
                                               
                                                </td>
                                            </tr> 

  

                                            <tr>
                                                <td>Ibu Hamil Resiko Tinggi</td>
                                                <td class="text-end">
    
                                                    {{ $score ? ($score->bumil_i_resti_ava ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_resti ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">

                                                    @php
                                                        if ($score && $score->bumil_i_resti_ava != 0) {
                                                            $bumil_resti = round(($score->bumil_i_resti / $score->bumil_i_resti_ava) * 100);
                                                        } else {
                                                            $bumil_resti = 0; 
                                                        }
                                                    @endphp

                                                    {{ $bumil_resti . '%' }}
 

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil Tambah Gizi</td>
                                                <td class="text-end">
                                                     {{ $score ? ($score->bumil_i_tambah_gizi_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_tambah_gizi ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                            
                                                    @php
                                                    if ($score && $score->bumil_i_tambah_gizi_ava != 0) {
                                                        $bumil_tambah_gizi = round(($score->bumil_i_tambah_gizi/$score->bumil_i_tambah_gizi_ava) * 100);
                                                    } else {
                                                        $bumil_tambah_gizi = 0; 
                                                    }
                                                    @endphp

                                                    {{ $bumil_tambah_gizi . '%' }}



                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil TTD</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_ttd_ava ?? 0) : 0 }}
                                                    
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_i_ttd ?? 0) : 0 }}
            
                                                </td>
                                                <td class="text-end">
                                             
                                                    @php
                                                    if ($score && $score->bumil_i_ttd_ava != 0) {
                                                        $bumil_ttd = round(($score->bumil_i_ttd/$score->bumil_i_ttd_ava) * 100);
                                                    } else {
                                                        $bumil_ttd = 0; 
                                                    }
                                                    @endphp

                                                    {{ $bumil_ttd . '%' }}


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil Indikasi Gizi</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                    
                                                    {{ $score ? ($score->bumil_indikasi_gizi ?? 0) : 0 }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil Periksa Kehamilan Lengkap</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->bumil_periksa_hamil_lengkap * 100) / 100, 2) : '0.00' }}
                                                    
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Skor Ibu Hamil</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->bumil_score * 100) / 100, 2) : '0.00' }}
                                                    
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ibu Hamil Penerima Manfaat  </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->bumil_total_pm ?? 0) : 0 }}

                                                </td>
                                            </tr>

                                            

                                            <tr>
                                                <td>Ibu Hamil Val  </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                 
                                               
                                                    {{ $score ? number_format(floor($score->bumil_val * 100) / 100, 2) : '0.00' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" class="fw-bold fs-6">Calon Pengantin</td>
                                            </tr>
                                            <tr>
                                                <td>Calon Pengantin Ava  </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end">
                                                  
                                                    {{ $score ? ($score->catin_ava ?? 0) : 0 }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Calon Pengantin Menerima Bimbingan  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->catin_i_bimbile_ava ?? 0) : 0 }}

                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->catin_i_bimbile ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                    if ($score && $score->catin_i_bimbile_ava != 0) {
                                                        $catin_bimble = round(($score->catin_i_bimbile / $score->catin_i_bimbile_ava) * 100);
                                                    } else {
                                                        $catin_bimble = 0; 
                                                    }
                                                    @endphp
                                                    {{ $catin_bimble . '%' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Calon Pengantin Menerima Vaksin  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->catin_i_vaksin_ava ?? 0) : 0 }}
                              
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->catin_i_vaksin ?? 0) : 0 }}
                       
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                    if ($score && $score->catin_i_vaksin_ava != 0) {
                                                        $catin_vaksin = round(($score->catin_i_vaksin/$score->catin_i_vaksin_ava) * 100);
                                                    } else {
                                                        $catin_vaksin = 0; 
                                                    }
                                                    @endphp
                                                    {{ $catin_vaksin  . '%' }}

 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Skor Calon Pengantin</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->catin_score * 100) / 100, 2) : '0.00' }}
                                                 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Calon Pengantin Total Penerima Manfaat  </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->catin_total_pm * 100) / 100, 2) : '0.00' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Calon Pengantin Val  </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->catin_val * 100) / 100, 2) : '0.00' }}

                                                </td>
                                            </tr>

                                             <tr>
                                                <td colspan="4" class="fw-bold fs-6">Keluarga</td>
                                            </tr>

                                            <tr>
                                                <td>Keluarga  </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->keluarga_ava * 100) / 100, 2) : '0.00' }}
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Keluarga  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_air_ava ?? 0) : 0 }}
                                                    
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_air ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                      
                                                    @php
                                                    if ($score && $score->keluarga_i_air_ava != 0) {
                                                        $keluarga_i_air = round(($score->keluarga_i_air/$score->keluarga_i_air_ava) * 100);
                                                    } else {
                                                        $keluarga_i_air = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_air . '%' }}

                                                 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Memiliki Jamban  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_jamban_ava ?? 0) : 0 }}
                                                    
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_jamban ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                 

                                                    @php
                                                    if ($score && $score->keluarga_i_jamban_ava != 0) {
                                                        $keluarga_i_jamban = round(($score->keluarga_i_jamban/$score->keluarga_i_jamban_ava) * 100);
                                                    } else {
                                                        $keluarga_i_jamban = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_jamban . '%' }}
                                                 
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Memiliki Jaminan Kesehatan  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_jamkes_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_jamkes ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                          
                                                    @php
                                                    if ($score && $score->keluarga_i_jamkes_ava != 0) {
                                                        $keluarga_i_jameks = round(($score->keluarga_i_jamkes/$score->keluarga_i_jamkes_ava) * 100);
                                                    } else {
                                                        $keluarga_i_jameks = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_jameks . '%' }}


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Memiliki Kartu Keluarga  </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_kk_ava ?? 0) : 0 }}
                                                    
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_kk ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                              
                                                    @php
                                                    if ($score && $score->keluarga_i_kk_ava != 0) {
                                                        $keluarga_i_kk = round(($score->keluarga_i_kk/$score->keluarga_i_kk_ava) * 100);
                                                    } else {
                                                        $keluarga_i_kk = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_kk . '%' }}
                                                 
                                                </td>
                                            </tr>

                                              <tr>
                                                <td>Memiliki Pembuangan Limbah  </td>
                                                <td class="text-end">
                                                    
                                                    {{ $score ? ($score->keluarga_i_limbah_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                  
                                                    {{ $score ? ($score->keluarga_i_limbah ?? 0) : 0 }} 
                                                </td>
                                                <td class="text-end">
                                 
                                                    @php
                                                    if ($score && $score->keluarga_i_limbah_ava != 0) {
                                                        $keluarga_i_limbah = round(($score->keluarga_i_limbah/$score->keluarga_i_limbah_ava) * 100);
                                                    } else {
                                                        $keluarga_i_limbah = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_limbah . '%' }}
                                                 
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Keluarga Rentan </td>
                                                <td class="text-end">
                                                  
                                                    {{ $score ? ($score->keluarga_i_rentan_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                
                                                    {{ $score ? ($score->keluarga_i_rentan ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                 
                                                    @php
                                                    if ($score && $score->keluarga_i_rentan_ava != 0) {
                                                        $keluarga_i_rentan = round(($score->keluarga_i_rentan/$score->keluarga_i_rentan_ava) * 100);
                                                    } else {
                                                        $keluarga_i_rentan = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_rentan . '%' }}

                                                </td>
                                            </tr>

                                            

                                            <tr>
                                                <td>Keluarga Penerima Bansos </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_rentan_peserta_bansos_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_rentan_peserta_bansos ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                    
                                                    @php
                                                    if ($score && $score->keluarga_i_rentan_peserta_bansos_ava != 0) {
                                                        $keluarga_i_bansos = round(($score->keluarga_i_rentan_peserta_bansos/$score->keluarga_i_rentan_peserta_bansos_ava) * 100);
                                                    } else {
                                                        $keluarga_i_bansos = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_bansos . '%' }}


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ketahanan Pangan </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_tahan_pangan_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_tahan_pangan ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">

                                                    @php
                                                    if ($score && $score->keluarga_i_tahan_pangan_ava != 0) {
                                                        $keluarga_i_pangan = round(($score->keluarga_i_tahan_pangan/$score->keluarga_i_tahan_pangan_ava) * 100);
                                                    } else {
                                                        $keluarga_i_pangan = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_pangan  .'%'  }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Keluarga TPK </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_tpk_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_i_tpk ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                          
                                                    @php
                                                    if ($score && $score->keluarga_i_tpk_ava != 0) {
                                                        $keluarga_i_tpk = round(($score->keluarga_i_tpk/$score->keluarga_i_tpk_ava) * 100);
                                                    } else {
                                                        $keluarga_i_tpk = 0; 
                                                    }
                                                    @endphp

                                                    {{ $keluarga_i_tpk . '%' }}

                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Keluarga Rentan dan Beresiko</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    
                                                    {{ $score ? ($score->keluarga_rentan_dan_beresiko ?? 0) : 0 }}
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Skor Keluarga</td>
                                                <td class="text-end"></td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->keluarga_score * 100) / 100, 2) : '0.00' }}
                                                    
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Total Keluarga Penerima Manfaat </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->keluarga_total_pm ?? 0) : 0 }}
                                                   
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Keluarga Val </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                   
                                                    {{ $score ? ($score->keluarga_val ?? 0) : 0 }}
                                                </td>
                                            </tr>

                                             <tr>
                                                <td colspan="4" class="fw-bold fs-6">Remaja Putri</td>
                                            </tr>
                                            <tr>
                                                <td>Remaja Putri </td>
                                                <td class="text-end"></td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                   
                                                    {{ $score ? ($score->rematri_ava ?? 0) : 0 }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Remaja Putri Anemia</td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_i_periksa_anemia_ava ?? 0) : 0 }}
                                                   
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_i_periksa_anemia ?? 0) : 0 }}
                                                  
                                                </td>
                                                <td class="text-end">
                                  
                                                    @php
                                                    if ($score && $score->rematri_i_periksa_anemia_ava != 0) {
                                                        $rematri_i_periksa_anemia = round(($score->rematri_i_periksa_anemia/$score->rematri_i_periksa_anemia_ava) * 100);
                                                    } else {
                                                        $rematri_i_periksa_anemia = 0; 
                                                    }
                                                    @endphp

                                                    {{ $rematri_i_periksa_anemia . '%' }}

                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Remaja Putri Penerima TTD </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_i_ttd_ava ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_i_ttd ?? 0) : 0 }}
                                                </td>
                                                <td class="text-end">
                                
                                                    @php
                                                    if ($score && $score->rematri_i_ttd_ava != 0) {
                                                        $rematri_ttd = round(($score->rematri_i_ttd/$score->rematri_i_ttd_ava) * 100);
                                                    } else {
                                                        $rematri_ttd = 0; 
                                                    }
                                                    @endphp

                                                    {{ $rematri_ttd . '%' }}

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Skor Remaja Putri</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? number_format(floor($score->rematri_score * 100) / 100, 2) : '0.00' }}
                                                    
                                                </td>
                                            </tr>
                                            
                                             <tr>
                                                <td>Remaja Putri Penerima Manfaat</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_total_pm ?? 0) : 0 }}
                                                    
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Remaja Putri Val</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    {{ $score ? ($score->rematri_val ?? 0) : 0 }}
                                                     
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Skor Total</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
             
                                                    {{ $score ? number_format(floor($score->total * 100) / 100, 2) : '0.00' }}
                               
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>Skor Total AVA</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                   

                                                    {{ $score ? ($score->total_score_ava ?? 0) : 0 }}
                               
                                                </td>
                                            </tr>

                                               

                                             <tr>
                                                <td>Keluarga Rentan Val</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    
                                                    {{ $score ? number_format(floor($score->keluarga_i_retan_val * 100) / 100, 2) : '0.00' }}
                               
                                                </td>
                                            </tr>

                                             

                                             <tr>
                                                <td>APBDES Nilai Realisasi</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    
                                                    {{ $score ? number_format(floor($score->meta_apbdes_realisasi_nilai * 100) / 100, 2) : '0.00' }}
                               
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Keterangan APBDES Nilai Realisasi</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                    
                                                    {{ $score ? ($score->meta_apbdes_realisasi_nilai_ket ?? 0) : 0 }}
                                                    
                               
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>NIK PIC</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                     

                                                     {{ $score ? ($score->pic_nik ?? 0) : '' }}
                               
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Nama PIC</td>
                                                <td class="text-end"> </td>
                                                <td class="text-end"> </td>
                                                <td class="text-end">
                                                 
                                                     {{ $score ? ($score->pic_name ?? 0) : '' }}
                               
                                                </td>
                                            </tr>
                                              
                                              
                                              
   
 


                                        </tbody>
                                      </table>        



                                </div>
                                 <div class="col"></div>
                             </div>   


                        </div>
                        @php

                        }
                        @endphp
                      

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

