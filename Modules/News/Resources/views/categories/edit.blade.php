@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.news_categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.news_categories.index') }}"> @lang('site.news_categories')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.news_categories.update', $news_category->id) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                            @if(count(config('translatable.locales'))>1)
                                <label>@lang('site.' . $locale . '.title')</label>
                        @else
                        <label>@lang('site.title')</label>
                        @endif
                                <input type="text" name="{{ $locale }}[title]" class="form-control" value="{{ $news_category->translate($locale)->title }}">
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>@lang('site.type_list')</label>

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="type" value="list" @if($news_category->type=="list") checked @endif>
                                <label for="customRadio1" class="custom-control-label">@lang('site.list')</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="type"  value="video" @if($news_category->type=="video") checked @endif>
                                <label for="customRadio2" class="custom-control-label">@lang('site.Video')</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="type"  value="news" @if($news_category->type=="video") checked @endif>
                                <label for="customRadio2" class="custom-control-label">@lang('site.news')</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="type"  value="articles" @if($news_category->type=="video") checked @endif>
                                <label for="customRadio2" class="custom-control-label">@lang('site.articles')</label>
                            </div>

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
