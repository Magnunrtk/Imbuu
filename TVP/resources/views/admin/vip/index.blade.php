@extends('template.layout_admin')
@section('content')

    <style>
        input[type="text"], input[type="number"], select {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            height: 20px; 
            width: 50px; 
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        button[type="submit"] {
            width: 100px;
            background-color: #6f42c1; 
            color: #fff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            height: 20px;
        }

        button[type="submit"]:hover {
            background-color: #5a3ec8; 
        }

        #apagarTudo{
            width: 100px;
            background-color: #6f42c1; 
            color: #fff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            height: 20px;
            margin: 0 auto
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px; 
            height: 20px; 
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 20px; 
            transition: .4s;
        }

        .toggle-switch input:checked + .toggle-slider {
            background-color: #6f42c1; 
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px; 
            width: 16px;
            left: 2px; 
            bottom: 2px; 
            background-color: white;
            border-radius: 50%;
            transition: .4s;
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(20px); 
        }

        .flex-row-fluid{

            background-color: #ffffff !important;
        }

        .bloco {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            border-radius: 5px;
            z-index: 9999; 
        }

        .bloco-verde {
            background-color: green;
            color: white;
        }

        .bloco-vermelho {
            background-color: red;
            color: white;
        }

        #display {
            height: 400px;
            overflow: auto;
            border: 1px solid black;
            width: 40%;
            margin: 0 auto;
            text-align: center; 
        }

        .progress-bar {
            margin: 0 auto;
            width: 40%;
            background-color: #ddd;
            height: 20px;
            position: relative;
        }
        .progress {
            height: 100%;
            background-color: #4caf50;
            width: 0;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #000;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            10%, 90% { transform: translateX(-5px); }
            20%, 80% { transform: translateX(5px); }
            30%, 50%, 70% { transform: translateX(-5px); }
            40%, 60% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        .error-border {
            border: 1px solid red !important;
        }

        .shake {
            animation: shake 0.5s infinite; 
        }

        #displayFiles {
            height: 400px;
            overflow: auto;
            border: 1px solid black;
            width: 25%;
            margin: 0 auto;
            text-align: center; 
        }

        .icon {
            vertical-align: middle; 
            margin-right: 5px; 
            width: 50px;
        }

    </style>

    <div style="width: 40%; margin: 0 auto;">     
        <table style="border-collapse: collapse">

            <tr>
                <td style="display:flex; gap: 10px">
                    <label for="option">Selecione:</label>
                    <select id="option" onchange="toggleAccountIdInput()" style="width: 100px">
                        <option value="all">Para Todos</option>
                        <option value="accountId">Account ID</option>
                    </select>
                    <br><br>
                </td>
            </tr>

            <tr id="accountIdRow" style="display: none;">
                <td>
                    <label for="accountId">Account ID:</label>
                    <input type="number" id="accountId" name="accountId" disabled style="width: 100px" min="1">
                    <br><br>
                </td>
            </tr>

            <tr>
                <td style="display: flex; gap: 10px">
                    <label for="vipDays">Quantidade de dias Vip:</label>
                    <input type="number" id="vipDays" name="vipDays" min="1">
                    <button type="submit" id="botaoSucesso">Enviar</button>
                    <br><br>
                </td>
            </tr>

            <tr>
                <td style="display: flex; gap: 10px">
                    <label class="toggle-switch">
                        <input type="checkbox" id="toggleSwitch">
                        <div class="toggle-slider"></div>
                    </label>
                    Dias de Vip para novas contas <input id="newAccountsVip" type="number" placeholder="0" min="1">
                </td>
            </tr>

        </table>       
    </div>

    <div class="bloco bloco-verde" id="blocoSucesso">
        Adicionado com sucesso!
    </div>

    <div class="bloco bloco-vermelho" id="blocoFalha">
        Falha ao enviar!
    </div>

    <br><br>


    <div class="progress-bar">
        <div class="progress"></div>
        <div class="progress-text">0%</div>
    </div>

    <br>
    
    <div id="display"></div>

    <br><br>

    <h1 style="text-align: center">Histórico de transferências</h1>

    <div id="displayFiles">

    </div>

    <br>

    <button id="apagarTudo" style="background-color: red; color: white;">Apagar Tudo</button>

    <br><br>


    <script>

        function initNewAccounts(){

            const requestData = {
                    action: "init",
                    vipDays: 0,
                };

            fetch('/api/accounts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao enviar solicitação para a API');
                }
                return response.json();
            })
            .then(data => {

                var receivedData = JSON.parse(data["value"]);
                var newAccounts = document.getElementById('newAccountsVip');
                
                if(receivedData["status"] == "active"){

                    var toggleSwitchLocal = document.getElementById('toggleSwitch');
                    toggleSwitch.checked = true;
                    newAccounts.value = receivedData["vipDays"];
                    newAccounts.disabled = true;
                }

                console.log(receivedData["status"]);
            })
            .catch(error => {
                console.error('Erro ao enviar solicitação para a API:', error);
            });
        }

        initNewAccounts();

        function toggleAccountIdInput() {
            var option = document.getElementById('option').value;
            var accountIdRow = document.getElementById('accountIdRow');
            var accountIdInput = document.getElementById('accountId');

            if (option === 'accountId') {
                accountIdInput.disabled = false;
                accountIdRow.style.display = 'table-row';
            } else {
                accountIdInput.disabled = true;
                accountIdRow.style.display = 'none';
            }
        }

        const toggleSwitch = document.getElementById('toggleSwitch');

        toggleSwitch.addEventListener('change', function() {

            var newAccounts = document.getElementById('newAccountsVip');

            if (!this.checked) {

                newAccounts.value = 0;
                newAccounts.disabled = false;

                const requestData = {
                    action: "newAccount",
                    vipDays: 0,
                    subAction: 0
                };

                fetch('/api/accounts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao enviar solicitação para a API');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Erro ao enviar solicitação para a API:', error);
                });

            } else {

                if(newAccounts.value <= 0){

                    mostrarBlocoFalha("newAccountsVip");
                    toggleSwitch.checked = false;
                    return;
                }

                var vipDays = document.getElementById("newAccountsVip");
                vipDays.disabled = true;
                
                mostrarBlocoSucesso();
                    
                const requestData = {
                    action: "newAccount",
                    vipDays: vipDays.value,
                    subAction: 1
                };

                fetch('/api/accounts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao enviar solicitação para a API');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Erro ao enviar solicitação para a API:', error);
                });
            }
        });

        function mostrarBlocoSucesso() {
            var bloco = document.getElementById('blocoSucesso');
            bloco.style.display = 'block';
            setTimeout(function() {
                bloco.style.display = 'none';
            }, 2000); 
        }

        function mostrarBlocoFalha(object) {
            var bloco = document.getElementById('blocoFalha');
            bloco.style.display = 'block';

            var input = document.getElementById(`${object}`);
            input.classList.add('shake');

            input.classList.add('error-border');

            setTimeout(function() {
                bloco.style.display = 'none';
            }, 2000); 

            setTimeout(function() {
                input.classList.remove('shake');
                input.classList.remove('error-border');
            }, 500); 
        }


        function removeShakeEffect(element) {
            element.classList.remove('shake');
        }


        function removeErrorBorder(element) {
            element.classList.remove('error-border');
        }

        function realSend() {
            const requestData = {
                vipDays: vipDays.value,
                action: "todos" 
            };

            fetch('/api/accounts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {

                if (!response.ok) {
                    throw new Error('Erro ao buscar dados da API');
                }
                // Retorna a resposta como texto (URL do arquivo Excel)
                return response.text();

            }).catch(error => {
                console.error('Erro ao buscar dados da API:', error);
            });
        }

        function sendOne() {

            var vipDays = document.getElementById("vipDays");
            var accountId = document.getElementById("accountId");

            if(accountId.value <= 0){

                mostrarBlocoFalha("accountId");
                return;
            }

            const requestData = {
                vipDays: vipDays.value,
                action: "accountId", 
                accountId: accountId.value
            };

            fetch('/api/accounts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar dados da API');
                }

                return response.json();
            })
            .then(data => {

                mostrarBlocoSucesso();
                //console.log(data);
            })
            .catch(error => {
                console.error('Erro ao buscar dados da API:', error);
            });
        }


        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('botaoSucesso').addEventListener('click', function() {

                var vipDays = document.getElementById("vipDays");
                var selectOption = document.getElementById("option");

                if(vipDays.value <= 0){

                    mostrarBlocoFalha("vipDays");
                    return;
                }

                if(selectOption.value == "accountId"){

                    sendOne();
                    return;
                }

                mostrarBlocoSucesso();
                realSend();


                const requestData = {
                    vipDays: vipDays.value,
                    action: "estetic"
                };


                fetch('/api/accounts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar dados da API');
                    }
                    return response.json();
                })
                .then(data => {

                    
                    console.log(data);
                    let totalItems = data.length;

                    const display = document.getElementById('display');
                    const progressBar = document.querySelector('.progress');
                    const progressText = document.querySelector('.progress-text');

                    function displayDataOneByOne() {
                        let currentIndex = 0;
                        const intervalId = setInterval(() => {
                            if (currentIndex < totalItems) {
                                const newItem = document.createElement('p');
                                newItem.innerHTML = `${data[currentIndex]} <span style="color: green">Vip Adicionado Com Sucesso!</span>`;
                                display.appendChild(newItem); 

                                if (display.children.length > totalItems) {
                                    display.removeChild(display.children[0]);
                                }

                                display.scrollTop = display.scrollHeight;
                                currentIndex++;

                                const progressPercentage = (currentIndex / totalItems) * 100;
                                progressBar.style.width = `${progressPercentage}%`;
                                progressText.textContent = `${Math.round(progressPercentage)}%`;
                            } else {
                                clearInterval(intervalId);
                                carregarArquivos();
                            }

                        }, 1); 
                    }

                    displayDataOneByOne();
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da API:', error);
                });


            });

        });

        document.getElementById('apagarTudo').addEventListener('click', function() {

            const requestData = {
                action: "deleteAll",
                vipDays: 0
            };

            fetch('/api/accounts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao enviar solicitação para a API');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Erro ao enviar solicitação para a API:', error);
            });
        });

    // Função para fazer uma requisição AJAX para carregar os arquivos
    function carregarArquivos() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/vipLog/api.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var arquivosObj = JSON.parse(xhr.responseText);
                var display = document.getElementById('displayFiles');
                display.innerHTML = "";
                // Verificar se arquivosObj é um objeto
                if (typeof arquivosObj === 'object' && arquivosObj !== null) {
                    var contador = 1;
                    for (var key in arquivosObj) {
                        if (arquivosObj.hasOwnProperty(key)) {
                            var arquivo = arquivosObj[key];
                            var listItem = document.createElement('p');
                            
                            // Adiciona o número
                            var numero = document.createElement('span');
                            numero.textContent = contador + '. ';
                            listItem.appendChild(numero);

                            // Cria a imagem
                            var img = document.createElement('img');
                            img.src = '/images/xfile.png';
                            img.classList.add('icon');
                            listItem.appendChild(img);

                            // Cria o link do arquivo
                            var link = document.createElement('a');
                            link.href = '/vipLog/baixar.php?nome_arquivo=' + encodeURIComponent(arquivo);
                            link.textContent = arquivo;
                            listItem.appendChild(link);

                            // Cria a imagem do botão de exclusão
                            var deleteImg = document.createElement('img');
                            deleteImg.src = '/images/delete.png'; 
                            deleteImg.style.width = '20px';
                            deleteImg.style.marginLeft = '5px';
                            deleteImg.style.cursor = 'pointer'; 

                            deleteImg.addEventListener('click', function() {
                                deletarArquivo(arquivo);
                            });

                            listItem.appendChild(deleteImg);

                            display.appendChild(listItem);
                            contador++;
                        }
                    }
                } else {
                    console.error('A resposta da requisição não é um objeto:', arquivosObj);
                }
            } else {
                console.error('Erro ao carregar arquivos: ' + xhr.statusText);
            }
        };
        xhr.onerror = function () {
            console.error('Erro de rede ao carregar arquivos.');
        };
        xhr.send();
    }

    // Chamar a função para carregar os arquivos quando a página carregar
    window.onload = carregarArquivos;

    // Função para fazer uma requisição AJAX para deletar um arquivo
    function deletarArquivo(nomeArquivo) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/vipLog/delete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Arquivo deletado com sucesso:', nomeArquivo);
                carregarArquivos();
                // Aqui você pode fazer algo após deletar o arquivo, se necessário
            } else {
                console.error('Erro ao deletar arquivo:', xhr.statusText);
            }
        };
        xhr.onerror = function () {
            console.error('Erro de rede ao deletar arquivo.');
        };
        xhr.send('nome_arquivo=' + encodeURIComponent(nomeArquivo));
    }


    </script>

@endsection