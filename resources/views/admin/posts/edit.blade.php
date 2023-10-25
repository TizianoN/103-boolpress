@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content-header')
  <h1 class="my-3">Modifica Post</h1>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
    <i class="fa-solid fa-arrow-left me-1"></i>
    Torna alla lista
  </a>

  <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-secondary">
    <i class="fa-solid fa-arrow-up-right-from-square"></i>
    Vedi i dettagli
  </a>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      Correggi i seguenti errori

      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.posts.update', $post) }}" class="row">
    @method('PATCH')
    @csrf

    <div class="col-12 mb-4">
      <label for="title" class="form-label">Titolo</label>
      <input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $post->title }}">
    </div>

    <div class="col-12 mb-4">
      <label for="category_id" class="form-label">Categoria</label>
      <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
        <option value="">Non categorizzato</option>
        <option value="100" @if (old('category_id') == '100') selected @endif>Non valido</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" @if (old('category_id') ?? $post->category_id == $category->id) selected @endif>{{ $category->label }}
          </option>
        @endforeach
      </select>
      @error('category_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="col-12 mb-4">
      <label for="content" class="form-label">Contenuto</label>
      <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') ?? $post->content }}</textarea>
    </div>

    <div class="col-12 mb-4">
      <button class="btn btn-success">
        <i class="fa-solid fa-floppy-disk me-1"></i>
        Salva
      </button>
    </div>

  </form>
@endsection
