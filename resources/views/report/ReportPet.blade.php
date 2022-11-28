@extends('report.report')

@section('title','Pet')

@section('content')
<table class="table" class="display nowrap" style="width:100%" id="table">
    <thead>
        <tr>
            <th style="display:none;">ID</th>
            <th>Pet Name</th>
            <th>Owner Name</th>
            <th>Pet Category</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pet as $u)
            <tr>
                <td style="display:none;">{{ $u->pet_id }}</td>
                <td>{{ $u->petname }}</td>
                <td>{{ $u->user->name }}</td>
                <td>{{ $u->animal }}</td>
                <td>{{ $u->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop