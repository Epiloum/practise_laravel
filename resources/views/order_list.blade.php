@extends('layout')
@section('title', 'Order list')
@section('content')
    <table>
        <thead>
        <tr>
            <th>Buyer</th>
            <th>Buyer`s Email</th>
            <th>Buyer`s Grade</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Requirements</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $v)
            <tr>
                <td>{{ $v->user_buy }}</td>
                <td>{{ $v->email }}</td>
                <td>{{ $v->grade }}</td>
                <td>{{ $v->product_no }}</td>
                <td>{{ $v->qty }}</td>
                <td>{{ $v->amt }}</td>
                <td>{{ $v->requirements }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
