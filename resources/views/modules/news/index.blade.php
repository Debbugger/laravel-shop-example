@extends('layouts.app')

@section('title', parseMultiLanguageString($metaTags->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($metaTags->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($metaTags->meta_description ?? ''))

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12"><h3 class="text-grey d-block mb-4">@lang('articles.title')</h3></div>
        </div>
        <div class="row">
            @forelse($articles as $article)
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a href="{{route('article',$article->slug)}}" class="article-b">
                        <div class="image" style="background: url('{{asset($article->image)}}')"></div>
                        <div class="info-b">
                            <div class="date mb-2">{{  $article->created_at->format('d.m.y')}}</div>
                            <div class="name">{{  parseMultiLanguageString($article->title ?? null)}}</div>
                            <p>{!!   parseMultiLanguageString($article->short_text ?? null)!!}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p> @lang('articles.empty')</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection