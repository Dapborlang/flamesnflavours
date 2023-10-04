@extends('layouts.main')

@section('content')
<div class="printable">
    <gst-component :order="{{ json_encode($order) }}"></gst-component>
</div>
@endsection
