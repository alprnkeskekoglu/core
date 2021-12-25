<div class="modal-header">
    <h4 class="modal-title" id="standard-modalLabel">{{ $form->name }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <table class="table table-borderless mb-0">
        <tbody>
        <tr>
            <td class="fw-bolder w-25">@lang('Core::form_message.labels.sended_time')</td>
            <td>{{ \Carbon\Carbon::parse($message->created_at)->formatLocalized('%A %d %B %Y') . ', ' . \Carbon\Carbon::parse($message->created_at)->format('H:i:s') }}</td>
        </tr>
        <tr>
            <td class="fw-bolder w-25">IP</td>
            <td>{{ $message->ip }}</td>
        </tr>
        @if($message->email)
        <tr>
            <td class="fw-bolder w-25">@lang('Core::form_message.labels.email')</td>
            <td>{{ $message->email }}</td>
        </tr>
        @endif
        @foreach($message->data as $key => $value)
            @continue($key == 'email')
        <tr>
            <td class="fw-bolder w-25">{{ custom('form.' . $form->id . '.' . $key) }}</td>
            <td>{{ $value }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
