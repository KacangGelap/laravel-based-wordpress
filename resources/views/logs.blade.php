@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Aktivitas Website</h3>
                        <div>
                            <a href="{{ route('home') }}" class="btn btn-dark">&larr; Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Log</th>
                                        <th>Nama Pengguna</th>
                                        <th>Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $item)
                                        <tr>
                                            <td style="font-size: 12px">{{$loop->iteration}}</td>
                                            <td>{{Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i T')}}</td>
                                            <td class="text-sm-start" style="font-size: 12px">{{ $item->user->name }}</td>
                                            <td style="font-size: 12px">{{ $item->action }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
