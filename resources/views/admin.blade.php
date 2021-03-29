@extends('layouts.app')

@section('content')
    <div id="app">
      <admin-wrapper-component
      :user="{{ \Illuminate\Support\Facades\Auth::User() }}"
      ></admin-wrapper-component>
    </div>

@endsection
