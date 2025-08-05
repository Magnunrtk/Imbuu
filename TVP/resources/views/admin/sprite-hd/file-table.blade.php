@php
    $storagePath = storage_path('app/sprites');
    $datFile = $storagePath . '/Tibia.dat';
    $sprFile = $storagePath . '/Tibia.spr';
@endphp

@if (file_exists($datFile) && file_exists($sprFile))
    <table class="upload-table text-center">
        <thead>
            <tr>
                <th class="text-center">Arquivo</th>
                <th class="text-center">Data de Modificação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tibia.dat</td>
                <td>{{ date('d/m/Y H:i:s', filemtime($datFile)) }}</td>
            </tr>
            <tr>
                <td>Tibia.spr</td>
                <td>{{ date('d/m/Y H:i:s', filemtime($sprFile)) }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <form action="{{ route('admin.spriteHD.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-custom">Converter para PNG</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p class="text-danger text-center">Nenhum arquivo enviado ainda.</p>
@endif
