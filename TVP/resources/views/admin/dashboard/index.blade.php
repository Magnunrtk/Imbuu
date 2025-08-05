@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Dashboard
                        </h1>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <div class="row gy-5 g-xl-10 mb-10">
                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                            <div class="card h-lg-100">
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <div class="m-0">
                                        <i class="fas fa-user-plus fs-2hx text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column my-7">
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $totalAccounts->count() }}</span>
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Total Accounts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                            <div class="card h-lg-100">
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <div class="m-0">
                                        <i class="fas fa-walking fs-2hx text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column my-7">
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $totalPlayers->count() }}</span>
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Total Players</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                            <div class="card h-lg-100">
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <div class="m-0">
                                        <i class="fas fa-chart-pie fs-2hx text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column my-7">
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $totalGuilds->count() }}</span>
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Total Guilds</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                            <div class="card h-lg-100">
                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                    <div class="m-0">
                                        <i class="fas fa-home fs-2hx text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column my-7">
                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $totalHouses->count() }}</span>
                                        <div class="m-0">
                                            <span class="fw-semibold fs-6 text-gray-500">Total Houses</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-5 g-xl-10 mb-10">
                        <div class="col-xxl-4">
                            <div class="card card-xxl-stretch mb-5 mb-xxl-10">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="text-gray-800">Maintenance</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <span class="fs-5 fw-semibold text-gray-600 pb-6 d-block">Easily switch your website between 'Close' and 'Open'. Ideal for quick updates or making the site live.</span>
                                    <div class="d-flex align-self-center">
                                        <div class="flex-grow-1 me-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Seller Annual Fee" data-hide-search="true">
                                                <option value="0">Open</option>
                                                <option value="1">Close</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-icon flex-shrink-0">
                                            <i class="fas fa-arrow-down fs-3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection