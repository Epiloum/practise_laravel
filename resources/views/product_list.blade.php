@extends('layout')
@section('title', 'Product list')
@section('content')
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Register</th>
            <th>title</th>
            <th>Price</th>
            <th>Inventory</th>
            @if($orderCount)
                <th>Order Cnt.</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $v)
            <tr>
                <td>{{ $v->no }}</td>
                <td>{{ $v->user_register }}</td>
                <td>{{ $v->title }}</td>
                <td>{{ number_format($v->price) }}</td>
                <td>{{ number_format($v->inventory) }}</td>
                @if($orderCount)
                    <td>{{ number_format($v->order_count) }}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
