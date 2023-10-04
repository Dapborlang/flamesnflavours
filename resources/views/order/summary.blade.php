@extends('layouts.main')

@section('content')
    <order-summary :order="{{ json_encode($order) }}"></order-summary>
@endsection
