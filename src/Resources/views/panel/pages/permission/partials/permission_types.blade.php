@php
    $types = $types ?? ['index', 'create', 'edit', 'delete'];
    $icons = $icons ?? ['index' => 'bars', 'create' => 'plus', 'edit' => 'edit', 'delete' => 'trash-alt']
@endphp
@foreach($types as $type)
    <div class="form-group row">
        <label class="d-block col-md-3"><i class="fa fa-{{ $icons[$type] ?? 'skull' }} mr-2"></i>@lang('DawnstarLang::permission.types.' . $type)</label>
        <div class="col-md-8">
            <div class="custom-control custom-radio custom-control-inline custom-control-lg custom-control-success">
                <input type="radio" class="custom-control-input" id="{{ str_replace('.', '_', $key) . '_' . $type . '_allow' }}" name="permissions[{{ $key . '.' . $type }}]" value="1" {{ $role->hasPermissionTo($key . '.' . $type) ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ str_replace('.', '_', $key) . '_' . $type . '_allow' }}">@lang('DawnstarLang::permission.allow')</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline custom-control-lg custom-control-danger">
                <input type="radio" class="custom-control-input" id="{{ str_replace('.', '_', $key) . '_' . $type . '_forbid' }}" name="permissions[{{ $key . '.' . $type }}]" value="0" {{ $role->hasPermissionTo($key . '.' . $type) ? '' : 'checked' }}>
                <label class="custom-control-label" for="{{ str_replace('.', '_', $key) . '_' . $type . '_forbid' }}">@lang('DawnstarLang::permission.forbid')</label>
            </div>
        </div>
    </div>
@endforeach
