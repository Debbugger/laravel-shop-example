@extends('admin::main')

@section('title', 'Главная')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Статистика</h4>
            </div>
            <div class="row row-cards">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="text-muted">Стоимость оставшихся товаров</div>
                                    @if ($status==1)
                                        <div class="h3 m-0"><b>{{$costNoBuy}}</b></div>
                                    @else
                                        <div class="h3 m-0"><b>0</b></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="text-muted">Стоимость проданых товаров</div>
                                    @if ($status==1)
                                        <div class="h3 m-0"><b>{{$send}}</b></div>
                                    @else
                                        <div class="h3 m-0"><b>0</b></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="text-muted">Оталось на складе товара(ов)</div>
                                    @if ($status==1)
                                        <div class="h3 m-0"><b>{{$countProduct}}</b></div>
                                    @else
                                        <div class="h3 m-0"><b>0</b></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($status==1)
                <div class="row mg-t-20">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-header card-for-graph">
                                <h3 class="card-title ">Таблица продаж на текущий год</h3>
                                <div class="form-group" style="float: right;">
                                    <label class="form-label">Месяц</label>
                                    <select class="js-select2 change-mounth" name="mounth">
                                        @foreach($mounthes as $key => $mounth)
                                            <option @if ($currM==$key) selected @endif value="{{$key}}">{{$mounth}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="card-body graph">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mg-t-20">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-header card-for-graph">
                                <h3 class="card-title my-3 ">{{$message}}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/modules/exporting.js"></script>
    <script src="//code.highcharts.com/modules/export-data.js"></script>
    <script>
        $('.js-select2').off().select2();
        let days = [];
    </script>
    @if ($status==1)
        <script>
            for (let i = 1; i <='{{$colDays}}'; i++)
                days.push(i);

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Статистика продаж'
                },
                xAxis: {
                    categories: days
                },
                yAxis: {
                    title: {
                        text: 'Продано $'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: 'Продано',
                    data: JSON.parse("{!! $days !!}")
                }]
            });
            (new SaveTrait({selector: '[name=mounth]', showFailToast: false, selectorType: 'change', actionUrl: "{{route('adminGraphMounth')}}"}).setAdditionalData(function (callback) {
                callback.append('mounth', $('[name=mounth]').val());
                return callback;
            }).setAdditionalFailCallback(function (callback) {
                $('.graph').html(callback);
            }));
        </script>
    @endif

@endpush