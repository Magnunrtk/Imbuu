@if($streamers->isEmpty())
    <tr>
        <td colspan="6" class="text-center">No streamers found.</td>
    </tr>
@else
    @foreach($streamers as $streamer)
        <tr>
            <td>{{ $loop->iteration }}</td>
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
