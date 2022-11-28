@extends('report.report')

@section('title','Lost Pet')

@section('content')

<!-- Table -->
<table class="table" id="table">
    <thead>
        <tr>

            <th>Pet Name</th>
            <th>Owner Name</th>
            <th>Open Adopt On</th>
            <th>New Owner</th>
            <th>Adopted On</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lost_pet as $pet)
            <tr>

                <td>{{ $pet->pet->petname }}</td>
                <td>{{ $pet->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($pet->created_at)->diffForHumans() }}</td>
                <td>{{ $pet->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($pet->updated_at)->diffForHumans() }}</td>
                <td>{{ $pet->pet->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@stop