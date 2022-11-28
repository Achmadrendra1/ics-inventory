@extends('report.report')

@section('title','User')

@section('content')
<table class="table" class="display nowrap" style="width:100%" id="table">
    <thead>
        <tr>
            <th style="display:none;">ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Role</th>
            <th>No. Telp</th>
            <th>Gender</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $u)
            <tr>
                <td style="display:none;">{{ $u->user_id }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->name }}</td>
                <!-- <td>{{ $u->is_admin }}</td> -->
                @if ($u->is_admin == 1)
                    <td>Admin</td>
                @else
                    <td>User</td>
                @endif
                <td>{{ $u->telp }}</td>
                <td>{{ $u->gender }}</td>
                <td>{{ $u->created_at }}</td>
                <td>{{ $u->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop