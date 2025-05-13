<footer class="footer bg-dark text-light">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h5>La Forêt Des Pixels</h5>
                <p class="small">&copy; 2025 La Forêt Des Pixels. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <h5>Contactez-nous</h5>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" placeholder="Votre nom" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" placeholder="Votre email" required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control form-control-sm @error('message') is-invalid @enderror" name="message" rows="2" placeholder="Votre message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</footer>