<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Calculadora 1RM + Histórico + Gráfico</title>
<style>
  body {
    font-family: sans-serif;
    max-width: 480px;
    margin: 20px auto;
    padding: 10px;
    background: #f5f5f5;
  }
  label, select, input, button {
    display: block;
    width: 100%;
    margin-top: 10px;
    padding: 8px;
    font-size: 1rem;
    box-sizing: border-box;
  }
  #resultado {
    background: #fff;
    padding: 15px;
    margin-top: 20px;
    border-radius: 6px;
    display: none;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }
  th, td {
    border: 1px solid #ddd;
    text-align: center;
    padding: 6px;
  }
  th {
    background: #eee;
  }
  canvas {
    margin-top: 20px;
  }
</style>
</head>
<body>

<h2>Calculadora 1RM + Histórico + Gráfico</h2>

<label for="exercicio">Exercício</label>
<select id="exercicio">
  <option value="Rosca Direta">Rosca Direta</option>
  <option value="Rosca Martelo com Halteres (A)">Rosca Martelo com Halteres (A)</option>
  <option value="Tríceps Cross Over (A)">Tríceps Cross Over (A)</option>
  <option value="Tríceps Francês">Tríceps Francês</option>
  <!-- Adicione outros exercícios aqui -->
</select>

<label for="peso">Peso usado (kg):</label>
<input type="number" id="peso" placeholder="Ex: 20" min="1" step="0.1" />

<label for="reps">Repetições feitas:</label>
<input type="number" id="reps" placeholder="Ex: 10" min="1" max="36" />

<label for="formula">Fórmula de 1RM</label>
<select id="formula">
  <option value="brzycki">Brzycki</option>
  <option value="epley">Epley</option>
  <option value="oconner">O'Conner</option>
</select>

<button onclick="calcular()">Calcular 1RM</button>

<div id="resultado">
  <p><strong>1RM estimado:</strong> <span id="rm"></span> kg</p>
  <p><strong>Semana de treino:</strong> <span id="tipoSemana"></span></p>
  <p><strong>Carga de trabalho:</strong> <span id="cargaTrabalho"></span> kg</p>

  <h3>Aquecimento</h3>
  <table>
    <thead>
      <tr>
        <th>Série</th>
        <th>% do 1RM</th>
        <th>Peso (kg)</th>
        <th>Repetições</th>
      </tr>
    </thead>
    <tbody id="tabelaAquecimento"></tbody>
  </table>

  <h3>Histórico de 1RM - Exercício: <span id="nomeExercicio"></span></h3>
  <canvas id="grafico1RM" width="400" height="200"></canvas>

  <button onclick="limparHistorico()">Limpar Histórico</button>
  <button onclick="exportarHistorico()">Exportar Histórico (.json)</button>

  <label for="importarArquivo">Importar Histórico (.json):</label>
  <input type="file" id="importarArquivo" accept=".json" onchange="importarHistorico()" />

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const tabelaTreino = [
  ["Rosca Martelo com Halteres (A)", ["3x6 / 90s / 85%", "3x10 / 60s / 75%", "2x20 / 30s / 60%", "3x12 / 45s / 70%"]],
  ["Tríceps Cross Over (A)", ["3x6 / 90s / 80%", "4x10 / 60s / 70%", "2x15 / 30s / 55%", "3x12 / 45s / 65%"]],
  ["Rosca Direta", ["4x6 / 120s / 85%", "4x10 / 90s / 75%", "3x15 / 45s / 60%", "4x8 / 90s / 80%"]],
  ["Tríceps Francês", ["3x6 / 90s / 80%", "3x12 / 60s / 70%", "2x20 / 30s / 55%", "3x10 / 60s / 75%"]],
];

let chartInstance = null;

function salvarHistorico1RM(exercicio, oneRM) {
  if (!exercicio || !oneRM) return;

  const hoje = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
  let historico = JSON.parse(localStorage.getItem('historico1RM')) || {};

  if (!historico[exercicio]) {
    historico[exercicio] = [];
  }

  // Substitui ou adiciona novo 1RM para hoje
  const indexHoje = historico[exercicio].findIndex(entry => entry.data === hoje);

  if (indexHoje !== -1) {
    historico[exercicio][indexHoje].oneRM = Number(oneRM.toFixed(2));
  } else {
    historico[exercicio].push({ data: hoje, oneRM: Number(oneRM.toFixed(2)) });
  }

  localStorage.setItem('historico1RM', JSON.stringify(historico));

}

function pegarHistoricoParaGrafico(exercicio) {
  let historico = JSON.parse(localStorage.getItem('historico1RM')) || {};
  if (!historico[exercicio]) return { datas: [], valores: [] };

  historico[exercicio].sort((a, b) => new Date(a.data) - new Date(b.data));

  const datas = historico[exercicio].map(entry => entry.data);
  const valores = historico[exercicio].map(entry => entry.oneRM);

  return { datas, valores };
}

function calcular() {
  const peso = parseFloat(document.getElementById('peso').value);
  const reps = parseInt(document.getElementById('reps').value);
  const exercicio = document.getElementById('exercicio').value;
  const formula = document.getElementById('formula').value;

  if (!peso || !reps || reps >= 37) {
    alert('Preencha corretamente peso e repetições (até 36 reps)');
    return;
  }

  let oneRM;
  if (formula === 'brzycki') {
    oneRM = (peso * 36) / (37 - reps);
  } else if (formula === 'epley') {
    oneRM = peso * (1 + 0.0333 * reps);
  } else if (formula === 'oconner') {
    oneRM = peso * (1 + 0.025 * reps);
  }

  document.getElementById('rm').textContent = oneRM.toFixed(2);

  const data = new Date();
  const semanaDoMes = Math.ceil(data.getDate() / 7) - 1;
  const tipoSemanaTexto = ["Semana 1 (Força)", "Semana 2 (Hipertrofia)", "Semana 3 (Resistência)", "Semana 4 (Híbrida)"];
  document.getElementById('tipoSemana').textContent = tipoSemanaTexto[semanaDoMes % 4];

  const planos = [
    [0.5, 0.7, 0.85, 0.85],
    [0.4, 0.6, 0.8, 0.75],
    [0.2, 0.4, 0.6, 0.6],
    [0.4, 0.6, 0.8, 0.7],
  ];
  const repsAquecimento = [
    [12, 8, 3],
    [15, 10, 5],
    [15, 10, 6],
    [15, 10, 5],
  ];

  const plano = planos[semanaDoMes % 4];
  const repsAq = repsAquecimento[semanaDoMes % 4];

  let tbody = '';
  for (let i = 0; i < 3; i++) {
    tbody += `<tr>
      <td>${i + 1}</td>
      <td>${(plano[i] * 100).toFixed(0)}%</td>
      <td>${(oneRM * plano[i]).toFixed(2)}</td>
      <td>${repsAq[i]}</td>
    </tr>`;
  }
  document.getElementById('tabelaAquecimento').innerHTML = tbody;
  document.getElementById('cargaTrabalho').textContent = (oneRM * plano[3]).toFixed(2);

  salvarHistorico1RM(exercicio, oneRM);
  document.getElementById('nomeExercicio').textContent = exercicio;

  atualizarGrafico(exercicio);
  document.getElementById('resultado').style.display = 'block';
}

function atualizarGrafico(exercicio) {
  const dados = pegarHistoricoParaGrafico(exercicio);

  if (chartInstance) {
    chartInstance.destroy();
  }

  const ctx = document.getElementById('grafico1RM').getContext('2d');
  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: dados.datas,
      datasets: [{
        label: '1RM (kg)',
        data: dados.valores,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: { display: true, text: 'Data' },
          ticks: { maxRotation: 45, minRotation: 30 }
        },
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Peso (kg)' }
        }
      }
    }
  });

  // ⚠️ Força exibição do div de resultado se houver dados
  if (dados.datas.length > 0) {
    document.getElementById('resultado').style.display = 'block';
  }
}

function limparHistorico() {
  const exercicio = document.getElementById('exercicio').value;
  const confirmacao = confirm(`Você realmente quer apagar o histórico de "${exercicio}"?`);

  if (!confirmacao) return;

  let historico = JSON.parse(localStorage.getItem('historico1RM')) || {};

  if (historico[exercicio]) {
    delete historico[exercicio];
    localStorage.setItem('historico1RM', JSON.stringify(historico));
    alert(`Histórico de "${exercicio}" foi apagado.`);
    atualizarGrafico(exercicio);
  } else {
    alert('Não há histórico para esse exercício.');
  }
}

document.getElementById('exercicio').addEventListener('change', () => {
  const exercicio = document.getElementById('exercicio').value;
  document.getElementById('nomeExercicio').textContent = exercicio;
  atualizarGrafico(exercicio);
});

// Carrega gráfico e nome exercício padrão ao abrir a página
document.addEventListener('DOMContentLoaded', () => {
  const exercicio = document.getElementById('exercicio').value;
  document.getElementById('nomeExercicio').textContent = exercicio;
  atualizarGrafico(exercicio);
});

function exportarHistorico() {
  const historico = localStorage.getItem('historico1RM');
  if (!historico) {
    alert('Nenhum histórico encontrado para exportar.');
    return;
  }

  const blob = new Blob([historico], { type: 'application/json' });
  const url = URL.createObjectURL(blob);

  const link = document.createElement('a');
  link.href = url;
  link.download = 'historico_1rm.json';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
}

function importarHistorico() {
  const input = document.getElementById('importarArquivo');
  const file = input.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function (event) {
    try {
      const dados = JSON.parse(event.target.result);
      if (typeof dados !== 'object' || Array.isArray(dados)) throw new Error();

      localStorage.setItem('historico1RM', JSON.stringify(dados));
      alert('Histórico importado com sucesso!');
      const exercicio = document.getElementById('exercicio').value;
      atualizarGrafico(exercicio);
    } catch (e) {
      alert('Arquivo inválido. Certifique-se de que é um .json exportado deste programa.');
    }
  };
  reader.readAsText(file);
}

</script>

</body>
</html>
