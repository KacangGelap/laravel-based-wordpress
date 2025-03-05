@extends('layouts.main')
@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Agenda</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Lokasi dan Alamat</th>
                                <th>Menghadiri</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr style="font-size: 12px">
                                    <td>{{$loop->iteration}}</td>
                                    <td style="text-align: justify;">{{$item->nama_kegiatan}}</td>
                                    <td>{{$item->penyelenggara}}</td>
                                    @php
                                        $tgl_mulai = Carbon\Carbon::parse($item->mulai)->translatedFormat('d M Y');
                                        $tgl_selesai = Carbon\Carbon::parse($item->selesai)->translatedFormat('d M Y');
                                    @endphp
                                    <td>{{$tgl_mulai === $tgl_selesai ? $tgl_mulai : "$tgl_mulai - $tgl_selesai"}}</td>
                                    <td>{{Carbon\Carbon::parse($item->mulai)->translatedFormat('H:i T')}}</td>
                                    <td>{{Carbon\Carbon::parse($item->selesai)->translatedFormat('H:i T')}}</td>
                                    <td style="text-align: justify;">{{"$item->lokasi, $item->alamat"}}</td>
                                    <td>{{$item->menghadiri}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
