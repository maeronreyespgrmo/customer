@if(count($errors))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@else
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Aslert!</h5>
            {{ session('success') }}
        </div>
    @endif
@endif