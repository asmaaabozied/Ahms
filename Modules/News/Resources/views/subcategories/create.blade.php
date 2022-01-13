@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.list')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
                    </a></li>
                <li><a href="{{ route('dashboard.news_subcategories.index') }}"> @lang('site.list')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>
        @php
            $dis_att1=' ';
            $dis_att=' ';
        @endphp
        @if($category->type=="news" or $category->type=="articles")
        @php($dis_att=' disabled')
        <style>
            .dis_class {
                display: none;
            }
        </style>
{{--        @else--}}
{{--            @php($dis_att1=' disabled')--}}
{{--            <style>--}}
{{--                .dis_class_1 {--}}
{{--                    display: none;--}}
{{--                }--}}
{{--            </style>--}}
            {{--        @elseif($category->type=="news" or $category->type=="articles"){--}}

            {{--        }--}}
        @endif
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.news_subcategories.store') }}" method="post"
                          enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.' . $locale . '.title')</label>
                                @else
                                    <label>@lang('site.title')</label>
                                @endif
                                <input type="text" name="{{ $locale }}[title]" class="form-control"
                                       value="{{ old($locale . '.title') }}" required>
                            </div>
                        @endforeach
                        <input type="hidden" name="news_category_id" class="form-control" value="{{$category->id}}"
                               required>

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6 dis_class_1">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.' . $locale . '.content')</label>
                                @else
                                    <label>@lang('site.content')</label>
                                @endif
                                <textarea class="textarea" name="{{ $locale }}[content]" row="5"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old($locale . '.content') }}</textarea>
                            </div>

                        @endforeach
                        <div class="form-group col-md-12 dis_class_1">
                            <label>@lang('site.image')</label>
                            <input type="file" name="main_image" class="form-control"  required>
                        </div>
                        <div class="form-group col-md-12 dis_class">
                            <label>@lang('site.images')</label>
                            <input type="file" name="images_slider[]" class="form-control" accept="image/*"
                                   multiple {{$dis_att}}>
                        </div>
                        <div class="form-group col-md-12 dis_class">
                            <label>@lang('site.video_link')</label>
                            <input type="url" name="video_link" class="form-control" required {{$dis_att}}>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')
                            </button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

