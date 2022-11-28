@extends('report.report')

@section('title','Clinic')

@section('content')
<table class="table" class="display nowrap" style="width:100%" id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Clinic Name</th>
                <th>Telp</th>
                <th>Address</th>
                <th>Long</th>
                <th>Lat</th>
                <th>Info</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clinic as $u)
                <tr>
                    <td style="word-break:break-all;">{{ $u->clinic_id }}</td>
                    <td style="word-break:break-all;">{{ $u->name }}</td>
                    <td style="word-break:break-all;">{{ $u->telp }}</td>
                    <td style="word-break:break-all;">{{ $u->address }}</td>
                    <td style="word-break:break-all;">{{ $u->longitude }}</td>
                    <td style="word-break:break-all;">{{ $u->latitude }}</td>
                    <td style="word-break:break-all;">{!! $u->info !!}</td>
                    <td style="word-break:break-all;">{{ $u->photo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop