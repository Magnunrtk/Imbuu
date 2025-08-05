@extends('template.layout_admin')

@section('toolbar')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Logs
                    <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
                    <span class="text-muted fs-7 fw-bold mt-2">Dashboard</span>
                </h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3"></div>
        </div>
    </div>
@endsection
@section('content')
    <div id="kt_content_container" class="container-fluid">
        <div class="card card-flush py-4">
            <div class="card-body p-5 p-lg-10">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <canvas id="stats-doughnut-chart" height="300" class="mb-3"></canvas>
                    </div>
                    <div class="col-md-6 col-lg-9">
                        <div class="row">
                            @foreach($percents as $level => $item)
                                <div class="col-sm-6 col-md-12 col-lg-4 mb-3">
                                    <div class="box level-{{ $level }} {{ $item['count'] === 0 ? 'empty' : '' }}">
                                        <div class="box-icon">
                                            {!! log_styler()->icon($level) !!}
                                        </div>

                                        <div class="box-content">
                                            <span class="box-text">{{ $item['name'] }}</span>
                                            <span class="box-number">
                                                {{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %
                                            </span>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            new Chart(document.getElementById("stats-doughnut-chart"), {
                type: 'doughnut',
                data: {!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
    </script>
@endsection