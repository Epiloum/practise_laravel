@extends('layout')
@section('title', 'Order list')
@section('content')
    <table>
        <thead>
        <tr>
            <th>Buyer</th>
            <th>Buyer`s Email</th>
            <th>Buyer`s Grade</th>
            @if($relation)
                <th>Fee</th>
            @endif
            <th>Amount</th>
            <th>Requirements</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $v)
            <tr>
                <td>{{ $v->user_buy }}</td>
                @if($relation)
                    <td>{{ $v->buyer->email }}</td>
                    <td>{{ $v->buyer->grade }}</td>
                    <td>{{ number_format($v->fee->amt) }}</td>
                @else
                    <td>{{ $v->email }}</td>
                    <td>{{ $v->grade }}</td>
                @endif
                <td>{{ $v->product_no }}</td>
                <td>{{ $v->qty }}</td>
                <td>{{ number_format($v->amt) }}</td>
                <td>{{ $v->requirements }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection