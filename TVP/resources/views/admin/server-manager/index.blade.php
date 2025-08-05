@extends('template.layout_admin')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background: #121212;
        color: #eee;
        text-align: center;
        padding-top: 50px;
    }

    .timestamp {
        font-size: 0.9em;
        color: #aaa;
    }

    .buttons {
        margin-top: 30px;
    }

    button {
        border-radius: 2px;
        font-size: 1em;
        border-radius: 2%;
        border: none;
        cursor: pointer;
        background: #1e1e1e;
        color: white
    }

    #output {
        background: #1e1e1e;
        color: #333232;
        text-align: left;
        max-width: 800px;
        margin: 40px auto;
        padding: 15px;
        border-radius: 5px;
        height: 300px;
        overflow-y: scroll;
        font-family: monospace;
        font-size: 0.9em;
    }

    @font-face {
        font-family: 'Martel';
        src: url('/martel.ttf') format('truetype'); 
        font-weight: normal;
        font-style: normal;
    }

    .tabs {
        text-align: left;
    }

    .tab-button {
        background: #1e1e1e;
        color: #eee;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s;
    }

    .tab-button.active {
        background: #1e5744;
        color: white;
    }

    .tab-content {
        max-width: 800px;
        margin: 0 auto;
        background: #1e1e1e;
        padding: 15px;
        height: 300px;
        overflow-y: scroll;
        color: #0f0;
        font-family: monospace;
        font-size: 0.9em;
    }
        
    .tab-pane {
        display: none;
        white-space: pre-wrap;
        text-align: left;
    }

    .tab-pane.active {
        display: block;
    }

</style>

<div id="mapTitle" style="font-family: 'Martel', sans-serif; font-size: 44px; font-weight: normal; display: flex; align-items: center; justify-content: center; gap: 12px; color: #1e1e1e">
    <span>Ravenor Server Manager</span>
</div>


<div id="connection-info" style="display: none; display: flex; flex-direction: row; align-items: center; justify-content: center; font-size: 12px; text-align: center; margin: 10px auto; gap: 8px;">
    <div id="status" class="status offline" style="color: black;">Sem Conexão Com a VPS</div>
    <div id="timestamp" class="timestamp" style="color: black;"></div>
</div>

<br><br>

<div style="width: 50%; margin: 0 auto">
    <div class="tabs" style="display: flex; align-items: center; position: relative; padding: 10px;">
        <div style="display: flex; position: absolute; top: -10px; left: 0;">
            <button class="tab-button active" data-tab="server" style="padding: 6px 12px;">🖥️ Servidor</button>
            <button class="tab-button" data-tab="compiler" style="padding: 6px 12px;">🛠️ Compilador</button>
        </div>

        <div class="buttons" style="display: flex; position: absolute; top: -42px; right: 0;">
            <button onclick="sendCommand('startManual')" style="padding: 6px 12px;">▶️ Iniciar</button>
            <button onclick="sendCommand('stopManual')" style="padding: 6px 12px;">🛑 Parar</button>
            <button onclick="sendCommand('compile')" style="padding: 6px 12px;">
                <img src="/linux.png?v=2" style="width: 20px; vertical-align: middle;"> Compilar
            </button>
        </div>
    </div>


    <div class="tab-content" style="border: 3px solid #1e5744;">
        <pre id="output-server" class="tab-pane active"></pre>
        <pre id="output-compiler" class="tab-pane"></pre>
    </div>

    <div style="margin-top: 40px; border: 1px solid #333; padding: 16px; border-radius: 8px;">
        <h3 style="margin-bottom: 12px;">📅 Agendar Compilação</h3>
        <label for="scheduleDate">Data:</label>
        <input type="date" id="scheduleDate" style="margin-right: 12px; padding: 4px 8px;">
        <label for="scheduleTime">Hora (Brasília):</label>
        <input type="time" id="scheduleTime" value="06:04" disabled style="margin-right: 12px; padding: 4px 8px;">
        <button onclick="scheduleAction()" style="padding: 6px 12px;">Agendar</button>
    </div>

    <!-- Tabela de Agendamentos -->
    <div style="margin-top: 30px;">
        <h3>📋 Agendamentos Programados</h3>
        <table id="scheduleTable" style="width: 100%; margin-top: 10px; border-collapse: collapse; font-size: 0.9em;">
            <thead style="background: #1e1e1e; color: #eee;">
                <tr>
                    <th style="border: 1px solid #444; padding: 6px;">Data</th>
                    <th style="border: 1px solid #444; padding: 6px;">Hora</th>
                    <th style="border: 1px solid #444; padding: 6px;">Status</th>
                    <th style="border: 1px solid #444; padding: 6px;">Action</th>
                </tr>
            </thead>
            <tbody id="scheduleBody" style="text-align: center;"></tbody>
        </table>
    </div>

    <br><br>

    <div style="margin-top: 30px;">
        <h3>📊 Histórico de Execução por Dia</h3>
        <div id="log-container" style="max-height: 300px; overflow-y: scroll; border: 1px solid #333; padding: 10px; border-radius: 8px; font-size: 0.85em; background: #111; color: #0f0; text-align: left;"></div>
    </div>

    <br><br>

</div>

<script>
    let ws;
    let pingInterval;
    let reconnectTimeout;
    let serverIsOnline = false;

    const statusDiv = document.getElementById("status");
    const timestampDiv = document.getElementById("timestamp");
    const outputServer = document.getElementById("output-server");
    const outputCompiler = document.getElementById("output-compiler");

    function connectWebSocket() {
        ws = new WebSocket("wss://ravenor.online/ws/");

        ws.onopen = () => {
            statusDiv.textContent = "🟢 Conectado";
            statusDiv.className = "status online";
            sendCommand("status");
            ws.send(JSON.stringify({ type: "schedule", action: "list" }));
           
            setInterval(() => {
                if (ws.readyState === WebSocket.OPEN) {
                    ws.send(JSON.stringify({ action: "logs" }));
                }
            }, 1000);

            pingInterval = setInterval(() => {
                if (ws.readyState === WebSocket.OPEN) {
                    ws.send(JSON.stringify({ type: "ping" }));
                }
            }, 25000); // 25 segundos
        };

        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);

            if (data.type === 'status') {
                serverIsOnline = data.running;

                if (data.running) {
                    statusDiv.textContent = "🟢 Online";
                    statusDiv.className = "status online";
                } else {
                    statusDiv.textContent = "🔴 Offline";
                    statusDiv.className = "status offline";
                }

                timestampDiv.textContent = `Última atualização: ${new Date().toLocaleString()}`;
            }

            if (data.type === 'output' || data.type === 'error') {
                const output = data.module === 'compiler' ? outputCompiler : outputServer;
                output.insertAdjacentText('beforeend', data.data);
                output.scrollTop = output.scrollHeight;
            }

            if (data.type === "schedule") {
                if (data.action === "list" && Array.isArray(data.items)) {
                    renderScheduleTable(data.items);
                } else if (data.action === "saved") {
                    ws.send(JSON.stringify({ type: "schedule", action: "list" }));
                }
            }

            if (data.type === 'logs') {
                renderLogs(data.items);
            }

        };

        ws.onclose = () => {
            statusDiv.textContent = "❌ Desconectado";
            statusDiv.className = "status offline";
            clearInterval(pingInterval);

            reconnectTimeout = setTimeout(() => {
                connectWebSocket();
            }, 3000); 
        };

        ws.onerror = () => {
            ws.close(); 
        };
    }

    connectWebSocket();

    function clearOutputs() {
        outputServer.textContent = '';
        outputCompiler.textContent = '';
    }

    function sendCommand(cmd) {
        if (cmd === 'compile' && serverIsOnline) {
            alert("❌ Não é possível compilar enquanto o servidor está online.");
            return;
        }

        if (cmd === 'start') outputServer.textContent = '';
        else if (cmd === 'compile') outputCompiler.textContent = '';

        if (ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({ action: cmd }));
        }
    }

    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            button.classList.add('active');
            const tab = button.getAttribute('data-tab');
            document.getElementById('output-' + tab).classList.add('active');
        });
    });

    function scheduleAction() {
        const date = document.getElementById('scheduleDate').value;
        const time = document.getElementById('scheduleTime').value;

        if (!date || !time) {
            alert("⚠️ Preencha data e hora.");
            return;
        }

        const now = new Date();
        const formatter = new Intl.DateTimeFormat('pt-BR', {
            timeZone: 'America/Sao_Paulo',
            year: 'numeric', month: '2-digit', day: '2-digit',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });

        const [dataStr, horaStr] = formatter.format(now).split(', ');
        const [day, month, year] = dataStr.split('/').map(Number);
        const [hourNow, minuteNow] = horaStr.split(':').map(Number);

        const agoraBrasilia = new Date(year, month - 1, day, hourNow, minuteNow);

        const limite = new Date(year, month - 1, day, 6, 4);

        const [inputYear, inputMonth, inputDay] = date.split("-").map(Number);
        const [inputHour, inputMinute] = time.split(":").map(Number);
        const scheduled = new Date(inputYear, inputMonth - 1, inputDay, inputHour, inputMinute);

        const mesmoDia = inputYear === year && inputMonth === month && inputDay === day;

        console.log("🕒 Agora Brasília:", agoraBrasilia.toString());
        console.log("⏰ Limite        :", limite.toString());
        console.log("📅 Agendamento  :", scheduled.toString());

        if (mesmoDia && agoraBrasilia > limite) {
            alert("⛔ Após as 06:04 de hoje (Brasília) não é possível agendar.\nProcedimento padrão: fechar o servidor, compilar e iniciar manualmente.");
            return;
        }

        const payload = {
            type: "schedule",
            action: "save",
            datetime: scheduled.toISOString()
        };

        if (ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify(payload));
            alert(`✅ Agendamento enviado: ${date} às ${time} (Brasília)`);
        } else {
            alert("⚠️ WebSocket desconectado. Aguarde reconexão.");
        }
    }

    function renderScheduleTable(schedules) {
        const tbody = document.getElementById("scheduleBody");
        tbody.innerHTML = "";

        schedules.forEach(item => {
            const dateObj = new Date(item.datetime);
            const brDate = dateObj.toLocaleDateString("pt-BR");
            const brTime = dateObj.toLocaleTimeString("pt-BR", { hour: '2-digit', minute: '2-digit' });
            const status = dateObj > new Date() ? "⏳ Aguardando" : "✅ Executado";

            const row = document.createElement("tr");
            row.innerHTML = `
                <td style="border: 1px solid #444; padding: 6px; color: black">${brDate}</td>
                <td style="border: 1px solid #444; padding: 6px; color: black">${brTime}</td>
                <td style="border: 1px solid #444; padding: 6px; color: black">${status}</td>
                <td style="border: 1px solid #444; padding: 6px; cursor: pointer; color: red; font-weight: bold;">❌</td>
            `;

            row.lastElementChild.addEventListener("click", () => {
                if (confirm(`Excluir agendamento de ${brDate} às ${brTime}?`)) {
                    if (ws.readyState === WebSocket.OPEN) {
                        ws.send(JSON.stringify({
                            type: "schedule",
                            action: "delete",
                            datetime: item.datetime
                        }));
                    }
                }
            });

            tbody.appendChild(row);
        });
    }

    function renderLogs(logsPorDia) {
        const container = document.getElementById("log-container");
        container.innerHTML = "";

        const dias = Object.keys(logsPorDia).sort().reverse(); // mostra os dias mais recentes primeiro

        dias.forEach(dia => {
            const registros = logsPorDia[dia];
            const divDia = document.createElement("div");

            divDia.innerHTML = `<strong style="color: #6cf;">📅 ${dia}</strong><br>`;

            registros.forEach(reg => {
                const ini    = new Date(reg.inicio).toLocaleTimeString("pt-BR");
                const fim    = new Date(reg.fim).toLocaleTimeString("pt-BR");
                const status = reg.status === 'ativo'
                    ? '<span style="color:#2ecc71;">● ATIVO</span>'
                    : '<span style="color:#e74c3c;">● INATIVO</span>';

                divDia.innerHTML += `${status} ${ini} → ${fim} | ⏱️ ${reg.duracao_formatada}<br>`;
            });

            divDia.innerHTML += "<br>";
            container.appendChild(divDia);
        });
    }

</script>


@endsection