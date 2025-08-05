@extends('template.layout_admin')

@section('title', 'Horas Gravadas')

@section('content')

<style>
  .nav-tabs .nav-link {
    background-color: #1E2129;
    color: white;
    border: none;
  }

  .nav-tabs .nav-link.active {
    background-color: #343A40;
    color: white;
    font-weight: bold;
  }

  .nav-tabs {
    border-bottom: none;
  }

  #numerosPaginas button {
    border: 1px solid #343A40;
    background-color: #1E2129;
    color: white;
    font-weight: 500;
  }

  #numerosPaginas button:hover:not(:disabled):not(.active) {
    background-color: #2A2D35;
  }

  #numerosPaginas .active {
    background-color: #343A40 !important;
    color: white !important;
    font-weight: bold;
    cursor: default;
  }
</style>

<div class="container-fluid">
  <ul class="nav nav-tabs mb-3" id="viewTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="table-tab" data-bs-toggle="tab" data-bs-target="#tableView" type="button" role="tab">
        <i class="fas fa-table me-1"></i> Tabela
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chartView" type="button" role="tab">
        <i class="fas fa-chart-bar me-1"></i> Gráfico
      </button>
    </li>
  </ul>

  <div class="tab-content" id="viewTabsContent">

    <div class="d-flex justify-content-between align-items-center mb-2">
      <span id="totalPaginas">» Páginas: 0</span>

      <button id="paginaAnterior" class="btn" style="background-color: #1E2129; color: white; border-color: #343A40;" disabled>
        <i class="fas fa-arrow-left"></i> Anterior
      </button>

      <div id="numerosPaginas" class="d-flex justify-content-center gap-2 mx-4"></div>

      <button id="proximaPagina" class="btn ms-3" style="background-color: #1E2129; color: white; border-color: #343A40;" disabled>
        Próxima <i class="fas fa-arrow-right"></i>
      </button>

      <span id="totalResultados" class="text-end">» Resultados: 0</span>
    </div>

    <div class="tab-pane fade show active" id="tableView" role="tabpanel">
      <div class="row mb-3">
        <div class="col-md-3">
          <label for="monthTableFilter" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Filtrar por Mês</label>
          <select id="monthTableFilter" class="form-select">
            <option value="">Todos</option>
            @foreach(['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $index => $mes)
              <option value="{{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}">{{ $mes }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="yearTableFilter" class="form-label"><i class="fas fa-calendar me-1"></i>Ano</label>
            @php
            $anosComRegistro = $horas->map(function($h) {
                return \Carbon\Carbon::parse($h->date)->year;
            })->unique()->sortDesc();
            @endphp
            <select id="yearTableFilter" class="form-select">
            @foreach($anosComRegistro as $ano)
                <option value="{{ $ano }}" {{ $ano === now()->year ? 'selected' : '' }}>{{ $ano }}</option>
            @endforeach
            </select>
        </div>
        <div class="col-md-3">
          <label for="streamerTableFilter" class="form-label"><i class="fas fa-user me-1"></i>Filtrar por Streamer</label>
          <input type="text" id="streamerTableFilter" list="streamersList" class="form-control" placeholder="Digite nome">
          <datalist id="streamersList">
            @foreach($streamers as $s)
              <option value="{{ $s->username }}">
            @endforeach
          </datalist>
        </div>
        <div class="col-md-3">
          <label for="sortOrder" class="form-label"><i class="fas fa-sort me-1"></i>Ordenar por</label>
          <div class="d-flex">
            <select id="sortField" class="form-select me-2">
              <option value="date">Data</option>
              <option value="hours">Horas Gravadas</option>
            </select>
            <select id="sortOrder" class="form-select">
              <option value="asc">Crescente</option>
              <option value="desc" selected>Decrescente</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="horasTable">
              <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-user me-1"></i>Streamer</th>
                    <th><i class="fas fa-calendar-alt me-1"></i>Data</th>
                    <th><i class="fas fa-clock me-1"></i>Horas Gravadas</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="chartView" role="tabpanel">
      <div class="row mb-3">
        <div class="col-md-3">
          <label for="monthChartFilter" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Filtrar por Mês</label>
          <select id="monthChartFilter" class="form-select">
            <option value="">Todos</option>
            @foreach(['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $index => $mes)
              <option value="{{ str_pad($index+1, 2, '0', STR_PAD_LEFT) }}">{{ $mes }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="yearChartFilter" class="form-label"><i class="fas fa-calendar me-1"></i>Ano</label>
            <select id="yearChartFilter" class="form-select">
            @foreach($anosComRegistro as $ano)
                <option value="{{ $ano }}" {{ $ano === now()->year ? 'selected' : '' }}>{{ $ano }}</option>
            @endforeach
            </select>
        </div>
        <div class="col-md-3">
          <label for="streamerChartFilter" class="form-label"><i class="fas fa-user me-1"></i>Filtrar por Streamer</label>
          <input type="text" id="streamerChartFilter" list="streamersList2" class="form-control" placeholder="Digite nome">
          <datalist id="streamersList2">
            @foreach($streamers as $s)
              <option value="{{ $s->username }}">
            @endforeach
          </datalist>
        </div>
      </div>

      <div class="card h-100">
        <div class="card-header bg-secondary text-white">Gráfico de Horas</div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div><strong>Total de Horas:</strong> <span id="totalHours">0.00</span> h</div>
          </div>
          <canvas id="streamerChart" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const rawStreamers = @json($streamers);
const rawHoras = @json($horas);

const streamerById = {};
rawStreamers.forEach(s => streamerById[s.twitch_user_id] = s);

const fullData = rawHoras.map(h => {
  const st = streamerById[h.streamer_id] || {};
  return {
    username: st.username || '-',
    profile_image_url: st.profile_image_url || '',
    date: new Date(h.date),
    hours: parseFloat(h.hours)
  };
});

function updateMonthOptions(yearSelectId, monthSelectId) {
  const year = document.getElementById(yearSelectId).value;
  const monthSelect = document.getElementById(monthSelectId);

  // Pega os meses com registros para o ano selecionado
  const mesesComRegistro = new Set(
    fullData
      .filter(item => item.date.getFullYear() == year)
      .map(item => String(item.date.getMonth() + 1).padStart(2, '0'))
  );

  // Opções fixas de meses (sem "Todos")
  const allMonths = [
    {value: "", label: "Todos"},
    {value: "01", label: "Janeiro"},
    {value: "02", label: "Fevereiro"},
    {value: "03", label: "Março"},
    {value: "04", label: "Abril"},
    {value: "05", label: "Maio"},
    {value: "06", label: "Junho"},
    {value: "07", label: "Julho"},
    {value: "08", label: "Agosto"},
    {value: "09", label: "Setembro"},
    {value: "10", label: "Outubro"},
    {value: "11", label: "Novembro"},
    {value: "12", label: "Dezembro"},
  ];

  // Limpa as opções atuais
  monthSelect.innerHTML = '';

  // Sempre adicionar a opção "Todos"
  const todosOption = document.createElement('option');
  todosOption.value = "";
  todosOption.textContent = "Todos";
  monthSelect.appendChild(todosOption);

  // Adiciona só os meses que têm registro
  allMonths.forEach(({value, label}) => {
    if (value === "") return; // já adicionamos "Todos"

    if (mesesComRegistro.has(value)) {
      const option = document.createElement('option');
      option.value = value;
      option.textContent = label;
      monthSelect.appendChild(option);
    }
  });

  // Se o valor selecionado não está mais disponível, resetar para "Todos"
  if (!mesesComRegistro.has(monthSelect.value)) {
    monthSelect.value = "";
  }
}


let currentPage = 1;
const itemsPerPage = 10;
let filteredTableData = [];

function filterData(data, month, year, streamer) {
  return data.filter(item => {
    const itemYear = item.date.getFullYear();
    const itemMonth = String(item.date.getMonth() + 1).padStart(2, '0');
    let ok = itemYear == year;
    if (ok && month) ok = itemMonth === month;
    if (ok && streamer) ok = item.username.toLowerCase().includes(streamer.toLowerCase());
    return ok;
  });
}

function buildTable(data) {
  const tbody = document.querySelector('#horasTable tbody');
  tbody.innerHTML = '';

  const totalResultados = data.length;
  const totalPaginas = Math.ceil(totalResultados / itemsPerPage);
  const start = (currentPage - 1) * itemsPerPage;
  const pageData = data.slice(start, start + itemsPerPage);

  document.getElementById('totalResultados').textContent = `» Resultados: ${totalResultados}`;
  document.getElementById('totalPaginas').textContent = `» Páginas: ${totalPaginas}`;

  const numerosPaginas = document.getElementById('numerosPaginas');
  numerosPaginas.innerHTML = '';
  for (let i = 1; i <= totalPaginas; i++) {
    const btn = document.createElement('button');
    btn.textContent = i;
    btn.className = `btn btn-sm ${i === currentPage ? 'active' : ''}`;
    btn.disabled = i === currentPage;
    btn.addEventListener('click', () => {
      currentPage = i;
      buildTable(filteredTableData);
    });
    numerosPaginas.appendChild(btn);
  }

  document.getElementById('paginaAnterior').disabled = currentPage <= 1;
  document.getElementById('proximaPagina').disabled = currentPage >= totalPaginas;

  if (!pageData.length) {
    return tbody.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum registro encontrado.</td></tr>';
  }

  pageData.forEach((item, idx) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="text-center">${start + idx + 1}</td>
      <td class="d-flex align-items-center gap-2">
        <img src="${item.profile_image_url}" width="36" height="36" class="rounded-circle shadow-sm"/>
        <strong>${item.username}</strong>
      </td>
      <td class="text-center">${item.date.toLocaleDateString('pt-BR')}</td>
      <td class="text-center">${item.hours.toFixed(2)} h</td>
    `;
    tbody.appendChild(tr);
  });
}

function getChartData(data) {
  const totals = data.reduce((acc, cur) => {
    acc[cur.username] = (acc[cur.username] || 0) + cur.hours;
    return acc;
  }, {});
  return {
    labels: Object.keys(totals),
    hours: Object.values(totals)
  };
}

function updateTotal(hours) {
  document.getElementById('totalHours').textContent = hours.toFixed(2);
}

let chart = null;
function buildChart(labels, data) {
  const ctx = document.getElementById('streamerChart').getContext('2d');
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Total de Horas',
        data,
        backgroundColor: '#1E2129',
        borderColor: '#343A40',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      },
      plugins: { legend: { display: false } }
    }
  });
}

function updateChart() {
  const month = document.getElementById('monthChartFilter').value;
  const year = document.getElementById('yearChartFilter').value;
  const streamer = document.getElementById('streamerChartFilter').value.trim();

  let filtered = filterData(fullData, month, year, streamer);

  const chartData = getChartData(filtered);
  updateTotal(chartData.hours.reduce((a, b) => a + b, 0));
  buildChart(chartData.labels, chartData.hours);
}

function updateTable() {
  const month = document.getElementById('monthTableFilter').value;
  const year = document.getElementById('yearTableFilter').value;
  const streamer = document.getElementById('streamerTableFilter').value.trim();
  const sortField = document.getElementById('sortField').value;
  const sortOrder = document.getElementById('sortOrder').value;

  filteredTableData = filterData(fullData, month, year, streamer);

  filteredTableData.sort((a, b) => {
    let valA = a[sortField];
    let valB = b[sortField];
    if (sortField === 'date') {
      valA = a.date.getTime();
      valB = b.date.getTime();
    }
    return sortOrder === 'asc' ? valA - valB : valB - valA;
  });

  currentPage = 1;
  buildTable(filteredTableData);
}

document.getElementById('paginaAnterior').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    buildTable(filteredTableData);
  }
});

document.getElementById('proximaPagina').addEventListener('click', () => {
  const totalPaginas = Math.ceil(filteredTableData.length / itemsPerPage);
  if (currentPage < totalPaginas) {
    currentPage++;
    buildTable(filteredTableData);
  }
});

document.getElementById('yearTableFilter').addEventListener('change', () => {
  updateMonthOptions('yearTableFilter', 'monthTableFilter');
  updateTable();
});

document.getElementById('yearChartFilter').addEventListener('change', () => {
  updateMonthOptions('yearChartFilter', 'monthChartFilter');
  updateChart();
});


[
  'monthTableFilter', 'yearTableFilter', 'streamerTableFilter', 'sortField', 'sortOrder',
  'monthChartFilter', 'yearChartFilter', 'streamerChartFilter'
].forEach(id => {
  document.getElementById(id).addEventListener('change', () => {
    if (id.includes('Chart')) updateChart();
    else updateTable();
  });
});

updateTable();
updateChart();
updateMonthOptions('yearTableFilter', 'monthTableFilter');
updateMonthOptions('yearChartFilter', 'monthChartFilter');

</script>

@endsection
