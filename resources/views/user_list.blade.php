@extends('layout')
@section('title', 'User list')
@section('content')
    <table>
        <thead>
        <tr>
            <th>no</th>
            <th>Name</th>
            <th>Email</th>
            <th>Grade</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $v)
            <tr>
                <td>{{ $v->no }}</td>
                <td>{{ $v->name }}</td>
                <td>{{ $v->email }}</td>
                <td>{{ $v->grade }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
