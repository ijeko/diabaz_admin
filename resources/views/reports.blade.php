@extends('layouts.app')

@section('content')
{{--    <div id="app">--}}
      <reports-wrapper-component
          :user="{{ \Illuminate\Support\Facades\Auth::User() }}"
      ></reports-wrapper-component>
{{--    </div>--}}

@endsection
