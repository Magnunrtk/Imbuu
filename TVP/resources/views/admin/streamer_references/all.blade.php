@extends('template.layout_admin')

@section('title', 'All Streamers')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Webhook Streamers</h3>
    </div>
    
    <div class="card-body">

        {{-- Mensagem de sucesso --}}
        <div id="successMessage" class="alert alert-success" style="display:none;"></div>

        <p class="mb-3">
            <strong>Como adicionar um streamer:</strong><br>
            Basta digitar o nome de usuário final do canal da Twitch, que aparece no link do canal.<br>
            Por exemplo, se o link for 
            <code>https://www.twitch.tv/beatriz</code>, você deve inserir apenas 
            <code>beatriz</code>.<br>
            As notificações serão exibidas automaticamente quando esse streamer entrar ao vivo.<br><br>
            <strong>Importante:</strong> Para que a notificação seja realmente enviada, o título da live deve conter pelo menos uma das seguintes frases:<br>
            <code>play ravenor</code>, <code>playing ravenor</code>, <code>play ravenor.online</code> ou <code>playing ravenor.online</code>.
        </p>

        <div class="mb-4">
            <form id="addStreamerForm" class="form-inline">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" name="username" placeholder="Twitch username" required>
                    <button type="submit" class="btn btn-primary">Add Streamer</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Profile</th>
                        <th>Contracted?</th>
                        <th>Registred At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($streamers->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No streamers found.</td>
                        </tr>
                    @else
                        @foreach($streamers as $streamer)
                            <tr>
                                <td>{{ $loop->iteration }}</td> {{-- Aqui é o índice one-based --}}
                                <td>{{ $streamer->username }}</td>
                                <td>
                                    @if($streamer->profile_image_url)
                                        <img src="{{ $streamer->profile_image_url }}" alt="Profile" width="40" height="40">
                                    @endif
                                </td>
                                <td>
                                    @if($streamer->is_contracted)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $streamer->created_at }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-btn" data-id="{{ $streamer->id }}">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const csrfToken = '{{ csrf_token() }}';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

    const successMessageDiv = document.getElementById('successMessage');

    document.getElementById('addStreamerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const username = form.username.value.trim();

        axios.post("{{ route('admin.streamerReferences.store') }}", { username })
            .then(response => {
                successMessageDiv.textContent = response.data.message || 'Streamer adicionado com sucesso!';
                successMessageDiv.style.display = 'block';

                form.reset();
                fetchStreamers();

                setTimeout(() => {
                    successMessageDiv.style.display = 'none';
                }, 3000);
            })
            .catch(error => {
                alert('Erro ao adicionar streamer.');
                console.error(error);
            });
    });

    function fetchStreamers() {
        axios.get("{{ route('admin.streamerReferences.get-updated-data') }}")
            .then(response => {
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = response.data.html;
                addRemoveListeners();
            });
    }

    function addRemoveListeners() {
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                if (!confirm('Tem certeza que deseja remover este streamer?')) return;

                axios.delete(`/admin/streamerReferences/${id}`)
                    .then(response => {
                        successMessageDiv.textContent = response.data.message || 'Streamer removido com sucesso!';
                        successMessageDiv.style.display = 'block';

                        fetchStreamers();

                        setTimeout(() => {
                            successMessageDiv.style.display = 'none';
                        }, 3000);
                    })
                    .catch(() => alert('Erro ao remover streamer.'));
            });
        });
    }

    addRemoveListeners();
</script>

@endsection
