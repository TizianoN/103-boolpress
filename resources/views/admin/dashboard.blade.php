@extends('layouts.app')

@section('content-header')
  <h1 class="my-3">{{ __('Dashboard') }}</h1>
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col">
      <div class="card">
        <div class="card-header">{{ __('User Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          {{ __('You are logged in!') }}
        </div>
      </div>
    </div>
  </div>
@endsection
