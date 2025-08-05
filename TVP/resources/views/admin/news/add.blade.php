@extends('template.layout_admin')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-modal-backdrop {
            z-index: 1 !important;
        }
    </style>
@endsection
@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
                <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            News
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                Add News
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-sm fw-bold btn-primary">
                            Back
                        </a>
                    </div>
                </div>
            </div>
            <div id="kt_app_content_container" class="app-container container-xxl">
                <form method="post" action="{{ route('admin.news.add.action') }}">
                    @csrf
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header border-0">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Add News</h3>
                            </div>
                        </div>
                        <div class="collapse show">
                            <div class="card-body border-top p-9">
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="title" class="form-control form-control-lg form-control-solid" placeholder="Title">
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Content</label>
                                    <textarea class="summernote min-h-200px mb-2" name="body"></textarea>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Type</label>
                                    <div class="col-lg-8">
                                        <select name="type" class="form-select form-select-solid" data-control="select2" data-dropdown-css-class="w-200px" data-placeholder="Select an option" data-hide-search="true">
                                            <option value="1" selected>News</option>
                                            <option value="2">Ticker</option>
                                            <option value="3">Article</option>
                                        </select>
                                        <div class="form-text">
                                            Please select the type of news you want to create.
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Author</label>
                                    <div class="col-lg-8">
                                        <select name="player_id" class="form-select form-select-solid" data-control="select2" data-dropdown-css-class="w-200px" data-placeholder="Select an option" data-hide-search="true">
                                            @forelse(Auth::user()->characters as $character)
                                                <option value="{{ $character->id }}">{{ $character->name }}</option>
                                            @empty
                                                <option>No character available</option>
                                            @endforelse
                                        </select>
                                        <div class="form-text">
                                            Please select an author for the news.
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-0" data-kt-buttons="true" data-kt-buttons-target=".form-check-image, .form-check-input">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Category</label>
                                    <div class="col-lg-1">
                                        <label class="form-check-image active">
                                            <div class="form-check-wrapper text-center">
                                                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_0.gif') }}"/>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" checked value="0" name="category"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="form-check-image">
                                            <div class="form-check-wrapper text-center">
                                                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_1.gif') }}"/>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="1" name="category"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="form-check-image">
                                            <div class="form-check-wrapper text-center">
                                                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_2.gif') }}"/>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="2" name="category"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="form-check-image">
                                            <div class="form-check-wrapper text-center">
                                                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_3.gif') }}"/>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="3" name="category"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-1">
                                        <label class="form-check-image">
                                            <div class="form-check-wrapper text-center">
                                                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_4.gif') }}"/>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="4" name="category"/>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('admin.news.index') }}" class="btn btn-light btn-active-light-primary me-2">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 400,
                minHeight: 400,
                maxHeight: null,
                focus: true,
                htmlMode: true,
                lineNumbers: true,
                mode: 'text/html',
                callbacks: {
                    onKeydown: function(e) {
                        e.stopPropagation();
                    }
                }
            });
        });
    </script>
@endsection