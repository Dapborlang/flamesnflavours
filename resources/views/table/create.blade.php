@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <table-component></table-component>
        </div>
        <div class="col-sm-4">
             <category-component></category-component> 
        </div>
        <div class="col-sm-4">
            <menu-component></menu-component>
        </div>
    </div>
</div>
@endsection
