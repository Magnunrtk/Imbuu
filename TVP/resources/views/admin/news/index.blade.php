@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            News Panel
                        </h1>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.news.add.index') }}" class="btn btn-sm btn-light-success">
                            <i class="fas fa-plus"></i>Add News
                        </a>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <div class="card mb-15">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">News</span>
                            </h3>
                        </div>
                        <div class="card-header align-items-center py-1 gap-1 gap-md-1">
                            <div class="d-flex flex-wrap gap-1">
                                <div class="position-relative d-flex align-items-center">
                                    <span class="svg-icon svg-icon-2 position-absolute ms-4">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid mw-100 min-w-250px min-w-md-250px ps-12"
                                           placeholder="Search..." data-news-table-search="input" autocomplete="off">
                                    <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-1 p-3 d-none" data-news-table-search="clear">
                                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                            <i class="fas fa-times fa-lg"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light me-2" data-news-table-reload="button">
                                    <span class="indicator-label"><i class="fas fa-sync fs-3"></i></span>
                                    <span class="indicator-progress">
                                        <i class="fas fa-sync fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="newsDatatable"></table>
                        </div>
                    </div>
                    <div class="card mb-15">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Tickers</span>
                            </h3>
                        </div>
                        <div class="card-header align-items-center py-1 gap-1 gap-md-1">
                            <div class="d-flex flex-wrap gap-1">
                                <div class="position-relative d-flex align-items-center">
                                    <span class="svg-icon svg-icon-2 position-absolute ms-4">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid mw-100 min-w-250px min-w-md-250px ps-12"
                                           placeholder="Search..." data-tickers-table-search="input" autocomplete="off">
                                    <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-1 p-3 d-none" data-tickers-table-search="clear">
                                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                            <i class="fas fa-times fa-lg"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light me-2" data-tickers-table-reload="button">
                                    <span class="indicator-label"><i class="fas fa-sync fs-3"></i></span>
                                    <span class="indicator-progress">
                                        <i class="fas fa-sync fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="tickersDatatable"></table>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Articles</span>
                            </h3>
                        </div>
                        <div class="card-header align-items-center py-1 gap-1 gap-md-1">
                            <div class="d-flex flex-wrap gap-1">
                                <div class="position-relative d-flex align-items-center">
                                    <span class="svg-icon svg-icon-2 position-absolute ms-4">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-solid mw-100 min-w-250px min-w-md-250px ps-12"
                                           placeholder="Search..." data-articles-table-search="input" autocomplete="off">
                                    <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-1 p-3 d-none" data-articles-table-search="clear">
                                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                            <i class="fas fa-times fa-lg"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light me-2" data-articles-table-reload="button">
                                    <span class="indicator-label"><i class="fas fa-sync fs-3"></i></span>
                                    <span class="indicator-progress">
                                        <i class="fas fa-sync fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-3">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="articlesDatatable"></table>
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
        let KTDatatableNews = function () {
            let newsTable;
            let newsDt;
            let newsDtId = '#newsDatatable';
            let tickersTable;
            let tickersDt;
            let tickersDtId = '#tickersDatatable';
            let articlesTable;
            let articlesDt;
            let articlesDtId = '#articlesDatatable';

            let initNewsDatatable = function () {
                newsDt = $(newsDtId).DataTable({
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
                        url: '{{ route('admin.news.list', [\App\Utils\NewsType::NEWS]) }}',
                        method: 'POST',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: [
                        {
                            data: "id",
                            title: "ID",
                            class: "ps-4 min-w-25px rounded-start",
                        },
                        {
                            data: "title",
                            title: "Title",
                            className: 'min-w-200px',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "created_at",
                            name: "created_at",
                            title: "Date",
                        },
                        {
                            data: "author",
                            name: "author",
                            title: "Author",
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('community.view.character.search', ['author']) }}'.replace('author', encodeURIComponent(data))}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "actions",
                            name: "actions",
                            title: "Actions",
                            class: 'min-w-100px text-start rounded-end pe-4',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="btn btn-sm btn-icon btn-success me-1">
                                            <i class="fas fa-edit fs-3 text-white"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger me-1" data-button="delete">
                                            <span class="indicator-label"><i class="fas fa-trash fs-3 text-white"></i></span>
                                                <span class="indicator-progress">
                                                    <i class="fas fa-circle-notch fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                                </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-light" data-news-button="">
                                            <i class="fas fa-eye fs-3 text-white"></i>
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
                newsTable = newsDt.$;
            }

            let initTickersDatatable = function () {
                tickersDt = $(tickersDtId).DataTable({
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
                        url: '{{ route('admin.news.list', [\App\Utils\NewsType::TICKER]) }}',
                        method: 'POST',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: [
                        {
                            data: "id",
                            title: "ID",
                            class: "ps-4 min-w-25px rounded-start",
                        },
                        {
                            data: "title",
                            title: "Title",
                            className: 'min-w-200px',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "created_at",
                            name: "created_at",
                            title: "Date",
                        },
                        {
                            data: "author",
                            name: "author",
                            title: "Author",
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('community.view.character.search', ['author']) }}'.replace('author', encodeURIComponent(data))}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "actions",
                            name: "actions",
                            title: "Actions",
                            class: 'min-w-100px text-start rounded-end pe-4',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="btn btn-sm btn-icon btn-success me-1">
                                            <i class="fas fa-edit fs-3 text-white"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger me-1" data-button="delete">
                                            <span class="indicator-label"><i class="fas fa-trash fs-3 text-white"></i></span>
                                                <span class="indicator-progress">
                                                    <i class="fas fa-circle-notch fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                                </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-light" data-news-button="">
                                            <i class="fas fa-eye fs-3 text-white"></i>
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
                tickersTable = tickersDt.$;
            }

            let initArticlesDatatable = function () {
                articlesDt = $(articlesDtId).DataTable({
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
                        url: '{{ route('admin.news.list', [\App\Utils\NewsType::ARTICLE]) }}',
                        method: 'POST',
                        dataSrc: function (response) {
                            return response.data;
                        },
                    },
                    columns: [
                        {
                            data: "id",
                            title: "ID",
                            class: "ps-4 min-w-25px rounded-start",
                        },
                        {
                            data: "title",
                            title: "Title",
                            className: 'min-w-200px',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "created_at",
                            name: "created_at",
                            title: "Date",
                        },
                        {
                            data: "author",
                            name: "author",
                            title: "Author",
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('community.view.character.search', ['author']) }}'.replace('author', encodeURIComponent(data))}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${data}</a>`;
                            }
                        },
                        {
                            data: "actions",
                            name: "actions",
                            title: "Actions",
                            class: 'min-w-100px text-start rounded-end pe-4',
                            render: function (data, type, row) {
                                return `<a href="${'{{ route('admin.news.update.index', ['id']) }}'.replace('id', row.id)}" class="btn btn-sm btn-icon btn-success me-1">
                                            <i class="fas fa-edit fs-3 text-white"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-icon btn-danger me-1" data-button="delete">
                                            <span class="indicator-label"><i class="fas fa-trash fs-3 text-white"></i></span>
                                                <span class="indicator-progress">
                                                    <i class="fas fa-circle-notch fa-spin fs-3" style="--fa-animation-duration: 0.75s;"></i>
                                                </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-icon btn-light" data-news-button="">
                                            <i class="fas fa-eye fs-3 text-white"></i>
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
                articlesTable = articlesDt.$;
            }

            let blockButton = function (button) {
                button.disabled = true;
                button.setAttribute("data-kt-indicator", "on");
            }

            let resetButton = function (button) {
                button.removeAttribute("data-kt-indicator");
                button.disabled = false;
            }

            let handleDeleteButton = function () {
                newsDt.on('click', 'button[data-button="delete"]', function() {
                    let self = this;
                    blockButton(self)
                    let tableRow = $(this).closest('tr');
                    let row = newsDt.row(tableRow);
                    let rData = row.data();
                    $.ajax({
                        url: '{{ route('admin.news.delete', ['id' => ':id']) }}'.replace(':id', rData.id),
                        type: 'POST',
                        success: function (response) {
                            resetButton(self);
                            if (response.type === 'success') {
                                executeReloadDatatable();
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
                    initNewsDatatable();
                    $(newsDtId + ' thead').addClass('fw-bold text-muted bg-light');
                    handleSearchDatatable(newsDt, '[data-news-table-search="input"]', '[data-news-table-search="clear"]');
                    handleReloadDatatable('[data-news-table-reload="button"]');
                    initTickersDatatable();
                    $(tickersDtId + ' thead').addClass('fw-bold text-muted bg-light');
                    handleSearchDatatable(newsDt, '[data-tickers-table-search="input"]', '[data-tickers-table-search="clear"]');
                    handleReloadDatatable('[data-tickers-table-reload="button"]');
                    initArticlesDatatable();
                    $(articlesDtId + ' thead').addClass('fw-bold text-muted bg-light');
                    handleSearchDatatable(newsDt, '[data-articles-table-search="input"]', '[data-articles-table-search="clear"]');
                    handleReloadDatatable('[data-articles-table-reload="button"]');
                    handleDeleteButton();
                }
            }
        }();

        KTUtil.onDOMContentLoaded(function () {
            KTDatatableNews.init();
        });
    </script>
@endsection