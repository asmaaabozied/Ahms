@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.cases')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.categories.index') }}"> @lang('site.categories')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->
                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.cases.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
                       <div class="row">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6">
                            @if(count(config('translatable.locales'))>1)
                                <label>@lang('site.' . $locale . '.name')</label>
                        @else
                        <label>@lang('site.name')</label>
                        @endif
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}">
                            </div>
                        @endforeach
</div>

                        <div class="row">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.number')</label>
                                @else
                                    <label>@lang('site.number')</label>
                                @endif
                                <input type="text" name="{{ $locale }}[number]" class="form-control" value="{{ old($locale . '.number') }}">
                            </div>
                        @endforeach
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6 ">
                            <label>@lang('site.users')</label>

                            <select class="form-control select2" name="user_id" id="parent" required>
{{--                                <option selected disabled>{{trans('site.select')}}</option>--}}
                                <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>

                            @foreach($users as $id => $item)
                                    <option value="{{$id}}" >{{$item}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-3 ">
{{--                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title=" {{ trans('category.fields.image_help') }}"></i> &nbsp;--}}
                            <label>@lang('site.image')</label>


                            <input type="file" onchange="readURL(this, 'ImagePreview', 'ImagePreview');" name="icons" class="form-control image" required >
                        </div>

                            <div class="form-group col-sm-3">
                                <img src="{{ asset('public/uploads/icons') }}" style="width: 100px"
                                     class="img-thumbnail image-preview" alt="">
                            </div>

                        </div>
                        <div class="row">
                            @foreach (config('translatable.locales') as $locale)
                                <div class="form-group col-md-6">
                                    @if(count(config('translatable.locales'))>1)
                                        <label>@lang('site.' . $locale . '.description')</label>
                                    @else
                                        <label>@lang('site.description')</label>
                                    @endif
                                    <textarea class="textarea" name="{{ $locale }}[description]" row="5"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old($locale . '.description') }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group col-md-6">

                                <input type="checkbox" name="status" value="1">

                                <span>@lang('site.active')</span>
                            </div>


                        </div>


                        <div class="form-group col-sm-6">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
