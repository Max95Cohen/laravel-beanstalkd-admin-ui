@extends('beanstalkdui::layout')

@section('styles')
    <style type="text/css">
        #tubes i {
            font-style: normal;
            padding: 4px 0;
            position: relative;
        }

        #tubes i.d:after,
        #tubes i.u:after {
            border-radius: 4px;
            content: '';
            display: inline-block;
            height: 12px;
            left: -16px;
            margin-left: 2px;
            opacity: 1;
            position: absolute;
            top: 0;
            transition: opacity .3s ease-out;
            width: 12px;
        }

        #tubes i.d::after {
            background-color: #0f0;
            top: 14px;
        }

        #tubes i.u::after {
            background-color: #d00;
        }

        #tubes i.h.d:after,
        #tubes i.h.u:after {
            opacity: .1;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12" style="float: none">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tubes</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content" id="app" style="overflow: auto">
                    {{-- @include('beanstalkdui::tubes.partials.tube-table') --}}

                    <table class="table table-horizontal table-striped" id="tubes">
                        <thead>
                        <tr>
                            <th>tube</th>
                            <th>urgent</th>
                            <th>ready</th>
                            <th>reserved</th>
                            <th>delayed</th>
                            <th>buried</th>
                            <th>using</th>
                            <th>watching</th>
                            <th>total</th>
                            <th>deleted</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="tube of tubes">
                            <td data-test="a">
                                <a href="@{{'/beanstalkd/tubes/' + tube.name}}">@{{ tube.name }}</a>
                            </td>

                            <td>
                                <i>@{{ tube['current-jobs-urgent'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-jobs-ready'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-jobs-reserved'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-jobs-delayed'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-jobs-buried'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-using'] }}</i>
                            </td>
                            <td>
                                <i>@{{ tube['current-watching'] }}</i>
                            </td>
                            <td class="jobs">
                                <i>@{{ tube['total-jobs'] }}</i>
                            </td>
                            <td class="deleted">
                                <i>@{{ tube['cmd-delete'] }}</i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('vendor/beanstalkdui/js/vendor/vue.min.js') }}"></script>
    <script src="{{ asset('vendor/beanstalkdui/js/index.js?a=1') }}"></script>
@endsection
