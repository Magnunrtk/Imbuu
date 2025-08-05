@extends('template.layout')
@section('title', 'Powergamers')
@section('submenuItem', 'powergamers')
@section('content')

    <style>
        input[type="text"], input[type="number"], select {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            height: 25px; 
            width: 160px; 
            margin: 0 auto;
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

    <h3>Track Your Progress!</h3>

    PowerGamers lets you monitor level and experience gains over a period of up to seven days. Keep an eye on your progress, compare achievements, and see how far you’ve come on your journey!

    <div style="padding: 15px"></div>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Powergamers list</span>
                </div>
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
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;" id="LastBansTable">
                            <tbody>

                                <tr>
                                    <td class="PageNavigation">
                                        <div style="padding: 3px"></div>
                                    
                                        <small>
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                                <div>
                                                    <b>» Pages: <span id="pagination-links"></span></b>
                                                </div>
                                                <div>
                                                    <b>» Results: <span id="total-results"></span></b>
                                                </div>
                                            </div>
                                        </small>

                                        <div style="margin-top: 10px;">
                                            <small>
                                                <label for="profession"><b>Vocation:</b></label>
                                                <select name="profession" id="profession" autocomplete="off">
                                                </select>
                                            </small>
                                        </div>

                                        <div style="margin-top: 10px; display: flex">
                                            <small>
                                                <label for="searchName"><b>Search Name:</b></label>
                                                <input type="text" id="searchName" placeholder="Enter player name..." autocomplete="off">
                                            </small>
                                            
                                            <small style="margin-left: 10px; display: flex; align-items: center; gap: 6px; width: 160px !important">
                                                <label for="start-date"><b>From:</b></label>
                                                <select id="start-date"></select>
                                            
                                                <label for="end-date"><b>To:</b></label>
                                                <select id="end-date"></select>
                                            </small>
                                                                                        
                                            <script>
                                                function formatDate(date) {
                                                    let day = String(date.getDate()).padStart(2, '0'); // Garantir dois dígitos
                                                    let month = String(date.getMonth() + 1).padStart(2, '0'); 
                                                    let year = String(date.getFullYear()).slice(-2); 
                                            
                                                    return `${day}/${month}/${year}`;
                                                }

                                                function formatDateValue(dateString) {
                                                    const [day, month, year] = dateString.split('/');

                                                    const fullYear = '20' + year; 

                                                    return `${fullYear}-${month}-${day}`;
                                                }
                                            
                                                function populateDateSelects() {
                                                    const today = new Date();
                                                    const dateSelectStart = document.getElementById('start-date');
                                                    const dateSelectEnd = document.getElementById('end-date');

                                                    for (let i = 5; i > 0; i--) { 
                                                        const pastDate = new Date(today);
                                                        pastDate.setDate(today.getDate() - i);

                                                        const formattedDate = formatDate(pastDate);

                                                        const optionStart = document.createElement('option');
                                                        optionStart.value = formatDateValue(formattedDate);
                                                        optionStart.textContent = formattedDate;
                                                        dateSelectStart.appendChild(optionStart);
                                                    }

                                                    const yesterday = new Date(today);
                                                    yesterday.setDate(today.getDate() - 1);
                                                    dateSelectStart.value = formatDateValue(formatDate(yesterday));

                                                    for (let i = 5; i >= 0; i--) { 
                                                        const pastDate = new Date(today);
                                                        pastDate.setDate(today.getDate() - i);

                                                        const formattedDate = formatDate(pastDate);

                                                        const optionEnd = document.createElement('option');
                                                        optionEnd.value = formatDateValue(formattedDate);
                                                        optionEnd.textContent = formattedDate;
                                                        dateSelectEnd.appendChild(optionEnd);
                                                    }

                                                    dateSelectEnd.value = formatDateValue(formatDate(today));
                                                }

                                                document.addEventListener("DOMContentLoaded", function() {
                                                    populateDateSelects();
                                                });

                                            </script>
                                        </div>
                                    </td>
                                    
                                </tr>

                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody id="players-table">
                                                    <!-- Dados serão preenchidos aqui -->
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
        const originalPlayers = @json($players); 
    </script>

    <script src="{{ asset('assets/tibiarl/js/community/powergamers.min.js') }}?v=5" defer></script>
    
@endsection