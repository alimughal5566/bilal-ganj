@if ($errors->has($filed))
    <div class="text-danger w-100">
        <span class="">{{$errors->first($filed)}}</span>
    </div>
@endif