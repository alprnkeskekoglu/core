@extends('DawnstarView::layouts.app')

@php
    $charts = ['views', 'visitors', 'devices', 'operating_systems', 'browsers', 'most_visited_pages']
@endphp

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                @foreach($charts as $chart)
                    @include('DawnstarView::pages.dashboard.charts.' . $chart)
                @endforeach
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="//code.highcharts.com/highcharts.js"></script>
@endpush
