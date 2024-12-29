@extends('beanstalkdui::layout')

@section('styles')
    <style type="text/css">
        #tubes i {
            background-color: #fff;
            border-radius: 4px;
            font-style: normal;
            padding: 4px;
            transition: background-color .3s ease-out;
        }
        #tubes i.f {
            background-color: #0f0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Beanstalkd Admin UI</h1>
        </div>
    </div>

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
                            <th>Tube</th>
                            <th>current-jobs-urgent</th>
                            <th>current-jobs-ready</th>
                            <th>current-jobs-reserved</th>
                            <th>current-jobs-delayed</th>
                            <th>current-jobs-buried</th>
                            <th>current-using</th>
                            <th>current-watching</th>
                            <th>total-jobs</th>
                            <th>cmd-delete</th>
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
                            <td>
                                <i>@{{ tube['total-jobs'] }}</i>
                            </td>
                            <td>
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
