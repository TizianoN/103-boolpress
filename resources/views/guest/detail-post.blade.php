@extends('layouts.guest')

@section('content')
  <section class="container mt-5">
    <div class="row g-3">
      <div class="col-12">
        <div class="card h-100">
          <div class="card-header">{{ $post->title }}</div>
          <div class="card-body">
            {{ $post->content }}

          </div>
          <div class="card-footer">
            <a class="btn btn-primary" href="{{ route('guest.posts.detail', $post->slug) }}"> vedi</a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
