@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content-header')
  <h1 class="my-3">Lista posts</h1>
  <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success">
    <i class="fa-solid fa-plus me-1"></i>
    Crea Post
  </a>

  <a href="{{ route('admin.posts.trash.index') }}" class="btn btn-outline-success">
    <i class="fa-solid fa-trash"></i>
    Vedi cestino
  </a>
@endsection

@section('content')
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Tags</th>
        <th scope="col">Published</th>
        <th scope="col">Slug</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @forelse($posts as $post)
        <tr>
          <th scope="row">{{ $post->id }}</th>
          <td>{{ $post->title }}</td>
          <td>{!! $post->getCategoryBadge() !!}</td>
          <td>{!! $post->getTagBadges() !!}</td>
          <td>
            <form action="{{ route('admin.posts.publish', $post) }}" method="POST"
              id="form-published-{{ $post->id }}">
              @method('PATCH')
              @csrf

              <label class="switch">
                <input type="checkbox" name="published" @if ($post->published) checked @endif>
                <span class="slider round checkbox-published" data-id="{{ $post->id }}"></span>
              </label>
            </form>
          </td>
          <td>{{ $post->slug }}</td>
          <td>


            <a href="{{ route('admin.posts.show', $post) }}" class="d-inline-block mx-1">
              <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>

            <a href="{{ route('admin.posts.edit', $post) }}" class="d-inline-block mx-1">
              <i class="fa-solid fa-pencil"></i>
            </a>

            <a href="javascript:void(0)" class="d-inline-block mx-1 text-danger" data-bs-toggle="modal"
              data-bs-target="#delete-post-modal-{{ $post->id }}">
              <i class="fa-solid fa-trash"></i>
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6"><i>Non ci sono posts</i></td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $posts->links('pagination::bootstrap-5') }}
@endsection

@section('modals')
  @foreach ($posts as $post)
    <div class="modal fade" id="delete-post-modal-{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
      tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Conferma eliminazione</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Sei sicuro di voler mettere nel cestino il post "{{ $post->title }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
              id="form-published-{{ $post->id }}">
              @method('DELETE')
              @csrf
              <button class="btn btn-danger">Elimina</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection


@section('scripts')
  <script>
    const checkboxesPublished = document.getElementsByClassName('checkbox-published');
    console.log(checkboxesPublished);


    for (checkbox of checkboxesPublished) {
      checkbox.addEventListener('click', function() {
        const idPost = this.getAttribute('data-id');
        const form = document.getElementById('form-published-' + idPost);
        form.submit();
      })
    }
  </script>
@endsection
