<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
    $(document).ready(function () {
        let days = [];
        for (let i = 1; i <= '{{$colDays}}'; i++)
            days.push(i);
        Highcharts.chart('container', {
            chart: {
                type: 'line'
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
                data: JSON.parse('{!! $days !!}')
            }]
        });
    });
</script>