@extends('template.layout')
@section('title', 'Archive')
@section('submenuItem', 'archive')
@section('content')
    <div class="NewsHeadline">
        <div class="NewsHeadlineBackground" style="background-image:url({{ asset('/assets/tibiarl/images/news/newsheadline_background.gif') }})">
            <img src="{{ asset('/assets/tibiarl/images/news/newsicon_'. $news->category .'.gif') }}" class="NewsHeadlineIcon" alt="">
            <div class="NewsHeadlineDate">{{ date('M d Y', strtotime($news->created_at)) }} - </div>
            <div class="NewsHeadlineText">{{ $news->title }}</div>
        </div>
    </div>
    <table style="clear:both" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td><img src="{{ asset('/assets/tibiarl/images/general/blank.gif') }}" width="10" height="1" border="0" alt=""></td>
            {!! $news->body !!}
            <td><img src="{{ asset('/assets/tibiarl/images/general/blank.gif') }}" width="10" height="1" border="0" alt=""></td>
        </tr>
        @if(Auth::check() && Auth::user()->isAdmin())
            <div class="row justify-content-end">
                <div class="col-2 pr-1 px-5">
                    <a href="{{ route('admin.news.update.index', [$news->id]) }}" class="btn btn-primary">Edit</a>
                </div>
                <div class="col-2 px-1 pr-2">
                    <a href="{{ route('admin.news.delete', [$news->id]) }}" class="btn btn-primary">Delete</a>
                </div>
            </div>
        @endif
        </tbody>
    </table>
    <br>
    <br>
@endsection