@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content-header')
  <h1 class="my-3">Crea Post</h1>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
    <i class="fa-solid fa-arrow-left me-1"></i>
    Torna alla lista
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

  <form method="POST" action="{{ route('admin.posts.store') }}" class="row" enctype="multipart/form-data">
    @csrf

    <div class="col-12 mb-4">
      <label for="title" class="form-label">Titolo</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title') }}">
      @error('title')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="col-12 mb-4">
      <div class="row">
        <div class="col-8">
          <label for="cover_image" class="form-label">Cover Image</label>
          <input type="file" name="cover_image" id="cover_image"
            class="form-control @error('cover_image') is-invalid @enderror" value="{{ old('cover_image') }}">
          @error('cover_image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="col-4">
          <img src="" class="img-fluid" id="cover_image_preview">
        </div>
      </div>
    </div>

    <div class="col-12 mb-4">
      <label for="category_id" class="form-label">Categoria</label>
      <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
        <option value="">Non categorizzato</option>
        <option value="100" @if (old('category_id') == '100') selected @endif>Non valido</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>{{ $category->label }}
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
      <div class="form-check @error('tags') is-invalid @enderror">
        @foreach ($tags as $tag)
          <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
            class="form-check-control" @if (in_array($tag->id, old('tags', []))) checked @endif>
          <label for="tag-{{ $tag->id }}">{{ $tag->label }}</label>
          <br>
        @endforeach
      </div>

      @error('tags')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror

    </div>

    <div class="col-12 mb-4">
      <label for="content" class="form-label">Contenuto</label>
      <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content') }}</textarea>
      @error('content')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="col-12 mb-4">
      <button class="btn btn-success">
        <i class="fa-solid fa-floppy-disk me-1"></i>
        Salva
      </button>
    </div>

  </form>
@endsection


@section('scripts')
  <script type="text/javascript">
    const inputFileElement = document.getElementById('cover_image');
    const coverImagePreview = document.getElementById('cover_image_preview');

    if (!coverImagePreview.getAttribute('src')) {
      coverImagePreview.src = "https://placehold.co/400";
    }

    inputFileElement.addEventListener('change', function() {
      const [file] = this.files;
      coverImagePreview.src = URL.createObjectURL(file);
    })
  </script>
@endsection
