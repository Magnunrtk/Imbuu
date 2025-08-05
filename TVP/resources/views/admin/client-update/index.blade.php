@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
                <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Client Update
                        </h1>
                    </div>
                </div>
            </div>
            <div id="kt_app_content_container" class="app-container container-xxl">
                <form method="post" action="{{ route('admin.client-update.action') }}">
                    @csrf
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header border-0 px-5">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Settings</h3>
                            </div>
                        </div>
                        <div class="collapse show">
                            <div class="card-body border-top p-9">
                                <div class="row mb-6">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="mb-0">
                                            <label for="gh_username" class="form-label fs-6 fw-bold mb-3">Github Username</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" id="gh_username" placeholder="Github Username" value="{{ config('client_update.github')['username'] }}" name="gh_username" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-0">
                                            <label for="gh_access_token" class="form-label fs-6 fw-bold mb-3">Github Access Token</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" id="gh_access_token" placeholder="Github Access Token" value="{{ substr(config('client_update.github')['accessToken'], 0, 4) . str_repeat('*', strlen(config('client_update.github')['accessToken']) - 8) . substr(config('client_update.github')['accessToken'], -4) }}" name="gh_access_token" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-6"></div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Github Repository</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="gh_repo_url" class="form-control form-control-lg form-control-solid" placeholder="Repository URL" value="{{ config('client_update.github')['repository'] }}" disabled>
                                        <div class="form-text">
                                            Example: https://github.com/username/repo
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary">Fetch files</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection