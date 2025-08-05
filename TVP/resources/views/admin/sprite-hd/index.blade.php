@extends('template.layout_admin') 

@section('content')

    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <h1 class="me-3 title-custom">Sprite Converter</h1>
            <div class="preview-box ms-2">
                <img src="{{ asset('assets/images/5103.gif') }}" alt="Sprite Depois" class="preview-img">
            </div>
        </div>

        {{-- Exibe mensagens de sucesso ou erro --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p class="intro-text">
            Este sistema converte as sprites do arquivo <strong>Tibia.spr</strong> para PNG nos formatos <strong>32x32</strong> e <strong>64x64</strong>. A partir das sprites <strong>64x64</strong>, o sistema gera o arquivo final <strong>Tibia.cwm</strong>.
        </p>

        <hr class="step-divider">

        <!-- Etapa 1: Configuração -->
        <div class="mt-4">
            <h4>Etapa 1: Configuração de Exportação</h4>
            <p class="intro-text">
                Para garantir que a conversão funcione corretamente, configure a exportação no <strong>Object Builder</strong> corretamente.
                As sprites devem ser exportadas sem extensão e sem transparência, mantendo suas dimensões originais.
            </p>
            <img src="{{ asset('assets/images/setup.jpeg') }}" alt="Configuração de Exportação" class="img-fluid">
        </div>

        <hr class="step-divider">

        <!-- Etapa 2: Upload dos Arquivos -->
        <h4>Etapa 2: Enviar dos Arquivos</h4>
        <p>Envie os arquivos <strong>Tibia.dat</strong> e <strong>Tibia.spr</strong> para iniciar o processo de conversão.</p>
        
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <table class="upload-table text-center">
                <tr>
                    <td><label for="tibia_dat" class="form-label">Upload do Tibia.dat:</label></td>
                    <td><input type="file" name="tibia_dat" id="tibia_dat" class="form-control input-custom" required></td>
                </tr>
                <tr>
                    <td><label for="tibia_spr" class="form-label">Upload do Tibia.spr:</label></td>
                    <td><input type="file" name="tibia_spr" id="tibia_spr" class="form-control input-custom" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn btn-custom btn-upload">Enviar Arquivos</button>
                    </td>
                </tr>
            </table>
        </form>

        <br>

        <style>
            /* Estilo base do progress */
            #progress-bar {
              width: 50%;
              height: 20px;
              border-radius: 10px;
              overflow: hidden;
              background-color: #fff; /* Fundo branco */
              -webkit-appearance: none;
              appearance: none;
              border:1px solid rgba(0, 0, 0, 0.2);
            }
            
            /* Para navegadores WebKit */
            #progress-bar::-webkit-progress-bar {
              background-color: #fff; /* Fundo branco */
            }
            
            #progress-bar::-webkit-progress-value {
              background-color: #121A2A; /* Cor de carregamento */
              border-radius: 10px;
            }
            
            /* Para Firefox */
            #progress-bar::-moz-progress-bar {
              background-color: #121A2A; /* Cor de carregamento */
              border-radius: 10px;
            }
            </style>
        
        <div id="progresso-container">
            <p>Status: <span id="status">Desconectado</span></p>
            <p>Progresso: <span id="progresso">0</span>%</p>
            <progress id="progress-bar" value="0" max="100"></progress>
        </div>
        
        <script>
            let socket;
            
            function connect() {
                socket = new WebSocket("ws://localhost:3000");
            
                socket.onopen = function() {
                console.log("📡 Conectado ao WebSocket!");
                document.getElementById("status").innerText = "Conectado";
                };
            
                socket.onmessage = function(event) {
                const data = JSON.parse(event.data);
                document.getElementById("progresso").innerText = data.progresso;
                document.getElementById("progress-bar").value = data.progresso;
                // Atualiza o status com a mensagem recebida
                if(data.message) {
                    document.getElementById("status").innerText = data.message;
                }
                };
            
                socket.onerror = function(error) {
                console.error("Erro no WebSocket:", error);
                socket.close();
                };
            
                socket.onclose = function() {
                console.log("🔴 Conexão encerrada! Tentando reconectar...");
                document.getElementById("status").innerText = "Desconectado";
                setTimeout(connect, 3000);
                };
            }
            
            connect();
        </script>
        
        <hr class="step-divider">

        <!-- Aviso de modificação -->
        <div id="modificationNotice" style="color: red; font-weight: bold; margin: 10px 0;"></div>

            <div class="container">
                <h4>Armazenamento</h4>
                <p>Abaixo estão listados os arquivos em <code>storage</code> com sua data de modificação.</p>

                <table class="upload-table text-center">
                    <thead>
                        <tr>
                            <th class="text-center">Arquivo</th>
                            <th class="text-center">Data de Modificação</th>
                        </tr>
                    </thead>
                    <tbody id="filesTableBody">
                        {{-- Os dados serão preenchidos via JavaScript --}}
                    </tbody>
                </table>
            </div>

            <!-- Elemento de áudio para notificação sonora -->
            <audio id="notificationSound" src="/assets/beep.mp3" preload="auto"></audio>

            <!-- CSS para animação -->
            <style>
                @keyframes highlight {
                0%   { background-color: #ffffcc; }   /* amarelo bem claro */
                50%  { background-color: #ffeb3b; }   /* amarelo vibrante */
                100% { background-color: transparent; } /* volta para a cor original */
                }
                .highlight {
                    animation: highlight 3s ease-out;
                }
            </style>

            <script>
                // Guarda os dados anteriores para comparação
                let previousData = {};

                function fetchStorageData() {
                fetch("{{ route('admin.spriteHD.storageData') }}")
                    .then(response => response.json())
                    .then(data => {
                        let tbody = document.getElementById("filesTableBody");
                        tbody.innerHTML = ""; // Limpa as linhas antigas
                        let changedFiles = []; // Array para armazenar os nomes dos arquivos modificados

                        data.forEach(function(file) {
                            let tr = document.createElement("tr");

                            let tdName = document.createElement("td");
                            tdName.textContent = file.filename;
                            tr.appendChild(tdName);

                            let tdDate = document.createElement("td");
                            tdDate.textContent = file.mtime;

                            // Se houver valor anterior e ele for diferente do atual, adiciona a animação
                            if (previousData[file.filename] && previousData[file.filename] !== file.mtime) {
                                // Remove a classe se já existir, para reexecutar a animação
                                tdDate.classList.remove("highlight");
                                // Força reflow para reiniciar a animação
                                void tdDate.offsetWidth;
                                tdDate.classList.add("highlight");
                                changedFiles.push(file.filename);
                                // Remove a classe após 1 segundo (quando a animação termina)
                                setTimeout(() => {
                                    tdDate.classList.remove("highlight");
                                }, 1000);
                            }

                            // Atualiza os dados anteriores para esse arquivo
                            previousData[file.filename] = file.mtime;
                            tr.appendChild(tdDate);
                            tbody.appendChild(tr);
                        });

                        // Se houver arquivos modificados, atualiza o aviso e dispara o som
                        if (changedFiles.length > 0) {
                            document.getElementById("modificationNotice").innerText =
                                changedFiles.join(", ") + " foram modificados!";
                            
                            let audio = document.getElementById("notificationSound");
                            if (audio) {
                                audio.play().catch(e => console.error("Erro ao reproduzir som:", e));
                                // Para o áudio após 1 segundo
                                setTimeout(() => {
                                    audio.pause();
                                    audio.currentTime = 0;
                                }, 2300);
                            }
                        }
                        // Se nenhum arquivo foi modificado, a mensagem permanece até que novas alterações apareçam
                    })
                    .catch(error => console.error('Erro ao buscar os dados:', error));
                }

                // Atualiza os dados a cada 5 segundos
                fetchStorageData(); // Chamada inicial
                setInterval(fetchStorageData, 5000);

            </script>
  

            <hr class="step-divider">

            @php
                // Esses arquivos estão em storage/app/sprites e, via storage link, ficam disponíveis em public/storage/sprites
                $zip32Path = storage_path('app/sprites/png32.zip');
                $zip64Path = storage_path('app/sprites/png64.zip');
            @endphp

            <!-- Etapa 4: Download das Sprites Convertidas -->
            <h4>Etapa 4: Download das Sprites Convertidas</h4>
            <p>Baixe os arquivos PNG nos formatos 32x32 e 64x64.</p>

            <table class="upload-table text-center" style="width: 25%">
                <tr>
                    <td>
                        <a id="download32" href="{{ asset('storage/sprites/png32.zip') }}?v=0" 
                        class="btn btn-custom" style="opacity: 0.5">
                            Download PNGs (32x32)
                        </a>
                    </td>
                    <td>
                        <a id="download64" href="{{ asset('storage/sprites/png64.zip') }}?v=0" 
                        class="btn btn-custom" style="opacity: 0.5">
                            Download PNGs (64x64)
                        </a>
                    </td>
                </tr>
            </table>

            <p class="intro-text mt-2">
                Se as texturas forem baixadas no formato <strong>32x32</strong>, é obrigatório o uso de um <strong>upscale</strong> para convertê-las para <strong>64x64</strong>. Ferramentas como o modelo <strong>Real-ESRGAN</strong> podem melhorar a qualidade das texturas antes da próxima etapa.
            </p>

            <script>
            function updateDownloadLinks() {
                fetch("{{ route('admin.spriteHD.storageData') }}")
                .then(response => response.json())
                .then(data => {
                    // Procura os dados dos arquivos zip:
                    let zip32Data = data.find(file => file.filename === 'png32.zip');
                    let zip64Data = data.find(file => file.filename === 'png64.zip');
                    
                    // Obtém os elementos de link
                    let link32 = document.getElementById('download32');
                    let link64 = document.getElementById('download64');

                    // Se o arquivo existir, atualiza a href com o timestamp e define opacidade 1; senão, 0.5
                    if (zip32Data && zip32Data.mtime !== 'Não encontrado') {
                        link32.href = "{{ asset('storage/sprites/png32.zip') }}" + "?v=" + zip32Data.timestamp;
                        link32.style.opacity = 1;
                    } else {
                        link32.style.opacity = 0.5;
                    }

                    if (zip64Data && zip64Data.mtime !== 'Não encontrado') {
                        link64.href = "{{ asset('storage/sprites/png64.zip') }}" + "?v=" + zip64Data.timestamp;
                        link64.style.opacity = 1;
                    } else {
                        link64.style.opacity = 0.5;
                    }
                })
                .catch(error => console.error("Erro ao atualizar links de download:", error));
            }

            // Atualiza os links a cada 5 segundos sem recarregar a página
            updateDownloadLinks(); // Chamada inicial
            setInterval(updateDownloadLinks, 5000);
            </script>

            <hr class="step-divider">

            <!-- Etapa 5: Upload das Texturas PNG64 -->
            <h4>Etapa 5: Upload das Texturas PNG64</h4>
            
            <p class="intro-text mt-2">Envie a pasta contendo as texturas PNG aprimoradas para gerar o arquivo final <strong>Tibia.cwm</strong>. <strong>As texturas devem estar no formato 64x64.</strong></p>
            
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="upload-table">
                    <tr>
                        <td><label for="png64" class="form-label">Upload das Texturas PNG64:</label></td>
                        <td><input type="file" name="png64[]" id="png64" class="form-control input-custom" multiple></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-custom">Converter para Tibia.cwm</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#uploadForm').on('submit', function (e) {
                e.preventDefault(); // Evita o reload da página
                
                let formData = new FormData(this);
    
                $.ajax({
                    url: "{{ route('admin.spriteHD.convert') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.btn-upload').prop('disabled', true).text('Enviando...');
                    },
                    success: function (response) {
                        $('.btn-upload').prop('disabled', false).text('Enviar Arquivos');
    
                        if (response.success) {
                            $('#fileTableContainer').html(response.filesHtml); // Atualiza a tabela
                            alert('Arquivos enviados com sucesso!');
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function (xhr) {
                        $('.btn-upload').prop('disabled', false).text('Enviar Arquivos');
                        alert('Erro ao enviar os arquivos.');
                    }
                });
            });
        });
    </script>

    <br><br>

    <style>
        .title-custom {
            color: #121A2A; 
        }

        .btn-custom {
            background-color: #121A2A; 
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 200px;
        }

        .btn-custom:hover {
            background-color: #213253; 
            color: white;
        }

        .btn-container {
            text-align: center;
            padding-top: 10px;
        }

        .intro-text {
            width: 50%;
            text-align: justify;
        }

        .upload-table {
            width: 50%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2); 
            border-radius: 8px;
            padding: 20px;
        }

        .upload-table td {
            padding: 10px;
        }

        .input-custom {
            width: 350px;
        }

        .preview-box {
            width: 32px;
            height: 32px;
            padding: 2px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .preview-img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endsection
