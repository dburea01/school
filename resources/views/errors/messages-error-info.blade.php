@if(Session::has('success'))

<div class="alert alert-success" role="alert">
    {!! Session::get('success') !!}
</div>

@php
Session::forget('success');
@endphp
@endif

@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
    {!! Session::get('error') !!}
</div>

@php
Session::forget('error');
@endphp
@endif

@if(Session::has('warning'))
<div class="alert alert-warning" role="alert">
    {!! Session::get('warning') !!}
</div>

@php
Session::forget('warning');
@endphp
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif