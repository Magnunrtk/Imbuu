@extends('template.layout')

@section('title', 'Streamer Dashboard')
@section('submenuItem', 'accountmanagement')

@section('content')

    <h3>Welcome, {{ $streamerName }}!</h3>
    <p>You are now logged into the Streamer Dashboard.</p>

    @if ($streamer->temp_coupon_code || $streamer->temp_pix_key)
        <div class="SmallBox">
            <div class="MessageContainer">
                <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                <div class="BoxFrameEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="BoxFrameEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="Message">
                    <div class="BoxFrameVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                    <div class="BoxFrameVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                    <table class="HintBox">
                        <tbody>
                            <tr>
                                <td>
                                    <p>Your requested changes are awaiting admin review. Once approved, they will be updated in your account.</p>

                                    <b>Approval Pending:</b> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul>
                                        @if ($streamer->temp_coupon_code)
                                            <li>Coupon Code: <b>{{ $streamer->temp_coupon_code }}</b></li>
                                        @endif
                                        @if ($streamer->temp_pix_key)
                                            <li>Pix Key: <b>{{ $streamer->temp_pix_key }}</b></li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
            </div>
        </div>
        <br>
    @endif

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Streamer Management</div>
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
                        <div class="InnerTableContainer">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="TableContentAndRightShadow">
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%">
                                                        <tbody>
                                                            @php $rowClass = 'Even'; @endphp
                                                            <tr class="{{ $rowClass }}"> $streamer->temp_pix_key

                                                                @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                                <tr class="{{ $rowClass }}">
                                                                    <td class="LabelV">Your Coupon Code:</td>
                                                                    <td>
                                                                        <span>{{ $streamer->coupon_code ?? 'Coupon code not registered' }}</span> 
                                                                        @if (!$streamer->coupon_code)
                                                                            <img src="{{ asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}" alt="Not Registered" style="margin-left: 3px; vertical-align: middle;">
                                                                        @endif
                                                                    </td>                                                                    
                                                                </tr>                                                                

                                                                @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                                <tr class="{{ $rowClass }}">
                                                                    <td class="LabelV">Your pix key:</td>
                                                                    <td>
                                                                       {{ $streamer->chave_pix }}
                                                                    </td>
                                                                </tr>
                            
                                                                @if (!$couponCode)
                                                                    @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                                    <tr class="{{ $rowClass }}">
                                                                        <td class="LabelV">Create Your Custom Coupon Code:</td>
                                                                        <td style="width:90%;">
                                                                            <form action="{{ route('account.manage.streamer.createCoupon') }}" method="post" style="display: flex; align-items: center; gap: 10px;">
                                                                                @csrf
                                                                                <input type="text" name="coupon_code" id="coupon_code" size="20" maxlength="20" required placeholder="New Coupon Code">

                                                                                <script>
                                                                                    const couponInput = document.getElementById('coupon_code');
                                                                                    couponInput.addEventListener('input', () => {
                                                                                        couponInput.value = couponInput.value.toUpperCase();
                                                                                    });
                                                                                </script>

                                                                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }});">
                                                                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                                        <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                        <input class="BigButtonText" type="submit" value="Create Coupon">
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tr>

                                                            @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                            <tr class="{{ $rowClass }}">
                                                                <td class="LabelV">Associate Dashboard:</td>
                                                                <td style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                                    <p style="margin: 0; flex: 1;">
                                                                        By associating your streamer dashboard, you will no longer need to enter your login credentials manually in this account.
                                                                    </p>
                                                            
                                                                    @if ($streamer->account_associate == Auth::id())
                                                                        <form method="POST" action="{{ route('account.manage.streamer.dissociateAccount') }}">
                                                                            @csrf
                                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                    <input class="BigButtonText" type="submit" value="Dissociate Account">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    @else
                                                                        <form method="POST" action="{{ route('account.manage.streamer.associateAccount') }}">
                                                                            @csrf
                                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                    <input class="BigButtonText" type="submit" value="Associate Account">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            
                                                            
                                                            @if(!$streamer->temp_pix_key)
                                                                @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                                <tr class="{{ $rowClass }}">
                                                                    <td class="LabelV">Change your pix key:</td>

                                                                    <td style="display: flex; align-items: center; justify-content: space-between; gap: 10px; white-space: nowrap;">
                                                                        <form action="{{ route('account.manage.streamer.updatePix') }}" method="post" style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                                                                            @csrf

                                                                            <input type="text" name="pix_key" id="coupon_code" size="30" maxlength="100" required style="flex-grow: 1; margin: 0;" placeholder="New Pix Key">

                                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                    <input class="BigButtonText" type="submit" value="Submit">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            @if($couponCode && $couponApproved != 0)
                                                                @php $rowClass = ($rowClass === 'Odd') ? 'Even' : 'Odd'; @endphp
                                                                <tr class="{{ $rowClass }}">
                                                                    <td class="LabelV">Change Coupon Code:</td>
                                                                    <td style="display: flex; align-items: center; justify-content: space-between; gap: 10px; white-space: nowrap;">
                                                                        <form action="{{ route('account.manage.streamer.updateCoupon') }}" method="post" style="display: flex; align-items: center; gap: 10px; flex-grow: 1;">
                                                                            @csrf

                                                                            <input type="text" name="new_coupon_code" id="new_coupon_code" size="30" maxlength="20" required 
                                                                                style="flex-grow: 1; margin: 0;" placeholder="New Coupon Code">

                                                                            <script>
                                                                                const newCouponInput = document.getElementById('new_coupon_code');
                                                                                newCouponInput.addEventListener('input', () => {
                                                                                    newCouponInput.value = newCouponInput.value.toUpperCase();
                                                                                });
                                                                            </script>
                                                                            
                                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                                    <input class="BigButtonText" type="submit" value="Submit">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                        </tbody>
                                                    </table>
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

    <br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Weekly References</div>
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
                        <div class="InnerTableContainer" style="max-width: unset;">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="InnerTableContainer">
                                                <table style="width:100%;">
                                                    <tbody>

                                                        <tr>
                                                            <label for="monthSelect">Select Month:</label>
                                                            <select id="monthSelect">
                                                                <option value="01">January</option>
                                                                <option value="02">February</option>
                                                                <option value="03">March</option>
                                                                <option value="04">April</option>
                                                                <option value="05">May</option>
                                                                <option value="06">June</option>
                                                                <option value="07">July</option>
                                                                <option value="08">August</option>
                                                                <option value="09">September</option>
                                                                <option value="10">October</option>
                                                                <option value="11">November</option>
                                                                <option value="12">December</option>
                                                            </select>
                                                            
                                                            <br><br>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <div class="TableContentContainer">
                                                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                                        <tbody id="tableBody">
                                                                            <tr class="LabelH">
                                                                                <td>Week Start</td>
                                                                                <td>Week End</td>
                                                                                <td>Processed Referrals</td>
                                                                                <td>Pending Referrals</td>
                                                                                <td>Total Earnings</td>
                                                                            </tr>
                                                                            <tr id="noRecordsRow" style="display: none;">
                                                                                <td colspan="5" style="text-align: center; font-weight: bold;">No records found</td>
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
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tableBody = document.getElementById("tableBody");
            const monthSelect = document.getElementById("monthSelect");
            const noRecordsRow = document.getElementById("noRecordsRow");
        
            function loadTableData(month) {
                fetch(`/account/manage/streamer/references-by-month?month=${month}`)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = `
                            <tr class="LabelH">
                                <td>Week Start</td>
                                <td>Week End</td>
                                <td>Processed Referrals</td>
                                <td>Pending Referrals</td>
                                <td>Total Earnings</td>
                            </tr>
                        `;
        
                        let hasRecords = false;
        
                        Object.keys(data).forEach(week => {
                            hasRecords = true;
                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td>${week}</td>
                                <td>${data[week].week_end}</td>
                                <td>${data[week].processadas}</td>
                                <td>${data[week].em_analise}</td>
                                <td>R$: ${data[week].ganhos_totais.toFixed(2).replace(".", ",")}</td>
                            `;
                            tableBody.appendChild(row);
                        });
        
                        noRecordsRow.style.display = hasRecords ? "none" : "";
                        if (!hasRecords) {
                            tableBody.appendChild(noRecordsRow);
                        }
                    })
                    .catch(error => console.error("Error loading data:", error));
            }
        
            monthSelect.addEventListener("change", function () {
                loadTableData(this.value);
            });
        
            const currentMonth = new Date().getMonth() + 1;
            monthSelect.value = currentMonth.toString().padStart(2, "0");
            loadTableData(monthSelect.value);
        });
    </script>

    <br>
        
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Monthly Earnings</div> 
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
                            <div class="InnerTableContainer" style="max-width: unset;">
                                <table style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div id="totalEarnings" style="position: absolute; font-size: 14px; margin-top: 0px; left: 10"></div>
                                                <div class="InnerTableContainer">
                                                    <canvas id="earningsChart"></canvas>
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
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch('/account/manage/streamer/monthly-earnings')
                    .then(response => response.json())
                    .then(data => {
                        const monthlyEarnings = Object.values(data.monthlyEarnings);
                        const totalEarnings = data.totalEarnings.toFixed(2);

                        document.getElementById("totalEarnings").innerText = `Total raised: R$ ${totalEarnings}`;

                        const ctx = document.getElementById("earningsChart").getContext("2d");
                        new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: [
                                    "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                ],
                                datasets: [{
                                    label: "Ganhos Mensais",
                                    data: monthlyEarnings,
                                    backgroundColor: "#D2B48C", 
                                    borderColor: "#8B4513", 
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error("Erro ao buscar os dados:", error));
            });
        </script>
         

    <br>

    <div style="display: flex; justify-content: center; padding: 10px;">
        <form action="{{ route('account.manage.streamer.logout') }}" method="post">
            @csrf
            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red.gif') }})">
                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_red_over.gif') }});"></div>
                    <input class="BigButtonText" type="submit" value="Logout">
                </div>
            </div>
        </form>    
    </div>
    


@endsection
