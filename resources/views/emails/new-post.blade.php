<!DOCTYPE html>
<html>
<head>
    <title>Nouveau post sur La Forêt Des Pixels</title>
</head>
<body>
    <h2>Nouveau post publié sur La Forêt Des Pixels</h2>
    <h3>{{ $post->title }}</h3>
    
    @if($post->image)
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 600px; max-height: 300px;">
    </div>
    @endif
    
    <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->body), 200) }}...</p>
    
    <p><a href="{{ url('/posts/' . $post->id) }}">Lire la suite</a></p>
    
    <p>Merci de suivre notre blog !</p>
    <p>L'équipe de La Forêt Des Pixels</p>
    
    <p style="font-size: 12px; color: #666;">
        Si vous ne souhaitez plus recevoir ces notifications, 
        <a href="{{ url('/unsubscribe/' . encrypt($post->user->email)) }}">cliquez ici pour vous désabonner</a>.
    </p>
</body>
</html>