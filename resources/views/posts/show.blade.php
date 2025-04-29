@extends('layout.app')
@section('title', $post->title)
@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">{{$post->title}}</h1>
            <p class="text-muted">{{$post->published_at}} by {{$post->user->name}}.</p>
          <!--   <img src="{{Storage::disk('public')->url($post->image)}}" alt="Blog Image" class="img-fluid mb-4"> -->
           <!--  <img src="{{ asset('storage/posts/' . $post->image) }}" alt="Blog Image" class="img-fluid mb-4"> -->
           <img src="{{ Storage::url($post->image) }}" alt="Blog Image" class="img-fluid mb-4">
            <p>{{$post->body}}</p>
        </div>
    </div>
    <!-- Section Like -->
    <div class="d-flex align-items-center mb-4">
                @auth
                <form action="{{ route('posts.like', $post) }}" method="POST" class="me-2">
                    @csrf
                    <button type="submit" class="btn {{ Auth::user()->hasLiked($post) ? 'btn-danger' : 'btn-outline-danger' }}">
                        <i class="bi bi-heart-fill me-1"></i> 
                        {{ Auth::user()->hasLiked($post) ? 'Unlike' : 'Like' }}
                    </button>
                </form>
                @endauth
                <span class="fw-bold">{{ $post->likes_count }} {{ Str::plural('like', $post->likes_count) }}</span>
            </div>
            
            <!-- Section Commentaires -->
            <div class="comments-section mt-5">
                <h3 class="mb-4">Commentaires ({{ $post->comments->count() }})</h3>
                
                @auth
                <!-- Formulaire de commentaire -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-3">
                                <label for="content" class="form-label">Laisser un commentaire</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.
                </div>
                @endauth
                
                <!-- Liste des commentaires -->
                <div class="comments-list">
                    @forelse($post->comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="card-title">{{ $comment->user->name }}</h5>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="card-text">{{ $comment->content }}</p>
                                
                                @auth
                                    @if(Auth::id() == $comment->user_id || Auth::user()->isAdmin())
                                    <div class="mt-2">
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-secondary">
                            Aucun commentaire pour le moment. Soyez le premier à commenter!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection