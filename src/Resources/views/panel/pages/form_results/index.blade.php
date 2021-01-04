@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $form->name }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-content">
                    <div id="accordion" class="mb-3" role="tablist" aria-multiselectable="true">
                        @foreach($results as $result)
                            <div class="block block-rounded mb-1">
                                <div class="block-header {{ $result->read == 2 ? 'bg-black-10' : '' }}" role="tab" id="accordion_{{ $result->id }}">
                                    <a class="font-w600 w-100 accordionBtn"
                                       data-toggle="collapse"
                                       data-parent="#accordion"
                                       href="#accordion_q{{ $result->id }}"
                                       aria-expanded="true"
                                       aria-controls="accordion_q{{ $result->id }}"
                                       data-id="{{ $result->id }}"
                                       data-read="{{ $result->read }}">
                                        <div class="row">
                                            <div class="col-md-4">{{ $result->email }}</div>
                                            <div class="col-md-3">{{ $result->ip }}</div>
                                            <div class="col-md-4">{{ $result->created_at->formatLocalized('%d %B %Y, %H:%M:%S') }}</div>
                                            <div class="col-md-1"><i class="fa fa-chevron-down float-right"></i></div>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion_q{{ $result->id }}" class="collapse" role="tabpanel" aria-labelledby="accordion_{{ $result->id }}" data-parent="#accordion">

                                    <div class="block-content">
                                        <table class="table table-vcenter">
                                            <tbody>
                                                @foreach($result->data as $label => $value)
                                                    <tr>
                                                        <th class="font-w600">{!! $label !!}</th>
                                                        <td>
                                                            {!! $value !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th class="font-w600">IP</th>
                                                    <td>
                                                        {{ $result->ip }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="font-w600">{{ __('DawnstarLang::form.send_time') }}</th>
                                                    <td>
                                                        {{ $result->created_at->formatLocalized('%d %B %Y, %H:%M:%S') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($results->hasPages())
                        <div class="row mt-5">
                            <div class="col-md-12 d-flex justify-content-center">
                                {!! $results->links('DawnstarView::layouts.pagination') !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('.accordionBtn').click(function () {
            var self = $(this);
            var id = self.attr('data-id');
            var readStatus = self.attr('data-read') == 2;

            if(readStatus) {
                $.ajax({
                    'url': '{{ route('dawnstar.form.result.updateReadStatus', ['formId' => $form->id]) }}',
                    'method': 'GET',
                    'data': {id: id},
                    success: function () {
                        self.closest('div.block-header').removeClass('bg-black-10');
                        self.attr('data-read', 1);
                    }
                })
            }
        });
    </script>
@endpush
