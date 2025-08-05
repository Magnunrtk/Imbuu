@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Products
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
                                Store
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="#" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#add_product">Add Product</a>
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
    <div class="modal fade" tabindex="-1" id="add_product" role="dialog" aria-hidden="true">
        <form method="post" action="{{ route('admin.store.products.store') }}" class="form">
            @csrf
            <div class="modal-dialog mw-600px modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Product</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="fas fa-times fs-3"></i>
                        </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Image</label>
                            <input type="text" class="form-control form-control-solid" placeholder="serviceid_1.png" name="image">
                        </div>
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Value</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Value" name="value">
                        </div>
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Coins</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Coins" name="coins">
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Prefix</label>
                            <input type="text" class="form-control form-control-solid" placeholder="$" name="prefix">
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Suffix</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Tibia Coins" name="suffix">
                        </div>
                        <div class="d-flex flex-column mb-6">
                            <label class="required fs-5 fw-semibold mb-2">Payment Option</label>
                            <select name="payment_option" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option" data-hide-search="true">
                                @foreach(\App\Models\WebPaymentOption::whereActive(true)->get() as $paymentOption)
                                    <option value="{{ $paymentOption->id }}">{{ $paymentOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Decimals</label>
                            <input type="text" class="form-control form-control-solid" placeholder="0" name="decimals">
                        </div>
                        <div class="d-flex flex-stack">
                            <div class="me-5">
                                <label class="fs-6 fw-semibold form-label">Enable or disable this product</label>
                                <div class="fs-7 fw-semibold text-muted">Choose if you want to enable or disable this product</div>
                            </div>
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="active" value="1" checked="checked">
                                <span class="form-check-label fw-semibold text-muted">Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                            <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" tabindex="-1" id="edit_product" aria-modal="true" role="dialog">
        <form method="post" action="{{ route('admin.store.products.update') }}" class="form">
            @csrf
            <div class="modal-dialog mw-600px modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="fas fa-times fs-3"></i>
                        </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <input type="hidden" name="product_id" value="">
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Image</label>
                            <input type="text" class="form-control form-control-solid" placeholder="serviceid_1.png" name="image">
                        </div>
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Value</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Value" name="value">
                        </div>
                        <div class="mb-5">
                            <label class="required fs-5 fw-semibold mb-2">Coins</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Coins" name="coins">
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Prefix</label>
                            <input type="text" class="form-control form-control-solid" placeholder="$" name="prefix">
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Suffix</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Tibia Coins" name="suffix">
                        </div>
                        <div class="d-flex flex-column mb-6">
                            <label class="required fs-5 fw-semibold mb-2">Payment Option</label>
                            <select name="payment_option" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option" data-hide-search="true">
                                @foreach(\App\Models\WebPaymentOption::whereActive(true)->get() as $paymentOption)
                                    <option value="{{ $paymentOption->id }}">{{ $paymentOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="fs-5 fw-semibold mb-2">Decimals</label>
                            <input type="text" class="form-control form-control-solid" placeholder="0" name="decimals">
                        </div>
                        <div class="d-flex flex-stack">
                            <div class="me-5">
                                <label class="fs-6 fw-semibold form-label">Enable or disable this product</label>
                                <div class="fs-7 fw-semibold text-muted">Choose if you want to enable or disable this product</div>
                            </div>
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="active" value="1" checked="checked">
                                <span class="form-check-label fw-semibold text-muted">Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Submit
                        </span>
                            <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
                        url: '{{ route('admin.store.products.list') }}',
                        method: 'POST',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: [
                        {
                            data: "id",
                            title: "Product",
                            class: "ps-4 min-w-25px rounded-start",
                            render: function (data, type, row) {
                                let img = "'{{ asset('/assets/tibiarl/images/payment/:img') }}'".replace(':img', row.image);
                                return `<a href="#" class="symbol symbol-50px">
                                            <span class="symbol-label" style="background-image:url(${img});"></span>
                                        </a>`;
                            }
                        },
                        {
                            data: "value",
                            title: "Value",
                        },
                        {
                            data: "coins",
                            title: "Coins",
                        },
                        {
                            data: "prefix",
                            title: "Prefix",
                        },
                        {
                            data: "suffix",
                            title: "Suffix",
                        },
                        {
                            data: "payment_option",
                            title: "Payment Option",
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
                                return `<button type="button" class="btn btn-sm btn-icon btn-primary me-1" data-product="edit">
                                            <span class="indicator-label"><i class="fas fa-edit fs-3 text-white"></i></span>
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

            let handleEditButton = function () {
                transactionsDt.on('click', 'button[data-product="edit"]', function() {
                    let self = this;
                    blockButton(self)
                    let tableRow = $(this).closest('tr');
                    let row = transactionsDt.row(tableRow);
                    let rData = row.data();
                    $.ajax({
                        url: '{{ route('admin.store.products.info') }}',
                        data: {
                            id: rData.id,
                        },
                        type: 'POST',
                        success: function (response) {
                            $('#edit_product input[name="product_id"]').val(response.id);
                            $('#edit_product input[name="image"]').val(response.image);
                            $('#edit_product input[name="value"]').val(parseInt(response.value));
                            $('#edit_product input[name="coins"]').val(response.coins);
                            $('#edit_product input[name="prefix"]').val(response.prefix);
                            $('#edit_product input[name="suffix"]').val(response.suffix);
                            $('#edit_product input[name="decimals"]').val(response.decimals);
                            $('#edit_product select[name="payment_option"]').val(response.payment_option_id).trigger('change');
                            $('#edit_product').modal('show');
                            resetButton(self);
                        }, error: function (response) {
                            resetButton(self);
                            showNotification('error', 'Whoops!', 'Something went wrong!', 'top-right');
                            location.reload();
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
                    handleEditButton();
                }
            }
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTDatatableTransactions.init();
        });
    </script>
@endsection