@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Informasi Website') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    <hr>
                    @endif
                    <div>
                        <table class="w-100">
                            <tbody>
                                <tr class="justify-content-between">
                                    <td class="col-md-6"><b>{{__('Nama Website')}}<b></td>
                                    <td class="col-md-6 text-end">{{config( 'app.name', 'Website pemerintah kota Bontang')}}</td>
                                </tr>
                                <tr class="justify-content-between">
                                    <td class="col-md-6"><b>{{__('Status')}}<b></td>
                                    <td class="col-md-6 text-end">{{config( 'app.env', 'Unknown')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <hr>
                    <div class="card bg-warning-subtle">
                        <div class="card-header">Log Aktivitas Pengguna Terakhir</div>
                        <div class="card-body">
                            {{Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y H:i T')}} - <b>{{$log->user->name ." $log->action"}}</b>
                        </div>
                        <div class="p-2 ms-auto">
                            @if(Auth::user()->role == 'admin')
                                <a href="{{route('logs')}}">Lihat semua aktivitas pengguna</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="card bg-info-subtle">
                        <div class="card-header">
                            Statistik Pengunjung Website
                        </div>
                        <div class="card-body">
                            Jumlah Pengunjung Hari Ini : {{ $today_visitors }} <br>
                            Jumlah Halaman yang Ditelusuri Hari Ini: {{ $today_page_views }} <br>
                            Jumlah Pengunjung: {{ $total_visitors }} <br>
                            Jumlah Halaman yang DItelusuri: {{ $total_page_views }} <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
