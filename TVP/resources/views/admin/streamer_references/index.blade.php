@extends('template.layout_admin')

@section('content')

    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .hidden-rows {
            display: none;
        }

        .btn-success {
            padding: 5px 10px;
            font-size: 14px;
        }

        .nav-tabs .nav-link {
            background-color: #121A2A;
            color: white;
            border: none;
            padding: 10px 20px;
            transition: background 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background-color: #1E2A3A;
            cursor: pointer;
        }

        .nav-tabs .nav-link.active {
            background-color: #223d63;
            color: white;
            font-weight: bold;
        }

        .btn-enviar {
            background-color: #121A2A !important;
            border-color: #121A2A !important;
            color: white !important;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease;
        }

        .btn-enviar:hover {
            background-color: #1D2A4A !important; 
            border-color: #1D2A4A !important;
            transform: scale(1.05); 
        }

        .alert-info-custom {
            color: #ffffff; 
            background-color: #2d436f; 
            border-color: #0E1624;
        }

        .tab-content{

            margin-top: -5px;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        
    <div class="container mt-4">

        <ul class="nav nav-tabs" id="streamerTabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab-cadastro" onclick="showSection('cadastro')">
                    <i class="fa-solid fa-user-plus"></i> Cadastro de Streamers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-payments" onclick="showSection('payments')">
                    <i class="fa-solid fa-money-bill-wave"></i> Pagamentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-registrados" onclick="showSection('registrados')">
                    <i class="fa-solid fa-users"></i> Streamers Registrados
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-aprovacao" onclick="showSection('aprovacao')">
                    <i class="fa-solid fa-user-check"></i> Aprovações de Streamers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-historico" onclick="showSection('historico')">
                    <i class="fa-solid fa-clock-rotate-left"></i> Histórico de Pagamentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-referencias" onclick="showSection('referencias')">
                    <i class="fa-solid fa-tags"></i> Referências Gerais
                </a>
            </li>            
        </ul>        

        <div id="cadastro-section" class="tab-content">

            <div class="alert alert-info-custom">
                <p><strong>Informações sobre cadastro:</strong></p>
                <ul>
                    <li>Este formulário é utilizado para <strong>adicionar novos streamers</strong> ao sistema.</li>
                    <li>Certifique-se de preencher corretamente todas as informações, incluindo nome, e-mail, URL da live e chave Pix.</li>
                    <li>A chave Pix será utilizada como registro para realizar os pagamentos ao streamer.</li>
                    <li>O <strong>e-mail do streamer deve ser válido</strong>, pois ele receberá um código de acesso exclusivo ao Dashboard.</li>
                    <li>Após o cadastro, o streamer será listado na aba de <strong>Streamers Registrados</strong>.</li>
                </ul>
            </div>
            
            <br>

            <div class="card-body">
                <form action="{{ route('admin.streamers.store') }}" method="POST">
                    @csrf
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="fas fa-user"></i> Nome do Streamer</th>
                                <th><i class="fas fa-envelope"></i> E-mail</th>
                                <th><i class="fas fa-video"></i> URL da Live</th>
                                <th><i class="fas fa-key"></i> Chave Pix</th>
                                <th><i class="fas fa-cogs"></i> Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2">
                                    <input type="text" id="streamer-name" name="name" class="form-control" placeholder="Digite o nome" required>
                                </td>
                                <td class="p-2">
                                    <input type="email" id="streamer-email" name="email" class="form-control" placeholder="Digite o e-mail" required>
                                </td>
                                <td class="p-2">
                                    <input type="url" id="streamer-url" name="url" class="form-control" placeholder="Cole a URL da live" required>
                                </td>
                                <td class="p-2">
                                    <input type="text" id="streamer-pix" name="pix_key" class="form-control" placeholder="Informe a chave Pix" required>
                                </td>
                                <td class="text-center p-2 align-middle">
                                    <button type="submit" class="btn btn-enviar">
                                        <i class="fas fa-plus-circle"></i> Cadastrar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
 
        <div id="payments-section" class="tab-content" style="display: none;">

            <div class="alert alert-info-custom" role="alert">
                <p><strong>Informações sobre os pagamentos:</strong></p>
                <ul>
                    <li>Os valores são atualizados <strong>apenas quando o bônus é adicionado</strong>.</li>
                    <li>Após a expansão os valores listados em <strong>Preço Base</strong> no topo são a somatória total das referências do streamer.</li>
                    <li>O valor em <strong>Total a Pagar</strong> é baseado na porcentagem do bônus, sem interferência da taxa de câmbio.</li>
                    <li>A <strong>Taxa de Câmbio</strong> afeta apenas pagamentos via Stripe e representa a cotação do dólar.</li>
                    <li>Após realizar o pagamento e clicar em <strong>“Enviar Todos”</strong>, todas as referências daquele streamer serão marcadas como pagas.</li>
                    <li>Também é possível pagar referências individuais ao invés do total.</li>
                </ul>
            </div>

            <div class="alert alert-warning-custom" role="alert" style="width: 50%">
                <div>
                    <p><strong>Configuração do Desconto para Jogadores:</strong></p>
                    <p>Os jogadores que utilizarem os cupons dos streamers receberão um desconto baseado na porcentagem definida abaixo. Esse desconto será aplicado ao valor total dos produtos na loja.</p>
                </div>
            
                <div class="mb-3">
                    <strong>Valor Atual do Desconto: </strong><span id="current-discount">%</span>
                </div>
            
                <div class="d-flex align-items-center">
                    <label for="player-discount" class="form-label me-2 mb-0"><strong>Atualizar Porcentagem de Desconto (%):</strong></label>
                    <input type="number" id="player-discount" class="form-control w-25" value="0" min="0" max="100" step="0.01" style="width: 80px !important">
                    
                    <button class="btn btn-primary ms-3" onclick="updateDiscount()">
                        <i class="fas fa-paper-plane me-1"></i> Enviar
                    </button>
                </div>
            </div>
            
            <script>

                function loadCurrentDiscount() {
                    fetch('/admin/streamers/getCurrentDiscount', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('current-discount').innerText = `${data.discount}%`;
                    })
                    .catch(error => console.error('Erro ao carregar o valor atual do desconto:', error));
                }
            
                function updateDiscount() {
                    let discountValue = document.getElementById('player-discount').value;
                    
                    fetch('/admin/streamers/updateDiscount', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ coupon_discount: discountValue })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        loadCurrentDiscount();
                    })
                    .catch(error => console.error('Erro ao atualizar desconto:', error));
                }

                window.onload = loadCurrentDiscount;
            </script>
            

            {{-- /admin/streamer-references/update-status --}}

            <br>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="bonus-percentage" class="form-label">Bônus (%):</label>
                    <input type="number" id="bonus-percentage" class="form-control" value="0" min="0" max="100" step="0.01" onchange="updateBonus()">
                </div>
                <div class="col-md-6">
                    <label for="dollar-rate" class="form-label">Taxa de Câmbio (Dólar):</label>
                    <input type="number" id="dollar-rate" class="form-control" value="5" min="0.01" step="0.01" onchange="updateBonus()">
                </div>
            </div>

            <table class="table table-hover table-bordered" id="streamer-table">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-user me-1"></i>Streamer</th>
                        <th><i class="fas fa-signal me-1"></i>Status</th>
                        <th><i class="fas fa-receipt me-1"></i>Order ID</th>
                        <th><i class="fas fa-id-badge me-1"></i>Account ID</th>
                        <th><i class="fas fa-tag me-1"></i>Base Price</th>
                        <th><i class="fas fa-dollar-sign me-1"></i>Payment Value</th>
                        <th><i class="fas fa-tools me-1"></i>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currentStreamerId = null; @endphp

                    @foreach($streamerReferences as $reference)
                        @if($currentStreamerId !== $reference->streamer_id)
                            @php
                                $currentStreamerId = $reference->streamer_id;
                                $streamerName = DB::table('streamers')->where('id', $currentStreamerId)->value('name');
                                $count = $reference->count;
                            @endphp
                            <tr class="table-primary clickable-row" data-streamer-id="{{ $reference->streamer_id }}">
                                <td><strong>{{ $streamerName }}</strong> ({{ $count }})</td>
                                <td colspan="6">
                                    <button type="button" class="btn btn-link toggle-rows">Expandir</button>
                                </td>
                            </tr>
                            <tr class="table-secondary hidden-rows" data-streamer-id="{{ $currentStreamerId }}">
                                <td colspan="6">
                                    <strong>Preço Base:</strong> <span class="total-value">R${{ number_format(0, 2) }}</span>
                                    <br>
                                    <strong>Total A Pagar:</strong> <span class="total-payment-value">R$0.00</span> 
                                    <br>
                                    <strong>Chave Pix:</strong> <span class="total-payment-value">{{ $reference->chave_pix }}</span> 
                                </td>
                                <td>
                                    <button type="button" class="btn btn-enviar" onclick="submitAllReferences({{ $currentStreamerId }})">
                                        <i class="fas fa-paper-plane me-1"></i> Enviar Todos
                                    </button>
                                </td>
                            </tr>
                        @endif
                        
                        @foreach($streamersDetails->where('streamer_id', $currentStreamerId) as $subReference)
                            @php
                                $subTotalPrice = $orderPrices[$subReference->order_id] ?? 0;
                                $isOrderIdContainsLetters = preg_match('/[a-zA-Z]/', $subReference->order_id);
                                $currencySymbol = $isOrderIdContainsLetters ? 'USD$' : 'R$'; 
                            @endphp
                            <tr class="hidden-rows" data-streamer-id="{{ $subReference->streamer_id }}" data-order-id="{{ $subReference->order_id }}">
                                <td></td>
                                <td>Aguardando Aprovação</td>
                                <td>{{ $subReference->order_id }}</td>
                                <td>{{ $subReference->account_id }}</td>
                                <td class="base-price">{{ $currencySymbol }}{{ number_format($subTotalPrice, 2) }}</td>
                                <td class="individual-payment-value" data-order-id="{{ $subReference->order_id }}">
                                    <strong> -- </strong>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-enviar" onclick="submitReference({{ $subReference->id }}, '{{ $subReference->order_id }}')">
                                        <i class="fas fa-paper-plane me-1"></i> Enviar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="registrados-section" class="tab-content" style="display: none;">

            <div class="alert alert-info-custom p-3">

                <p><strong>Informações sobre registro:</strong></p>

                <ul>
                    <li>Esta seção lista todos os streamers cadastrados no sistema.</li>
                    <li>É possível editar as informações dos streamers conforme necessário.</li>
                    <li>Também é possível excluir um streamer.</li>
                </ul>
            </div>

            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-user me-1"></i>Nome</th>
                        <th><i class="fas fa-envelope me-1"></i>E-mail</th>
                        <th><i class="fas fa-video me-1"></i>URL da Live</th>
                        <th><i class="fas fa-key me-1"></i>Chave Pix</th>
                        <th><i class="fas fa-cogs me-1"></i>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($streamers as $streamer)
                    <tr id="streamer-row-{{ $streamer->id }}">
                        <td>{{ $streamer->name }}</td>
                        <td>{{ $streamer->email }}</td>
                        <td>
                            <a href="{{ $streamer->url }}" target="_blank">
                                {{ $streamer->url }}
                            </a>
                        </td>
                        <td>{{ $streamer->chave_pix }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteStreamer({{ $streamer->id }})">
                                <i class="fas fa-trash me-1"></i> Deletar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>                      
        </div>
        
        <div id="aprovacao-section" class="tab-content" style="display: none;">
            <div class="alert alert-info-custom p-3">

                <p><strong>Informações sobre Aprovações:</strong></p>

                <ul>
                    <li>Esta seção exibe streamers que aguardam aprovação.</li>
                    <li>Você pode aprovar ou rejeitar cupons e chaves Pix.</li>
                    <li>A opção de apagar linha é apenas um efeito visual.</li>
                </ul>
            </div>

            <style>
                .toggle-switch {
                    position: relative;
                    display: inline-block;
                    width: 50px;
                    height: 26px;
                }

                .toggle-switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }

                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    border-radius: 26px;
                    transition: 0.4s;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 20px;
                    width: 20px;
                    left: 3px;
                    bottom: 3px;
                    background-color: white;
                    border-radius: 50%;
                    transition: 0.4s;
                }

                input:checked + .slider {
                    background-color: #4CAF50;
                }

                input:checked + .slider:before {
                    transform: translateX(24px);
                }
            </style>

            <div id="toggleContainer"></div> 

            <script>

                document.addEventListener("DOMContentLoaded", function () {
                    const toggleContainer = document.getElementById("toggleContainer");

                    const wrapper = document.createElement("div");
                    wrapper.style.display = "flex";
                    wrapper.style.alignItems = "center";
                    wrapper.style.gap = "10px";

                    const label = document.createElement("label");
                    label.classList.add("toggle-switch");

                    const input = document.createElement("input");
                    input.type = "checkbox";
                    input.id = "autoRemoveRow";

                    const slider = document.createElement("span");
                    slider.classList.add("slider");

                    const labelText = document.createElement("span");
                    labelText.textContent = "Apagar linha após aprovações/rejeições?";

                    label.appendChild(input);
                    label.appendChild(slider);
                    wrapper.appendChild(label);
                    wrapper.appendChild(labelText);
                    toggleContainer.appendChild(wrapper); 

                    input.checked = localStorage.getItem("autoRemoveRow") === "true";

                    input.addEventListener("change", function () {
                        localStorage.setItem("autoRemoveRow", this.checked);
                    });
                });

            </script>
        
            <table id="testex" class="table table-hover table-bordered" style="margin-top: 10px">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-user me-1"></i>Nome</th>
                        <th><i class="fas fa-envelope me-1"></i>E-mail</th>
                        <th><i class="fas fa-video me-1"></i>URL da Live</th>
                        <th><i class="fas fa-ticket-alt me-1"></i>Cupom</th>
                        <th><i class="fas fa-cog me-1"></i>Ações do Cupom</th>
                        <th><i class="fas fa-key me-1"></i>Chave Pix</th>
                        <th><i class="fas fa-cog me-1"></i>Ações da Chave Pix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingApprovals as $streamer) 
                        <tr id="streamer-row-{{ $streamer->id }}">
                            <td>{{ $streamer->name }}</td>
                            <td>{{ $streamer->email }}</td>
                            <td>
                                <a href="{{ $streamer->url }}" target="_blank">{{ $streamer->url }}</a>
                            </td>
                            <td id="coupon-status-{{ $streamer->id }}">
                                {{ $streamer->temp_coupon_code ?? 'N/A' }}
                            </td>
                            <td id="coupon-actions-{{ $streamer->id }}">
                                @if($streamer->temp_coupon_code && !$streamer->coupon_approved)
                                    <button class="btn btn-success btn-sm" onclick="updateStreamerStatus({{ $streamer->id }}, 'approve_coupon', this)">
                                        <i class="fa-solid fa-check"></i> Aprovar
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStreamerStatus({{ $streamer->id }}, 'reject_coupon', this)">
                                        <i class="fa-solid fa-xmark"></i> Rejeitar
                                    </button>                                
                                @else
                                    <span class="badge bg-success">Aprovado</span>
                                @endif
                            </td>
                            <td id="pix-status-{{ $streamer->id }}">
                                {{ $streamer->temp_pix_key ?? 'N/A' }}
                            </td>
                            <td id="pix-actions-{{ $streamer->id }}">
                                @if(!$streamer->chave_pix_approved)
                                    <button class="btn btn-success btn-sm" onclick="updateStreamerStatus({{ $streamer->id }}, 'approve_pix', this)">
                                        <i class="fa-solid fa-check"></i> Aprovar
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStreamerStatus({{ $streamer->id }}, 'reject_pix', this)">
                                        <i class="fa-solid fa-xmark"></i> Rejeitar
                                    </button>                                
                                @else
                                    <span class="badge bg-success">Aprovado</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>                              
            </table>
        </div>        
        
    <script>

        function updateStreamerStatus(streamerId, action, buttonElement) {
            let actionText = '';
            let url = '';

            switch (action) {
                case 'approve_coupon':
                    actionText = 'aprovar este cupom';
                    url = `/admin/streamers/approve/coupon/${streamerId}`;
                    break;
                case 'reject_coupon':
                    actionText = 'rejeitar este cupom';
                    url = `/admin/streamers/reject/coupon/${streamerId}`;
                    break;
                case 'approve_pix':
                    actionText = 'aprovar esta chave Pix';
                    url = `/admin/streamers/approve/pix/${streamerId}`;
                    break;
                case 'reject_pix':
                    actionText = 'rejeitar esta chave Pix';
                    url = `/admin/streamers/reject/pix/${streamerId}`;
                    break;
                default:
                    console.error('Ação inválida!');
                    return;
            }

            if (!confirm(`Tem certeza que deseja ${actionText}?`)) {
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);

                let row = buttonElement.closest("tr");
                if (!row) {
                    console.error(`Linha do streamer ${streamerId} não encontrada.`);
                    return;
                }

                let couponActions = row.querySelector(`#coupon-actions-${streamerId}`);
                let pixActions = row.querySelector(`#pix-actions-${streamerId}`);

                if (action === 'approve_coupon' && couponActions) {
                    couponActions.innerHTML = '<span class="badge bg-success">Aprovado</span>';
                } 
                if (action === 'approve_pix' && pixActions) {
                    pixActions.innerHTML = '<span class="badge bg-success">Aprovado</span>';
                }
                if (action === 'reject_coupon' && couponActions) {
                    couponActions.innerHTML = '<span class="badge bg-danger">Rejeitado</span>';
                }
                if (action === 'reject_pix' && pixActions) {
                    pixActions.innerHTML = '<span class="badge bg-danger">Rejeitado</span>';
                }

                autoRemove = document.getElementById("autoRemoveRow").checked;

                let couponResolved = couponActions.innerHTML.includes('Aprovado') || couponActions.innerHTML.includes('Rejeitado');
                let pixResolved = pixActions.innerHTML.includes('Aprovado') || pixActions.innerHTML.includes('Rejeitado');

                if (autoRemove && couponResolved && pixResolved) {
                    console.log(`Removendo linha do streamer ID ${streamerId}`);
                    setTimeout(() => {
                        if (row && row.parentNode) {
                            row.parentNode.removeChild(row);
                        }
                    }, 100);
                }
            })
            .catch(error => console.error('Erro ao atualizar status:', error));
        }

        //

        function deleteStreamer(streamerId) {
            if (!confirm("Tem certeza que deseja deletar este streamer?")) {
                return;
            }

            fetch(`/admin/streamers/delete/${streamerId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById(`streamer-row-${streamerId}`).remove(); 
            })
            .catch(error => console.error('Erro ao deletar streamer:', error));
        }


        function showSection(section) {

            document.getElementById('cadastro-section').style.display = 'none';
            document.getElementById('payments-section').style.display = 'none';
            document.getElementById('registrados-section').style.display = 'none';
            document.getElementById('aprovacao-section').style.display = 'none';

            document.getElementById('tab-cadastro').classList.remove('active');
            document.getElementById('tab-payments').classList.remove('active');
            document.getElementById('tab-registrados').classList.remove('active');
            document.getElementById('tab-aprovacao').classList.remove('active');

            document.getElementById(section + '-section').style.display = 'block';
            document.getElementById('tab-' + section).classList.add('active');
        }
    </script>

    <script>
        function submitReference(referenceId, orderId) {
            const bonusElement = document.querySelector(`.individual-payment-value[data-order-id="${orderId}"] strong`);
            
            let bonusValue = bonusElement ? parseFloat(bonusElement.textContent.replace(/[^0-9.-]+/g, "")) : NaN;

            if (isNaN(bonusValue) || bonusValue <= 0) {
                alert("Erro: O valor do bônus deve ser maior que zero.");
                return; 
            }

            fetch("/admin/streamer-references/update-status", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ 
                    order_id: orderId,
                    value: bonusValue 
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Pedido enviado com sucesso!");
                    updateTable();
                } else {
                    alert("Erro ao enviar o pedido. Tente novamente.");
                }
            })
            .catch(error => {
                console.error("Erro ao enviar a referência:", error);
                alert("Erro ao processar a solicitação. Tente novamente.");
            });
        }

        function updateTable() {
            fetch("/admin/streamer-references/get-updated-data", {
                method: "GET",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro na resposta da rede");
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.querySelector("#streamer-table tbody");
                tableBody.innerHTML = "";
                document.getElementById("streamer-table").style.display = "";

                const streamerMap = {};

                data.streamerReferences.forEach(reference => {
                    const streamerId = reference.id;
                    const streamerName = reference.streamerName;
                    const chavePix = reference.chave_pix || "--";

                    if (!streamerMap[streamerName]) {
                        streamerMap[streamerName] = {
                            name: streamerName,
                            streamerId: streamerId,
                            chavePix: chavePix,
                            details: []
                        };
                    }

                    streamerMap[streamerName].details.push(reference);
                });

                Object.keys(streamerMap).forEach(streamerName => {
                    const streamer = streamerMap[streamerName];

                    const detailRows = streamer.details.map((detail, index) => {

                        const price = parseFloat(data.orderPrices[detail.order_id]) || 0;
                        const prefix = /[a-zA-Z]/.test(detail.order_id) ? "USD$" : "R$";

                        console.log('orderPrices', data.orderPrices);
                        console.log('detail', streamer.details);

                        return `
                            <tr class="detail-row hidden-rows" data-streamer-id="${streamer.streamerId}" id="detail-row-${streamer.name}-${index}">
                                <td></td>
                                <td>${detail.status || "Aguardando Aprovação"}</td>
                                <td>${detail.order_id}</td>
                                <td>${detail.account_id}</td>
                                <td class="base-price">${prefix}${price.toFixed(2)}</td>
                                <td class="individual-payment-value" data-order-id="${detail.order_id}"><strong> -- </strong></td>
                                <td>
                                    <button type="button" class="btn btn-enviar" onclick="submitReference(${detail.id}, '${detail.order_id}')"><i class="fas fa-paper-plane me-1"></i> Enviar</button>
                                </td>
                            </tr>
                        `;
                    }).join("");

                    const row = `
                        <tr class="clickable-row" data-streamer-id="${streamer.streamerId}" data-streamer-name="${streamer.name}">
                            <td>${streamer.name} (${streamer.details.length})</td>
                            <td colspan="6">
                                <button type="button" class="btn btn-link toggle-rows">Expandir</button>
                            </td>
                        </tr>
                        <tr class="hidden-rows" data-streamer-id="${streamer.streamerId}" data-streamer-name="${streamer.name}">
                            <td colspan="6">
                                <strong>Preço Base:</strong> <span class="total-value">R$0.00</span>
                                <br>
                                <strong>Total A Pagar:</strong> <span class="total-payment-value">R$0.00</span> 
                                <br>
                                <strong>Chave Pix:</strong> <span>${streamer.chavePix}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-enviar" onclick="submitAllReferences(${streamer.streamerId})"><i class="fas fa-paper-plane me-1"></i> Enviar Todos</button>
                            </td>
                        </tr>
                        ${detailRows}
                    `;

                    tableBody.insertAdjacentHTML("beforeend", row);
                });

                document.querySelectorAll(".toggle-rows").forEach(button => {
                    button.addEventListener("click", function () {
                        const parentRow = this.closest("tr");
                        const streamerId = parentRow.getAttribute("data-streamer-id");
                        const detailRows = document.querySelectorAll(`.detail-row[data-streamer-id="${streamerId}"]`);
                        const summaryRow = parentRow.nextElementSibling;

                        if (detailRows.length > 0) {
                            detailRows.forEach(row => {
                                row.classList.toggle("hidden-rows");
                            });
                            if (summaryRow) {
                                summaryRow.classList.toggle("hidden-rows");
                            }
                        }
                    });
                });
            })
            .catch(error => {
                console.error("Erro ao atualizar a tabela:", error);
            });
        }

        updateTable();

        function submitAllReferences(streamerId) {
            alert("All references for Streamer ID " + streamerId + " submitted successfully!");
        }

        function updateBonus() {
            const bonusPercentage = parseFloat(document.getElementById("bonus-percentage").value) / 100;
            const dollarRate = parseFloat(document.getElementById("dollar-rate").value);
            const streamerRows = document.querySelectorAll(".detail-row:not(.hidden-rows)");
            const streamerTotals = {};

            streamerRows.forEach(row => {
                const streamerId = row.getAttribute("data-streamer-id");
                const basePriceEl = row.querySelector(".base-price");
                const paymentValueEl = row.querySelector(".individual-payment-value strong");

                if (basePriceEl && paymentValueEl) {
                    let basePrice = parseFloat(basePriceEl.textContent.replace(/[^0-9.-]+/g, ""));
                    const orderId = row.querySelector("td:nth-child(3)").textContent;
                    const containsLetters = /[a-zA-Z]/.test(orderId);

                    if (containsLetters) {
                        basePrice *= dollarRate;
                    }

                    const paymentValue = basePrice * bonusPercentage;

                    if (!streamerTotals[streamerId]) {
                        streamerTotals[streamerId] = { totalBase: 0, totalPayment: 0 };
                    }

                    streamerTotals[streamerId].totalBase += basePrice;
                    streamerTotals[streamerId].totalPayment += paymentValue;
                    paymentValueEl.textContent = `R$${paymentValue.toFixed(2)}`;
                }
            });

            Object.keys(streamerTotals).forEach(streamerId => {
                const totalPaymentRow = document.querySelector(`.clickable-row[data-streamer-id="${streamerId}"]`).nextElementSibling;
                const totalPaymentValueEl = totalPaymentRow.querySelector(".total-payment-value");
                const totalValueEl = totalPaymentRow.querySelector(".total-value");

                if (totalPaymentValueEl && totalValueEl) {
                    totalPaymentValueEl.textContent = `R$${streamerTotals[streamerId].totalPayment.toFixed(2)}`;
                    totalValueEl.textContent = `R$${streamerTotals[streamerId].totalBase.toFixed(2)}`;
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const toggleRows = document.querySelectorAll(".toggle-rows");

            toggleRows.forEach(button => {
                button.addEventListener("click", function () {
                    const streamerId = this.closest("tr").dataset.streamerId;
                    const rows = document.querySelectorAll(`.hidden-rows[data-streamer-id="${streamerId}"]`);

                    rows.forEach(row => {
                        row.style.display = row.style.display === "table-row" ? "none" : "table-row";
                    });
                });
            });
        });

        function submitAllReferences(streamerId) {
            console.log("Streamer ID:", streamerId);
            const rows = document.querySelectorAll(`.detail-row[data-streamer-id="${streamerId}"]`);
            const references = [];

            rows.forEach(row => {
                const orderId = row.querySelector("td:nth-child(3)").textContent.trim();
                const bonusElement = row.querySelector(".individual-payment-value strong");
                let bonusValue = bonusElement ? parseFloat(bonusElement.textContent.replace(/[^0-9.-]+/g, "")) : NaN;

                if (!isNaN(bonusValue) && bonusValue > 0) {
                    references.push({ order_id: orderId, value: bonusValue });
                }
            });

            if (references.length === 0) {
                alert("Nenhuma referência válida para envio.");
                return;
            }

            fetch("/admin/streamer-references/submit-multiple", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ references })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Todas as referências enviadas com sucesso!");
                    updateTable();
                } else {
                    alert("Erro ao enviar as referências. Tente novamente.");
                }
            })
            .catch(error => {
                console.error("Erro ao processar a solicitação:", error);
                alert("Erro ao processar a solicitação. Tente novamente.");
            });
        }

    </script>

@endsection
