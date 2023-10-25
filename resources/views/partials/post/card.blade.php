@if (!empty($post))
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between">{{ $post->title }} {!! $post->getCategoryBadge() !!}</div>
    <div class="card-body">
      {{ $post->getAbstract(150) }}
    </div>

    <div class="card-footer">
      <a class="btn btn-primary" href="{{ route('guest.posts.detail', $post->slug) }}"> vedi</a>
    </div>
  </div>
@endif
