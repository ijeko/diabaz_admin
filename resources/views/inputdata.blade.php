@extends('layouts.app')

@section('content')
    <div id="app">
      <home-wrapper-component
      :user="{{ \Illuminate\Support\Facades\Auth::User() }}"
      ></home-wrapper-component>
    </div>

@endsection
