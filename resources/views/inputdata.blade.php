@extends('layouts.app')

@section('content')
    <div id="app">
      <home-wrapper-component
      :user="{{ \Illuminate\Support\Facades\Auth::id() }}"
      ></home-wrapper-component>
    </div>

@endsection
