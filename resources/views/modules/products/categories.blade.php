@extends('layouts.app')

@section('title', parseMultiLanguageString($category->meta_title ?? ''))
@section('keywords', parseMultiLanguageString($category->meta_keywords ?? ''))
@section('description', parseMultiLanguageString($category->meta_description ?? ''))

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12"><h3 class="text-grey d-block mb-4">{{  $name ?? null}}</h3></div>
        </div>
        <div class="row">
            @foreach($categoriesIn as $category)
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <a href="{{route('productCategory',$category->slug)}}" class="article-b">
                        <div class="image category-image" style="background: url('{{asset($category->image)}}')"></div>
                        <div class="info-b">
                            <div class="name text-center">{{  parseMultiLanguageString($category->name ?? null)}}</div>
                            <p>{!!   parseMultiLanguageString($category->description ?? null)!!}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


@endsection