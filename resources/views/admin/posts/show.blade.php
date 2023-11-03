@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content-header')
  <h1 class="my-3">{{ $post->title }}</h1>

  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
    <i class="fa-solid fa-arrow-left me-1"></i>
    Torna alla lista
  </a>

  <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-secondary">
    <i class="fa-solid fa-pencil me-1"></i>
    Modifica
  </a>
@endsection


@section('content')
  <div class="row g-5 mt-3">

    <div class="col-4">
      <img src="{{ asset('/storage/' . $post->cover_image) }}" class="img-fluid" alt="">
    </div>
    <div class="col-8">
      <div class="row">
        <div class="col-6">
          <p>
            <strong>Categoria</strong><br>
            {!! $post->getCategoryBadge() !!}
          </p>
        </div>
        <div class="col-6">
          <p>
            <strong>Tags</strong><br>
            {!! $post->getTagBadges() !!}
          </p>
        </div>
        <div class="col-6">
          <p>
            <strong>Slug</strong><br>
            {{ $post->slug }}
          </p>
        </div>
        <div class="col-6">
          <p>
            <strong>Created at</strong><br>
            {{ $post->created_at }}
          </p>
        </div>
        <div class="col-6">
          <p>
            <strong>Updated at</strong><br>
            {{ $post->updated_at }}
          </p>
        </div>
      </div>
    </div>

    <div class="col-12">
      <p>
        <strong>Content</strong><br>
        {{ $post->content }}
      </p>
    </div>
  </div>
@endsection
