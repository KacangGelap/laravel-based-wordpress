@extends('layouts.main')
@section('content')
    <div class="container my-4">
        <div class="my-2">
            <a href="{{route('form.informasi')}}" class="btn btn-outline-dark">&larr; Kembali ke menu awal</a>
        </div>
        <div class="row">
            <div class="card bg-success-subtle mx-2">
                <div class="card-body justify-content-between d-flex align-items-center">
                    <h5>Status Permohonan</h5>
                    <h5 class="text-success">Test Status</h5>
                </div>
            </div>
        </div>
        <hr>


        <div class="row">
            <div class="col-lg-6">
                        <h3>Identitas Pemohon</h3>
                        <div class="table-responsive border">
                            <table class="table table-striped table-hover align-middle mb-0" style="font-size: 12px">
                                <tbody>
                                    <tr>
                                        <th scope="row">Tanggal Permohonan</th>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_permohonan)->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Pemohon</th>
                                        <td>{{ $data->nama_pemohon }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kategori Permohonan</th>
                                        <td>{{ $data->kategori_permohonan }}</td>
                                    </tr>
                                   
                                    @auth
                                        <tr>
                                            <th scope="row">Jenis Identitas</th>
                                            <td>{{ $data->jenis_permohonan }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nomor Identitas</th>
                                            <td>{{ $data->nomor_identitas }}</td>
                                        </tr>
                                    @endauth
                                    <tr>
                                        <th scope="row">Alamat Pemohon</th>
                                        <td>{{ $data->alamat_pemohon }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pekerjaan Pemohon</th>
                                        <td>{{ $data->pekerjaan_pemohon }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                  
            </div>
            <div class="col-lg-6">
               
                <h3>Data Pemohon</h3>
                
                <div class="table-responsive border">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <tbody style="font-size: 12px">
                            <tr><th colspan="2">Rincian Permohonan</th></tr>
                            <tr><td colspan="2">{{ $data->rincian_kebutuhan }}</td></tr>
                            
                            <tr><th colspan="2">Tujuan Permohonan</th></tr>
                            <tr><td colspan="2">{{ $data->tujuan_informasi }}</td></tr>
                            <tr>
                                <th scope="row">Instansi yang dituju</th>
                                <td>{{ $data->opd->opd }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Cara Memperoleh Informasi</th>
                                <td>{{ $data->cara_memperoleh_informasi }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Cara Mendapatkan Informasi</th>
                                <td>{{ $data->cara_mendapatkan_informasi }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
    </div>
    
@endsection