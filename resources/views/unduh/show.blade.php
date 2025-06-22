@extends('layouts.main')
@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-md-10">
            <div class="container">
                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        <h3>Unduh</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($filecat as $item)
                            <h4 class="text-decoration-bold">{{"$item->cat"}}</h4>
                            <div class="table-responsive text-center">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-start">Nama File</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->unduh as $file)
                                            <tr style="font-size: 12px">
                                                <td class="col-1">{{$loop->iteration}}</td>
                                                <td class="col-9" style="text-align: justify">{{str_replace(".pdf","",$file->nama)}}</td>
                                                <td class="col-2" style="font-size: 12px">
                                                    <div class="d-md-flex">
                                                        <a href="{{asset("storage/$file->media")}}" target="_blank" rel="noopener noreferrer" class="col btn btn-secondary"><i class="bi bi-eye"></i></a>
                                                        <a href="{{route('unduh-file', $file->id)}}" class="col btn btn-dark mx-2">
                                                            <i class="bi-download"></i>
                                                        </a>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection