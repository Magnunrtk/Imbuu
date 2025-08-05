@extends('template.layout_admin')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

    input[type="text"], input[type="number"], select {
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        height: 20px; 
        width: 100px; 
    }

    input[type="text"]:focus, input[type="number"]:focus, select:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    button[type="button"] {
        width: 100px;
        background-color: #6f42c1; 
        color: #fff; 
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        height: 20px;
    }

    button[type="button"]:hover {
        background-color: #5a3ec8; 
    }

</style>

<h1>Bazaar Data</h1>
<p>Coins Arrecadados Bazaar Taxa Atual: 12% <br><span id="totalArrecadado"></span></p> 

<form id="filterForm">
    <label for="year">Ano:</label>
    <select id="year" name="year">
        @for ($i = date('Y'); $i >= 2000; $i--)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>

    <label for="month">Mês:</label>
    <select id="month" name="month">
        <option value="">Todos</option>
        @php
            $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        @endphp
        @for ($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}">{{ $meses[$m - 1] }}</option>
        @endfor
    </select>

    <button type="button" onclick="updateChart()">Filtrar</button>
</form>

<canvas id="bazaarChart" width="400" height="200"></canvas>

<script>

    var ctx = document.getElementById('bazaarChart').getContext('2d');
    var bazaarData = @json($bazaarData);
    
    function updateChart() {
        var selectedYear = document.getElementById('year').value;
        var selectedMonth = document.getElementById('month').value;

        var filteredData = bazaarData.filter(function(data) {
            var date = new Date(data.date);
            var year = date.getFullYear();
            var month = date.getMonth() + 1;

            return year == selectedYear && (selectedMonth === "" || month == selectedMonth);
        });

        var dates = filteredData.map(function(data) {
            return data.date;
        });

        var adjustedData = filteredData.map(function(data) {
            return Math.round(data.coins * 0.12);
        });

        var totalArrecadado = adjustedData.reduce((sum, value) => sum + value, 0);

        bazaarChart.data.labels = dates;
        bazaarChart.data.datasets[0].data = adjustedData;
        bazaarChart.update();

        var totalText = 'Total Arrecadado: ' + totalArrecadado + ' / R$: ' + (totalArrecadado * 0.40).toFixed(2);
        document.getElementById('totalArrecadado').innerText = totalText;
    }

    Chart.register({
        id: 'totalArrecadadoPlugin',
        beforeDraw: (chart) => {
            const ctx = chart.ctx;
            ctx.save();
            ctx.font = '20px Arial';
            ctx.restore();
        }
    });

    var bazaarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Ravenor Coins',
                data: [],
                backgroundColor: 'rgba(90, 62, 200, 0.2)',
                borderColor: 'rgba(90, 62, 200, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: ['totalArrecadadoPlugin']
    });

    updateChart();

</script>

@endsection
