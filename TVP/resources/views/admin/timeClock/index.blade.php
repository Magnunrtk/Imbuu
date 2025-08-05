@extends('template.layout_admin')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/admin/timeClock/index.css') }}?v=a1s">

<div class="tabs">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <span class="nav-linkPark active" id="timeClock-tab" data-bs-toggle="tab" href="#timeClock" role="tab" aria-controls="timeClock" aria-selected="true">Time Clock</span>
        </li>
        <li class="nav-item" role="presentation">
            <span class="nav-linkPark" id="receipts-tab" data-bs-toggle="tab" href="#receipts" role="tab" aria-controls="receipts" aria-selected="false">Receipts</span>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="timeClock" role="tabpanel" aria-labelledby="timeClock-tab">
            <h1>Employee Time Clock for {{ $employeeName }}</h1>

            <form id="timeClockForm" action="{{ route('admin.timeClock.store') }}" method="POST">
                @csrf
                <input type="hidden" id="employeeName" name="employeeName" value="{{ $employeeName }}">

                <div>
                    <label for="task">Current Task:</label>
                    <input type="text" id="task" name="task" placeholder="What are you working on?">
                </div>

                <div>
                    <label for="task-input">Tasks Done Today:</label>
                    <div>
                        <input type="text" id="task-input" name="tasks_day" placeholder="Type a task and press Enter" style="flex: 1;">
                    </div>

                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div id="tag-container"></div>
                        <button id="move-tags" title="Move tags to input">↑</button>
                    </div>
                </div>                
                
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const taskInput = document.getElementById("task-input");
                        const tagContainer = document.getElementById("tag-container");
                        const moveTagsButton = document.getElementById("move-tags");

                        let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

                        function formatTag(tag) {
                            return tag
                                .toLowerCase()
                                .split(" ")
                                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                                .join(" ");
                        }

                        function renderTags() {
                            tagContainer.innerHTML = ""; 

                            tasks.forEach((task, index) => {
                                const tag = document.createElement("span");
                                tag.classList.add("tag");

                                const tagText = document.createElement("span");
                                tagText.textContent = formatTag(task);

                                const removeButton = document.createElement("button");
                                removeButton.innerHTML = "&times;";
                                removeButton.classList.add("remove-tag");
                                removeButton.onclick = function (event) {
                                    event.preventDefault();
                                    removeTag(index);
                                };

                                tag.appendChild(tagText);
                                tag.appendChild(removeButton);
                                tagContainer.appendChild(tag);
                            });

                            localStorage.setItem("tasks", JSON.stringify(tasks));
                        }

                        taskInput.addEventListener("keypress", function (event) {
                            if (event.key === "Enter" && taskInput.value.trim() !== "") {
                                event.preventDefault();
                                tasks.push(taskInput.value.trim());
                                taskInput.value = "";
                                renderTags();
                            }
                        });

                        window.removeTag = function (index) {
                            tasks.splice(index, 1);
                            renderTags();
                        };

                        moveTagsButton.addEventListener("click", function (event) {
                            event.preventDefault();
                            if (tasks.length > 0) {
                                taskInput.value = tasks.map(formatTag).join("; ");
                            }
                        });

                        renderTags();
                    });
                </script>

                <div style="display: flex; gap: 10px">
                    <label>Recorded time of the day: </label>
                    <h2 id="timerDisplay" contenteditable="true">{{ $formattedTime }}</h2>
                </div>

                <div style="display: flex; gap: 10px">
                    <label>Backup time (Running in parallel): </label>
                    <h2 id="backupTimerDisplay" contenteditable="true">00:00:00</h2>
                    <button class="buttonClass" type="button" id="resetBackupButton" onclick="resetBackupTimer()">Reset</button>
                </div>

                <button class="buttonClass" type="button" id="startButton" onclick="startTimer()">Start</button>
                <button class="buttonClass" type="button" id="stopButton" onclick="stopTimer()" disabled>Stop</button>

                <input type="hidden" id="elapsedTime" name="elapsedTime">

                <button class="buttonClass" type="submit">Register Time</button>
            </form>

            <div id="notes-container">
                <label for="notes">Personal Notes:</label>
                <textarea id="notes" name="notes" placeholder="Add your personal notes here..."></textarea>
            </div>

            <h2>Time Records</h2>
            <table border="1" style="width: 100%; margin-top: 10px;">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Tasks Done</th>
                        <th>Recorded Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrosUnpaid as $registro)
                        <tr>
                            <td>{{ $registro->task }}</td>
                            <td>{{ $registro->tasks_day }}</td>
                            <td>{{ $registro->elapsed_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Total Time: {{ $totalUnpaidTime }}</h3>
        </div>

        <div class="tab-pane fade" id="receipts" role="tabpanel" aria-labelledby="receipts-tab">
            <h1 class="section-title">Receipts</h1>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Receipt</th>
                        <th>Date of Payment</th>
                        <th>Payment Amount</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($paidReceipts as $receipt)
                        <tr>
                            <td>{{ $receipt->employee_name }}</td>
                            <td>
                                <a href="{{ $receipt->file_url }}" target="_blank">Download Receipt</a>
                            </td>
                            <td>{{ $receipt->payment_date }}</td>
                            <td>{{ number_format($receipt->pay_due, 2, ',', '.') }}</td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    const UPDATE_STATUS_URL = "{{ route('admin.timeClock.updateStatus') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
</script>

<script src="{{ asset('assets/js/admin/timeClock/index.js') }}"></script>

@endsection
