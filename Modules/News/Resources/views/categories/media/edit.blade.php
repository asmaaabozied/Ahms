@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.news_categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.article_subcategories.index') }}"> @lang('site.news_categories')</a></li>
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

                    <form action="{{ route('dashboard.media_subcategories.update', $news_subcategory->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        @foreach($catogery_ids as $catogery_id)
                        <input type="hidden" name="news_category_id" class="form-control" value="{{$catogery_id}}" required  >
                        @endforeach
                            @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6 ">
                            @if(count(config('translatable.locales'))>1)
                                <label>@lang('site.' . $locale . '.title')</label>
                        @else
                        <label>@lang('site.title')</label>
                        @endif
                                <input type="text" name="{{ $locale }}[title]" class="form-control" value="{{ $news_subcategory->translate($locale)->title }}" >
                            </div>
                        @endforeach
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6 dis_class_1">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.' . $locale . '.content')</label>
                                @else
                                    <label>@lang('site.content')</label>
                                @endif
                                <textarea class="textarea" name="{{ $locale }}[content]" row="5"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" >{{ strip_tags($news_subcategory->translate($locale)->content) }}</textarea>
                            </div>

                        @endforeach
                        <div class="form-group col-md-12 dis_class_1">
                            <label>@lang('site.image')</label>
                            <input type="file" name="main_image" class="form-control"  accept="image/*" >
                            <img src="{{ asset('public/uploads'.'/'.$news_subcategory->main_image) }}" style="width: 100px;hight:100px" class="img-thumbnail image-preview" alt="" >
                        </div>



                        <div class="form-group col-md-12 dis_class">
                            <label>@lang('site.images')</label>
                            <input type="file" name="images[]" class="form-control" accept="image/*"
                                   multiple >
                        </div>
                        <div class="form-group col-md-12 dis_class">
                            <label>@lang('site.video_link')</label>
                            <input type="url" name="video_link" class="form-control" required >
                        </div>


                        <div class="form-group col-md-12 dis_class">
                            <label>@lang('site.source_url')</label>
                            <input type="url" name="source_url" class="form-control" required >
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
