<table class="table table-hover table-bordered align-middle">
    <thead class="table-dark text-center">
        <tr>
            <th>#</th>
            <th>Streamer</th>
            <th>Data</th>
            <th>Horas Gravadas</th>
        </tr>
    </thead>
    <tbody>
        @forelse($horas as $i => $registro)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td class="d-flex align-items-center gap-2">
                    <img src="{{ $registro->profile_image_url }}" alt="Foto" width="36" height="36"
                         class="rounded-circle shadow-sm">
                    <strong>{{ $registro->username }}</strong>
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($registro->date)->format('d/m/Y') }}
                </td>
                <td class="text-center">{{ $registro->hours }} h</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum registro de horas encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>
