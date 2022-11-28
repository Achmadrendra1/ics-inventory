@extends('report.report')

@section('title','Article')

@section('content')
<table class="table" class="display nowrap" style="width:100%" id="table">
            <thead>
                <tr>
                    <th width="10px">ID</th>
                    <th width="100px">Title</th>
                    <th width="100px">Slug</th>
                    <th class="text-center">Content</th>
                    <th width="100px">Photo</th>
                    <th width="100px">Author</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tips as $u)
                    <tr>
                        <th scope="row">{{ $u->article_id }}</th>
                        <td style="word-break:break-all;">{{ $u->title }}</td>
                        <td style="word-break:break-all;">{{ $u->slug }}</td>
                        <td style="word-break:break-all;" class="text-center">{!! $u->content !!}</td>
                        @if ($u->photo == !null)
                            <td style="word-break:break-all;">{{ $u->photo }}</td>
                        @else
                            <td style="word-break:break-all;">null</td>
                        @endif
                        <td style="word-break:break-all;">{{ $u->User->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@stop