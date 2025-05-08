@extends('beanstalkdui::layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/beanstalkdui/css/beanstalkdui.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="/beanstalkd/tubes">Back</a>
            <h1 class="page-header">{{ $tube }}</h1>
        </div>
    </div>

    <div id="app" tube="{{ $tube }}" prefix="{{ $prefix }}" v-cloak>
        @include('beanstalkdui::tubes.partials.stats_row')

        <div class="row">
            <div class="col-xs-12">
                <h2>Next up</h2>
            </div>
        </div>

        <div class="row">
            @include('beanstalkdui::tubes.partials.next_ready')
            @include('beanstalkdui::tubes.partials.next_buried')

            <div class="col-xs-12 col-md-12 col-lg-12">
                <b>release: <span class="badge badge-secondary">@{{ nextDelayed['stats']['releases'] }}</span></b>
                <i>&nbsp;</i>
                <b>reserves: <span class="badge badge-secondary">@{{ nextDelayed['stats']['reserves'] }}</span></b>
                <i>&nbsp;</i>
                <b>age: <span class="badge badge-secondary">@{{ nextDelayed['stats']['age'] }}</span></b>
                <i>&nbsp;</i>
                <b>kicks: <span class="badge badge-secondary">@{{ nextDelayed['stats']['kicks'] }}</span></b>
            </div>

            @include('beanstalkdui::tubes.partials.next_delayed')
        </div>
    </div>

    @if (config('beanstalkdui.failed_jobs'))
        @include('beanstalkdui::tubes.partials.failed_table')
    @endif
@stop


@section('scripts')
    <script src="{{ asset('vendor/beanstalkdui/js/vendor/vue.min.js') }}"></script>
    <script src="{{ asset('vendor/beanstalkdui/js/components/job-action.js') }}"></script>
    <script src="{{ asset('vendor/beanstalkdui/js/components/tube-stat.js') }}"></script>
    <script src="{{ asset('vendor/beanstalkdui/js/components/next-job.js') }}"></script>
    <script src="{{ asset('vendor/beanstalkdui/js/app.js') }}"></script>

    @if (config('beanstalkdui.failed_jobs'))
        <script src="{{ asset('vendor/beanstalkdui/js/failed-jobs-table.js') }}"></script>
    @endif
@stop
