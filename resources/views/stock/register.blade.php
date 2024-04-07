@extends('layouts.app')

@section('content')
    <h2>Stock Register</h2>
    @foreach($stocks as $month => $monthStocks)
        <h3>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Transaction</th>
                    <th>Quantity</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @php $balance = 0; @endphp
                @foreach($monthStocks as $stock)
                    <tr>
                        <td>{{ $stock->date }}</td>
                        <td>{{ ucfirst($stock->transaction) }}</td>
                        <td>{{ $stock->quantity }}</td>
                        @php
                            if ($stock->transaction === 'credit') {
                                $balance += $stock->quantity;
                            } else {
                                $balance -= $stock->quantity;
                            }
                        @endphp
                        <td>{{ $balance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
