@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success_message'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success_message') }}</li>
        </ul>
    </div>
@endif
