@extends('template.layout_admin')
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Payment Options
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
                                Shop
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="d-flex flex-column flex-xl-row">
                        <div class="d-flex flex-row-fluid me-xl-9 mb-10 mb-xl-0">
                            <div class="card card-flush card-p-0 bg-transparent border-0 ">
                                <div class="card-body">
                                    <ul class="nav nav-pills d-flex justify-content-start nav-pills-custom gap-10 mb-6" role="tablist">
                                        <li class="nav-item mb-3 me-0" role="presentation">
                                            <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg show active" data-bs-toggle="pill" href="#payment_option_stripe" aria-selected="true" role="tab" style="width: 180px;height: 130px">
                                                <div class="nav-icon mb-3">
                                                    <img src="{{ asset('/assets/tibiarl/images/payment/stripe.gif') }}" class="mb-1 w-150px h-40px w-xxl-150px h-xxl-40px" alt="">
                                                </div>
                                                <div class="">
                                                    <span class="text-gray-800 fw-bold fs-2 d-block">Stripe</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item mb-3 me-0" role="presentation">
                                            <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg" data-bs-toggle="pill" href="#payment_option_paypal" aria-selected="true" role="tab" style="width: 180px;height: 130px">
                                                <div class="nav-icon mb-3">
                                                    <img src="{{ asset('/assets/tibiarl/images/payment/paypal.gif') }}" class="mb-1 w-150px h-40px w-xxl-150px h-xxl-40px" alt="">
                                                </div>
                                                <div class="">
                                                    <span class="text-gray-800 fw-bold fs-2 d-block">PayPal</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item mb-3 me-0" role="presentation">
                                            <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg" data-bs-toggle="pill" href="#payment_option_pix" aria-selected="true" role="tab" style="width: 180px;height: 130px">
                                                <div class="nav-icon mb-3">
                                                    <img src="{{ asset('/assets/tibiarl/images/payment/pix.gif') }}" class="mb-1 w-150px h-40px w-xxl-150px h-xxl-40px" alt="">
                                                </div>
                                                <div class="">
                                                    <span class="text-gray-800 fw-bold fs-2 d-block">Pix</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item mb-3 me-0" role="presentation">
                                            <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg" data-bs-toggle="pill" href="#payment_option_tc" aria-selected="true" role="tab" style="width: 180px;height: 130px">
                                                <div class="nav-icon mb-3">
                                                    <img src="{{ asset('/assets/tibiarl/images/payment/tc.gif') }}" class="mb-1 w-150px h-40px w-xxl-150px h-xxl-40px" alt="">
                                                </div>
                                                <div class="">
                                                    <span class="text-gray-800 fw-bold fs-2 d-block">Tibia Coins</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item mb-3 me-0" role="presentation">
                                            <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack pt-9 pb-7 page-bg" data-bs-toggle="pill" href="#payment_option_mc" aria-selected="true" role="tab" style="width: 180px;height: 130px">
                                                <div class="nav-icon mb-3">
                                                    <img src="{{ asset('/assets/tibiarl/images/payment/mc.gif') }}" class="mb-1 w-150px h-40px w-xxl-150px h-xxl-40px" alt="">
                                                </div>
                                                <div class="">
                                                    <span class="text-gray-800 fw-bold fs-2 d-block">Medivia Coins</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="payment_option_stripe" role="tabpanel">
                                            <div class="card mb-5 mb-xl-10">
                                                <div class="card-header border-0 px-5">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Stripe Settings</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="form-check form-check-solid form-switch form-check-custom">
                                                            <input class="form-check-input w-45px h-30px" type="checkbox" id="active" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Enable/Disable Payment">
                                                            <label class="form-check-label" for="active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <div class="card-body border-top p-9">
                                                        <div class="row mb-6">
                                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                                <div class="mb-0">
                                                                    <label for="live_client_id" class="form-label fs-6 fw-bold mb-3">Live Client ID</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="live_client_id" placeholder="Live Client ID" name="live_client_id">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-0">
                                                                    <label for="live_client_secret" class="form-label fs-6 fw-bold mb-3">Live Client Secret</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="live_client_secret" placeholder="Live Client Secret" name="live_client_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <div class="row mb-6">
                                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                                <div class="mb-0">
                                                                    <label for="dev_client_id" class="form-label fs-6 fw-bold mb-3">Developer Client ID</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="dev_client_id" placeholder="Developer Client ID" name="dev_client_id">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-0">
                                                                    <label for="dev_client_secret" class="form-label fs-6 fw-bold mb-3">Developer Client Secret</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="dev_client_secret" placeholder="Developer Client Secret" name="dev_client_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <label class="form-check form-check-custom form-check-solid align-items-start">
                                                            <input class="form-check-input me-3" type="checkbox" name="developer" value="1">
                                                            <span class="form-check-label d-flex flex-column align-items-start">
                                                                <span class="fw-bold fs-5 mb-0">Developer mode</span>
                                                                <span class="text-muted fs-6">Enable developer mode to test payments</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment_option_paypal" role="tabpanel">
                                            <div class="card mb-5 mb-xl-10">
                                                <div class="card-header border-0 px-5">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">PayPal Settings</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="form-check form-check-solid form-switch form-check-custom">
                                                            <input class="form-check-input w-45px h-30px" type="checkbox" id="active" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Enable/Disable Payment">
                                                            <label class="form-check-label" for="active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <div class="card-body border-top p-9">
                                                        <div class="row mb-6">
                                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Currency</label>
                                                            <div class="col-lg-8">
                                                                <select name="currency" class="form-select form-select-solid" data-control="select2" data-dropdown-css-class="w-200px" data-placeholder="Select an option" data-hide-search="true">
                                                                    <option value="AUD">Australian dollar</option>
                                                                    <option value="BRL">Brazilian real</option>
                                                                    <option value="CAD">Canadian dollar</option>
                                                                    <option value="CNY">Chinese Renmenbi</option>
                                                                    <option value="CZK">Czech koruna</option>
                                                                    <option value="DKK">Danish krone</option>
                                                                    <option value="EUR" selected>Euro</option>
                                                                    <option value="HKD">Hong Kong dollar</option>
                                                                    <option value="HUF">Hungarian forint</option>
                                                                    <option value="ILS">Israeli new shekel</option>
                                                                    <option value="JPY">Japanese yen</option>
                                                                    <option value="MYR">Malaysian ringgit</option>
                                                                    <option value="MXN">Mexican peso</option>
                                                                    <option value="TWD">New Taiwan dollar</option>
                                                                    <option value="NZD">New Zealand dollar</option>
                                                                    <option value="NOK">Norwegian krone</option>
                                                                    <option value="PHP">Philippine peso</option>
                                                                    <option value="PLN">Polish złoty</option>
                                                                    <option value="GBP">Pound sterling</option>
                                                                    <option value="SGD">Singapore dollar</option>
                                                                    <option value="SEK">Swedish krona</option>
                                                                    <option value="CHF">Swiss franc</option>
                                                                    <option value="THB">Thai baht</option>
                                                                    <option value="USD">United States dollar</option>
                                                                </select>
                                                                <div class="form-text">
                                                                    Please select the currency players need to pay in.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <div class="row mb-6">
                                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                                <div class="mb-0">
                                                                    <label for="live_client_id" class="form-label fs-6 fw-bold mb-3">Live Client ID</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="live_client_id" placeholder="Live Client ID" name="live_client_id">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-0">
                                                                    <label for="live_client_secret" class="form-label fs-6 fw-bold mb-3">Live Client Secret</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="live_client_secret" placeholder="Live Client Secret" name="live_client_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <div class="row mb-6">
                                                            <div class="col-lg-6 mb-4 mb-lg-0">
                                                                <div class="mb-0">
                                                                    <label for="sandbox_client_id" class="form-label fs-6 fw-bold mb-3">Sandbox Client ID</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="sandbox_client_id" placeholder="Sandbox Client ID" name="sandbox_client_id">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-0">
                                                                    <label for="sandbox_client_secret" class="form-label fs-6 fw-bold mb-3">Sandbox Client Secret</label>
                                                                    <input type="text" class="form-control form-control-lg form-control-solid" id="sandbox_client_secret" placeholder="Sandbox Client Secret" name="sandbox_client_secret">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <label class="form-check form-check-custom form-check-solid align-items-start">
                                                            <input class="form-check-input me-3" type="checkbox" name="sandbox" value="1">
                                                            <span class="form-check-label d-flex flex-column align-items-start">
                                                                <span class="fw-bold fs-5 mb-0">Sandbox mode</span>
                                                                <span class="text-muted fs-6">Enable sandbox mode to test payments</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment_option_pix" role="tabpanel">
                                            <div class="card mb-5 mb-xl-10">
                                                <div class="card-header border-0 px-5">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Pix Settings</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="form-check form-check-solid form-switch form-check-custom">
                                                            <input class="form-check-input w-45px h-30px" type="checkbox" id="active" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Enable/Disable Payment">
                                                            <label class="form-check-label" for="active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <div class="card-body border-top p-9">
                                                        <div class="row mb-6">
                                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Currency</label>
                                                            <div class="col-lg-8">
                                                                <select name="currency" class="form-select form-select-solid" data-control="select2" data-dropdown-css-class="w-200px" data-placeholder="Select an option" data-hide-search="true">
                                                                    <option value="BRL" selected>Brazilian real</option>
                                                                </select>
                                                                <div class="form-text">
                                                                    Please select the currency players need to pay in.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <div class="row mb-6">
                                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Access Token</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" name="access_token" class="form-control form-control-lg form-control-solid" placeholder="Access Token">
                                                                <div class="form-text">
                                                                    Enter your Mercado Pago live or test access token.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed my-6"></div>
                                                        <label class="form-check form-check-custom form-check-solid align-items-start">
                                                            <input class="form-check-input me-3" type="checkbox" name="strict_check" value="1">
                                                            <span class="form-check-label d-flex flex-column align-items-start">
                                                                <span class="fw-bold fs-5 mb-0">Strict Currency Check</span>
                                                                <span class="text-muted fs-6">Make sure only payments in the currency above are allowed</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment_option_tc" role="tabpanel">
                                            <div class="card mb-5 mb-xl-10">
                                                <div class="card-header border-0 px-5">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Tibia Coins Settings</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="form-check form-check-solid form-switch form-check-custom">
                                                            <input class="form-check-input w-45px h-30px" type="checkbox" id="active" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Enable/Disable Payment">
                                                            <label class="form-check-label" for="active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <div class="card-body border-top p-9">
                                                        <div class="row mb-6">
                                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Character Name</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" name="access_token" class="form-control form-control-lg form-control-solid" placeholder="Character Name">
                                                                <div class="form-text">
                                                                    Tibia character that should receive coins.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-0 p-6">
                                                            <div class="d-flex flex-stack flex-grow-1 ">
                                                                <div class=" fw-semibold">
                                                                    <div class="fs-6 text-gray-700">All payments with this payment option will be placed in the <a href="{{ route('admin.transactions.medivia-coins.index') }}" class="fw-bold">Manual Transaction</a> list and must be confirmed manually before the payment is processed.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment_option_mc" role="tabpanel">
                                            <div class="card mb-5 mb-xl-10">
                                                <div class="card-header border-0 px-5">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Medivia Coins Settings</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="form-check form-check-solid form-switch form-check-custom">
                                                            <input class="form-check-input w-45px h-30px" type="checkbox" id="active" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Enable/Disable Payment">
                                                            <label class="form-check-label" for="active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <div class="card-body border-top p-9">
                                                        <div class="row mb-6">
                                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Medivia Servers</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" name="server_list" class="form-control form-control-lg form-control-solid" id="medivia_server_list" placeholder="Servers">
                                                                <div class="form-text">
                                                                    Add or remove a server on Medivia.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-0 p-6">
                                                            <div class="d-flex flex-stack flex-grow-1 ">
                                                                <div class=" fw-semibold">
                                                                    <div class="fs-6 text-gray-700">All payments with this payment option will be placed in the <a href="{{ route('admin.transactions.tibia-coins.index') }}" class="fw-bold">Manual Transaction</a> list and must be confirmed manually before the payment is processed.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            let input1 = document.querySelector("#medivia_server_list");
            new Tagify(input1);
        });
    </script>
@endsection