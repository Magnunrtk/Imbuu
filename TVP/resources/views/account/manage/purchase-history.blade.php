@extends('template.layout')

@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')

@section('content')
    <h2>Purchase History</h2>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h3 style="margin: 0;">Current Balance: <span style="color: green">{{ $currentBalance }} Ravenor coins</span></h3>

        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }});">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <button class="BigButtonText" type="button">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </div>

    <style>
        input[type="text"], input[type="number"], select {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            height: 25px; 
            width: 200px; 
            margin: 0 auto;
            padding-left: 4px;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        select{
            background-color: white;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Transaction Search</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table2" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="">
                                            <tbody>
                                                <tr bgcolor="#D4C0A1">
                                                    <td style="border: none"><b>Origin:</b></td>
                                                    <td style="border: none"><b>Description:</b></td>
                                                    <td style="border: none"><b>Coins:</b></td>
                                                </tr>

                                                <tr bgcolor="#D4C0A1">
                                                    <td style="border: none">
                                                        <select id="filter-origin">
                                                            <option value="">All</option>
                                                            <option value="In-Game">In-Game</option>
                                                            <option value="Web Get Coins">Web Get Coins</option>
                                                        </select>
                                                    </td>
                                                    
                                                    <td style="border: none">
                                                        <input type="text" id="filter-description" placeholder="Search Description">
                                                    </td style="border: none">

                                                    <td style="border: none">
                                                        <input type="number" id="filter-coins" placeholder="Exact Amount">
                                                    </td> 
                                                </tr>

                                                <tr bgcolor="#D4C0A1">
                                                    <td style="border: none"><b>Balance:</b></td>
                                                    <td style="border: none"><b>Time:</b></td>
                                                    <td style="border: none"><b>Year:</b></td>
                                                </tr>

                                                <tr>
                                                    <td style="border: none">
                                                        <input type="number" id="filter-balance" placeholder="Exact Balance">
                                                    </td>

                                                    <td style="border: none">
                                                        <input type="text" id="filter-time" placeholder="Select Date">
                                                    </td>

                                                    <td style="border: none">
                                                        <select id="filter-year">
                                                            <option value="">All Years</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="border: none;">
                                                        <br>
                                                        <div style="padding: 5px">
                                                            <div id="clear-filters" class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }});">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                    <button class="BigButtonText" type="button">
                                                                        <i class="fas fa-trash"></i> Clear Filters
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Ravenor Coins History</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table3" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"></div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>

                                    <small>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                            <div>
                                                <b>» Pages: <span id="pagination-links"></span></b>
                                            </div>
                                            <div style="margin-right: 10px">
                                                <b>» Results: <span id="total-results"></span></b>
                                            </div>
                                        </div>
                                    </small>

                                    <br>

                                    <div class="TableContentContainer">
                                        <table class="TableContent" id="coins-history-table" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                                <tr class="LabelH">
                                                    <td>Origin</td>
                                                    <td>Description</td>
                                                    <td>Coins</td>
                                                    <td>Balance</td>
                                                    <td>Time</td>
                                                </tr>
                                                <tbody id="tbody-coins-history">
                                                </tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

<script>
    const gamePurchases = @json($gamePurchases);

    function formatDescription(desc) {
        if (!desc) return 'N/A';

        if (desc.includes('transfered')) {
            const parts = desc.split(' transfered');
            const linkText = parts[0];
            const rest = ' transfered' + parts.slice(1).join(' transfered');
            const url = '/community/view/character/' + encodeURIComponent(linkText.replace(/ /g, '+'));
            return `<a href="${url}">${linkText}</a>${rest}`;
        }
        return desc;
    }

    function formatTime(time) {
        if (!time) return '';
        let dateObj;
        if (!isNaN(time)) {
            dateObj = new Date(time * 1000);
        } else {
            dateObj = new Date(time);
        }
        if (isNaN(dateObj)) return time;
        const pad = n => n.toString().padStart(2, '0');
        return `${pad(dateObj.getDate())}/${pad(dateObj.getMonth() + 1)}/${dateObj.getFullYear()} ${pad(dateObj.getHours())}:${pad(dateObj.getMinutes())}`;
    }

    function createRow(purchase, index) {
        const rowClass = (index % 2 === 0) ? 'Even' : 'Odd';
        const coinAmount = purchase.coin_amount ?? 0;
        const coinColor = coinAmount >= 0 ? 'green' : 'red';
        const coinText = coinAmount >= 0 ? '+' + coinAmount : coinAmount;
        const description = formatDescription(purchase.description ?? '');
        const timeFormatted = formatTime(purchase.time);

        return `
            <tr class="${rowClass}">
                <td class="origin">${purchase.origin ?? ''}</td>
                <td class="description">${description}</td>
                <td class="coins" style="color: ${coinColor}">${coinText}</td>
                <td class="balance">${purchase.balance_after ?? ''}</td>
                <td class="time">${timeFormatted} BRT</td>
            </tr>
        `;
    }

    const originFilter = document.getElementById('filter-origin');
    const descFilter = document.getElementById('filter-description');
    const coinFilter = document.getElementById('filter-coins');
    const balanceFilter = document.getElementById('filter-balance');
    const timeFilter = document.getElementById('filter-time');
    const yearFilter = document.getElementById('filter-year');
    const tbody = document.getElementById('tbody-coins-history');
    const paginationLinks = document.getElementById('pagination-links');
    const totalResultsSpan = document.getElementById('total-results');
    const itemsPerPage = 20;

    flatpickr("#filter-time", {
        dateFormat: "d/m/Y",
        allowInput: true
    });

    // Popula automaticamente o filtro de anos
    function populateYearFilter() {
        const years = new Set();
        for (const p of gamePurchases) {
            let d;
            if (!isNaN(p.time)) {
                d = new Date(p.time * 1000);
            } else {
                d = new Date(p.time);
            }
            if (!isNaN(d)) years.add(d.getFullYear());
        }
        const sortedYears = Array.from(years).sort((a, b) => b - a);
        for (const y of sortedYears) {
            const opt = document.createElement('option');
            opt.value = y;
            opt.textContent = y;
            yearFilter.appendChild(opt);
        }
    }

    function filterPurchases() {
        const originVal = originFilter.value.toLowerCase();
        const descVal = descFilter.value.toLowerCase();
        const coinVal = coinFilter.value;
        const balanceVal = balanceFilter.value;
        const timeVal = timeFilter.value;
        const yearVal = yearFilter.value;

        function extractDate(datetime) {
            if (!datetime) return '';
            let dt;
            if (!isNaN(datetime)) {
                dt = new Date(datetime * 1000);
            } else {
                dt = new Date(datetime);
            }
            if (isNaN(dt)) return datetime;
            const pad = n => n.toString().padStart(2, '0');
            return `${pad(dt.getDate())}/${pad(dt.getMonth() + 1)}/${dt.getFullYear()}`;
        }

        return gamePurchases.filter(purchase => {
            const origin = (purchase.origin ?? '').toLowerCase();
            const description = (purchase.description ?? '').toLowerCase();
            const coins = purchase.coin_amount?.toString() ?? '';
            const balance = purchase.balance_after?.toString() ?? '';
            const time = extractDate(purchase.time);

            if (originVal && !origin.includes(originVal)) return false;
            if (descVal && !description.includes(descVal)) return false;
            if (coinVal && !coins.includes(coinVal)) return false;
            if (balanceVal && !balance.includes(balanceVal)) return false;
            if (timeVal && timeVal !== time) return false;

            // Novo filtro por ano
            if (yearVal) {
                let d;
                if (!isNaN(purchase.time)) {
                    d = new Date(purchase.time * 1000);
                } else {
                    d = new Date(purchase.time);
                }
                if (!isNaN(d) && d.getFullYear().toString() !== yearVal) return false;
            }

            return true;
        });
    }

    let filteredPurchases = [];
    let currentPage = 1;

    function renderPage(page = 1) {
        currentPage = page;
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageItems = filteredPurchases.slice(start, end);

        tbody.innerHTML = pageItems.map((p, i) => createRow(p, i)).join('');
        renderPagination();
        totalResultsSpan.textContent = filteredPurchases.length;
    }

    function renderPagination() {
        paginationLinks.innerHTML = '';
        const totalPages = Math.ceil(filteredPurchases.length / itemsPerPage);
        for (let i = 1; i <= totalPages; i++) {
            const span = document.createElement('span');
            span.textContent = i;
            span.style.cursor = 'pointer';
            span.style.color = (i === currentPage) ? '#004294' : '#5A2800';
            span.style.fontWeight = (i === currentPage) ? 'bold' : 'normal';
            span.style.marginLeft = i === 1 ? '0' : '4px';
            span.addEventListener('click', () => renderPage(i));
            paginationLinks.appendChild(span);
        }
    }

    function applyFilters() {
        filteredPurchases = filterPurchases();
        renderPage(1);
    }

    originFilter.addEventListener('change', applyFilters);
    descFilter.addEventListener('input', applyFilters);
    coinFilter.addEventListener('input', applyFilters);
    balanceFilter.addEventListener('input', applyFilters);
    timeFilter.addEventListener('input', applyFilters);
    yearFilter.addEventListener('change', applyFilters);

    document.getElementById('clear-filters').addEventListener('click', () => {
        originFilter.value = '';
        descFilter.value = '';
        coinFilter.value = '';
        balanceFilter.value = '';
        timeFilter.value = '';
        yearFilter.value = '';
        applyFilters();
    });

    // Inicializa
    populateYearFilter();
    applyFilters();
</script>

@endsection
