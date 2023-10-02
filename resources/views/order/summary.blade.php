<!-- resources/views/orders/summary.blade.php -->

@extends('layouts.main') <!-- Assuming you have a master layout, adjust as needed -->

@section('content')
    <order-summary :order="{{ json_encode($order) }}"></order-summary>
@endsection
