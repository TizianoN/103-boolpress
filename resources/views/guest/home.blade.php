@extends('layouts.guest')

@section('content')
  <section class="container mt-5">
    <h1>{{ $title }}</h1>

    <div class="row rows-col-5 g-3">

      @forelse($posts as $post)
        <div class="col">
          @include('partials.post.card')
        </div>
      @empty
        <div class="col-12">
          <h2>Non ci sono Featured Posts</h2>
        </div>
      @endforelse
    </div>

    <a href="{{ route('guest.posts.all') }}">Vedi tutti</a>

    {{-- {{ $posts->links('pagination::bootstrap-5') }} --}}

  </section>
  <section class="container mt-5">
    <h1>Altra sezione...</h1>



  </section>
@endsection
