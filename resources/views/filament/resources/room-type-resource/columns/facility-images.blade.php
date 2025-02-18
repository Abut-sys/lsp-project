@php
    // Pastikan $getState() menghasilkan array atau decode JSON jika perlu
    $images = is_array($getState()) ? $getState() : json_decode($getState(), true);
@endphp

@if($images)
    <div class="flex space-x-2">
        @foreach($images as $image)
            <img src="{{ Storage::url($image) }}" alt="Facility Image" class="h-10 w-10 object-cover rounded">
        @endforeach
    </div>
@else
    <span class="text-gray-400 text-sm">No image</span>
@endif
