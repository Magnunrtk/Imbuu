@extends('template.layout_admin')
@section('content')

@php
$groupedItems = collect($listData)->groupBy('month');
@endphp

<style>
    .scrollable-content {
        max-height: 300px;
        overflow-y: auto; 
    }
</style>

<div class="container">

    <div class="form-group">
        <label for="month">Escolha o mês e ano:</label>
        <select class="form-control" id="monthSelect">
            @foreach($groupedItems->keys()->reverse() as $month)
            <option value="{{ $month }}">{{ $month }}</option>
            @endforeach
        </select>
    </div>

    <br>

    <div class="row">
        <div class="col">
            <div id="nonTransferredItems" class="scrollable-content">
                <div id="nonTransferredContent">
                </div>
            </div>
        </div>
        <div class="col">
            <div id="transferredItems" class="scrollable-content mb-4">
                <div id="transferredContent">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="year">Escolha o ano:</label>
        <select class="form-control" id="yearSelect">
            @foreach($availableYears as $year)
            <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <canvas id="monthChart" width="400" height="200"></canvas>

</div>

<script>

    var myChart;

    function createOrUpdateMonthChart(monthlyTotals) {
        var ctx = document.getElementById('monthChart').getContext('2d');
        var labels = Object.keys(monthlyTotals);
        var data = Object.values(monthlyTotals);

        if (myChart) {
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.update();
        } else {
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total de Shop Items',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }

    function updateChartByYear(year) {
        var monthData = @json($groupedItems);
        var monthlyTotals = {};

        for (var month in monthData) {
            var monthYear = month.split(' ')[1];
            if (monthYear == year) {
                var totalShopItems = 0;
                monthData[month].forEach(function(data) {
                    totalShopItems += data.items.reduce(function(sum, item) {
                        if (!item.description.toLowerCase().includes('transfered') && !item.description.toLowerCase().includes('withdrawn')) {
                            return sum + item.coin_amount;
                        } else {
                            return sum;
                        }
                    }, 0);
                });
                monthlyTotals[month] = totalShopItems;
            }
        }

        createOrUpdateMonthChart(monthlyTotals);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var currentYear = new Date().getFullYear();
        document.getElementById('yearSelect').value = currentYear;
        updateChartByYear(currentYear);
    });

    document.getElementById('yearSelect').addEventListener('change', function() {
        var selectedYear = this.value;
        updateChartByYear(selectedYear);
    });
</script>

<script>

    function updateMonthContent(selectedMonth) {

        var monthData = @json($groupedItems);
        document.getElementById('transferredItems').innerHTML = '';
        document.getElementById('nonTransferredItems').innerHTML = '';

        if (monthData[selectedMonth]) {
 
            var groupedItems = {};
            monthData[selectedMonth].forEach(function(month) {
                month.items.forEach(function(item) {

                    var description = item.description.toLowerCase();
                    var  isTransferred = description.includes('transfered') || description.includes('withdrawn');
                    var groupKey = isTransferred ? 'transferredItems' : 'nonTransferredItems';
                    if (!groupedItems[groupKey]) {
                        groupedItems[groupKey] = {};
                    }
                    if (!groupedItems[groupKey][item.description]) {
                        groupedItems[groupKey][item.description] = 0;
                    }
                    groupedItems[groupKey][item.description] += item.coin_amount;
                });
            });

            for (var groupKey in groupedItems) {
                var groupTitle = groupKey === 'transferredItems' ? 'Transferencias' : 'Shop Items';
                var content = '<h2>' + groupTitle + '</h2><ul>';
                var totalAmountGroup = Object.values(groupedItems[groupKey]).reduce(function(total, amount) {
                    return total + amount;
                }, 0);
                totalAmountGroup = totalAmountGroup.toLocaleString();
                content += '<li><strong>Total: ' + totalAmountGroup + '</strong></li>';
                var sortedDescriptions = Object.keys(groupedItems[groupKey]).sort(function(a, b) {
                    return groupedItems[groupKey][b] - groupedItems[groupKey][a];
                });
                sortedDescriptions.forEach(function(description) {
                    content += '<li>' + description + ' - ' + groupedItems[groupKey][description].toLocaleString() + '</li>';
                });
                content += '</ul>';
                document.getElementById(groupKey).innerHTML += content;
            }
        } else {
            document.getElementById('transferredContent').innerHTML = '<ul><li>Não há registros para o mês selecionado.</li></ul>';
            document.getElementById('nonTransferredContent').innerHTML = '<ul><li>Não há registros para o mês selecionado.</li></ul>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var currentMonth = '{{ date("F Y") }}';
        updateMonthContent(currentMonth);
        document.getElementById('monthSelect').value = currentMonth;
    });

    document.getElementById('monthSelect').addEventListener('change', function() {
        var selectedMonth = this.value;
        updateMonthContent(selectedMonth);
    });
</script>

@endsection
