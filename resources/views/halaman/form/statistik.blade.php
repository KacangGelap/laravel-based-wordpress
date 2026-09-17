{{-- statistik form --}}
@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Statistik Formulir</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Jenis Formulir</th>
                                    <th scope="col">Jumlah Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statistik as $item)
                                    <tr>
                                        <td>{{ $item->jenis_formulir }}</td>
                                        <td>{{ $item->jumlah_pengajuan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
