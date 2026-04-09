<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{
                name: 'Kendaraan Masuk',
                data: {!! json_encode($chartSeries ?? []) !!}
            }],
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Outfit, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#4f46e5'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [50, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($chartCategories ?? []) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#94a3b8', fontSize: '13px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#94a3b8', fontSize: '13px' }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return val + " Kendaraan" } }
            }
        };

        if(document.querySelector("#mainChart")) {
            var chart = new ApexCharts(document.querySelector("#mainChart"), options);
            chart.render();
        }
    });
</script>
