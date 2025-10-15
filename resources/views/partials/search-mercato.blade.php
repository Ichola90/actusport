@if($articles->count() > 0)
    @foreach($articles as $post)
    <div class="post-item d-flex mb-3">
        <img src="{{ $post->image ? asset($post->image) : 'https://via.placeholder.com/80x80?text=Article' }}"
            alt="{{ $post->title }}" class="flex-shrink-0 me-2" width="80">
        <div>
            <h4><a href="{{ route('actuafrique.detail', $post->id) }}">{{ Str::limit($post->title, 30) }}</a></h4>
            <time datetime="{{ $post->created_at->format('Y-m-d') }}">
                {{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
            </time>
        </div>
    </div>
    @endforeach
@else
    <p>Aucun article trouvé</p>
@endif
