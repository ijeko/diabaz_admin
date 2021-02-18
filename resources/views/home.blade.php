@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6">
                    <materials-component
                        :materials="{{$materials}}"></materials-component>
            </div>
            <div class="col-md-6">
                <div id="app">
                    <production-component
                    :products="{{$products}}"
                    ></production-component>
                </div>
                <div id="app">
                    <motor-component></motor-component>
                </div>
            </div>
        </div>
    </div>
@endsection
