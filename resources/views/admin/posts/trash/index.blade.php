@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content-header')
  <h1 class="my-3">Lista posts cestinati</h1>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-success">
    <i class="fa-solid fa-arrow-left me-1"></i>
    Torna alla lista
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
        <th scope="col">Slug</th>
        <th scope="col">Deleted at</th>
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
          <td>{{ $post->slug }}</td>
          <td>{{ $post->deleted_at }}</td>
          <td>

            <a href="javascript:void(0)" class="d-inline-block mx-1 text-success" data-bs-toggle="modal"
              data-bs-target="#restore-post-modal-{{ $post->id }}">
              <i class="fa-solid fa-arrow-turn-up fa-rotate-270"></i>
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
            Sei sicuro di voler eliminare <strong>definitivamente</strong> il post "{{ $post->title }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

            <form method="POST" action="{{ route('admin.posts.trash.force-destroy', $post) }}">
              @method('DELETE')
              @csrf
              <button class="btn btn-danger">Elimina</button>
            </form>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="restore-post-modal-{{ $post->id }}" data-bs-backdrop="static"
      data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Conferma ripristino</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Sei sicuro di voler ripristinare il post "{{ $post->title }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

            <form method="POST" action="{{ route('admin.posts.trash.restore', $post) }}">
              @method('PATCH')
              @csrf
              <button class="btn btn-success">Ripristina</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection
