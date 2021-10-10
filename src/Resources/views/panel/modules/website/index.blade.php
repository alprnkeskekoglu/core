@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::website.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.websites.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::general.status')</th>
                                <th>@lang('Dawnstar::website.labels.name')</th>
                                <th>@lang('Dawnstar::website.labels.domain')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <span class="badge bg-success font-16">Active</span>
                                </td>
                                <td>
                                    Dawnstar
                                </td>
                                <td>dawnstar.local</td>
                                <td class="table-action">
                                    <a href="create.php" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                    <form action="" class="d-inline">
                                        <button type="submit" class="btn action-icon"> <i class="mdi mdi-delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
