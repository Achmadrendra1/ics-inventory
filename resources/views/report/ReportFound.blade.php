@extends('report.report')

@section('title','Found Pet')

@section('content')
<table class="table" class="display nowrap" style="width:100%" id="table">
<thead>
        <tr>
            <th>Pet Id</th>
            <th>Status</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($found_pet as $pet)
            <tr>
                <td>{{ $pet->pet_id}}</td>
                <td>{{ $pet->status }}</td>
                <td>{{ $pet->description }}</td>
                <td>{{ ($pet->created_at)->format('d-m-Y') }}</td>
                <td>{{ ($pet->updated_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
    </table>
@stop