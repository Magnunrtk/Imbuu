@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Tibia Coins
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                Manual Transactions
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <div class="card">
                        <div class="card-header align-items-center py-1 gap-1 gap-md-1">
                            <div class="d-flex flex-wrap gap-1">
                                <div class="position-relative d-flex align-items-center">
                                    <span class="svg-icon svg-icon-2 position-absolute ms-4">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid mw-100 min-w-250px min-w-md-250px ps-12"
                                           placeholder="Search..." data-kt-table-search="input" autocomplete="off">
                                    <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-1 p-3 d-none" data-kt-table-search="clear">
                                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                            <i class="fas fa-times fa-lg"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light me-2" data-kt-table-reload="button">
                                    <span class="indicator-label"><i class="fas fa-sync fs-3"></i></span>
                                    <span class="indicator-progress">
                                        <i class="fas fa-sync fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="transactionsDatatable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/assets/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('/assets/admin/plugins/custom/datatables/datatables.global.js') }}"></script>
    <script src="{{ asset('/assets/admin/plugins/custom/datatables/datatables.filter.js') }}"></script>
    <script src="{{ asset('/assets/admin/plugins/custom/datatables/datatable.datetime-moment.js') }}"></script>
    <script type="text/javascript">
        "use strict";
        let KTDatatableTransactions = function () {
            let table;
            let transactionsDt;
            let transactionsDtId = '#transactionsDatatable';

            let initDatatable = function () {
                $.fn.dataTable.moment( 'DD.MM.YYYY HH:mm:ss' );
                transactionsDt = $(transactionsDtId).DataTable({
                    searchDelay: 500,
                    serverSide: false,
                    order: [
                        [0, 'desc'],
                        [1, 'desc'],
                        [2, 'desc'],
                        [3, 'desc'],
                    ],
                    lengthChange: false,
                    deferRender: true,
                    ajax: {
                        url: '{{ route('admin.transactions.tibia-coins.list') }}',
                        method: 'POST',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: [
                        {
                            data: "external_name",
                            title: "Character Name",
                            class: "ps-4 min-w-25px rounded-start",
                        },
                        {
                            data: "price",
                            title: "Paid Coins",
                        },
                        {
                            data: "coins",
                            title: "Receive Coins",
                        },
                        {
                            data: "created_at",
                            name: "created_at",
                            title: "Created",
                        },
                        {
                            data: "actions",
                            name: "actions",
                            title: "Actions",
                            class: 'min-w-100px text-start rounded-end pe-4',
                            render: function (data, type, row) {

                                return `<button type="button" class="btn btn-sm btn-icon btn-success me-1" data-transaction="approve">
                                            <span class="indicator-label"><i class="fas fa-check fs-3 text-white"></i></span>
                                                <span class="indicator-progress">
                                                    <i class="fas fa-circle-notch fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                                </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger" data-transaction="reject">
                                            <span class="indicator-label"><i class="fas fa-times fs-3 text-white"></i></span>
                                                <span class="indicator-progress">
                                                    <i class="fas fa-circle-notch fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                                </span>
                                        </button>`;
                            }
                        },
                    ],
                    columnDefs: [
                        {
                            targets: [4],
                            orderable: false,
                        },
                    ],
                });
                table = transactionsDt.$;
            }

            let blockButton = function (button) {
                button.disabled = true;
                button.setAttribute("data-kt-indicator", "on");
            }

            let resetButton = function (button) {
                button.removeAttribute("data-kt-indicator");
                button.disabled = false;
            }

            let handleTransactionButton = function () {
                transactionsDt.on('click', 'button[data-transaction="approve"], button[data-transaction="reject"]', function() {
                    let self = this;
                    blockButton(self)
                    let tableRow = $(this).closest('tr');
                    let row = transactionsDt.row(tableRow);
                    let rData = row.data();
                    let transactionType = $(this).data('transaction');
                    $.ajax({
                        url: '{{ route('admin.transactions.tibia-coins.action') }}',
                        data: {
                            id: rData.id,
                            type: transactionType,
                        },
                        type: 'POST',
                        success: function (response) {
                            resetButton(self);
                            if (response.type === 'success') {
                                transactionsDt.rows(function( idx, data, node ) {return data['id'] === rData.id;}).remove().draw(false);
                                return showNotification('success', 'Done!', response.message);
                            }
                            return showNotification('error', 'Error!', response.message)
                        }, error: function (response) {
                            resetButton(self);
                            return showNotification('error', 'Error!', response.responseJSON.message)
                        }
                    });
                });
            }

            return {
                init: function () {
                    initDatatable();
                    $(transactionsDtId + ' thead').addClass('fw-bold text-muted bg-light');
                    handleSearchDatatable(transactionsDt, '[data-kt-table-search="input"]', '[data-kt-table-search="clear"]');
                    handleReloadDatatable('[data-kt-table-reload="button"]');
                    handleTransactionButton();
                }
            }
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTDatatableTransactions.init();
        });
    </script>
@endsection