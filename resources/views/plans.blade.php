@extends('layouts.app')

@section('content')
{{--    <div id="app">--}}
      <plan-wrapper-component
          :user="{{ \Illuminate\Support\Facades\Auth::User() }}"
      ></plan-wrapper-component>
{{--    </div>--}}

@endsection
