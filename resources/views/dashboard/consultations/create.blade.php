@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.consultations')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.consultations.index') }}"> @lang('site.consultations')</a></li>
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

                    <form action="{{ route('dashboard.consultations.store') }}" enctype="multipart/form-data" method="post">

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
                                    <label>@lang('site.' . $locale . '.price')</label>
                                @else
                                    <label>@lang('site.price')</label>
                                @endif
                                <input type="text" name="{{ $locale }}[price]" class="form-control" value="{{ old($locale . '.price') }}">
                            </div>
                        @endforeach
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">

                                <label>@lang('site.users')</label>

                                <select class="form-control select2" name="user_id" id="parent">
                                    <option selected disabled>{{trans('site.select')}}</option>
                                    @foreach($users as $id => $item)
                                        <option value="{{$id}}" >{{$item}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-md-6">

                                <label>@lang('site.typeconslutions')</label>

                                <select class="form-control select2" name="typeconslution_id" id="parent">
                                    <option selected disabled>{{trans('site.select')}}</option>
                                    @foreach($types as $id => $item)
                                        <option value="{{$id}}" >{{$item}}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">

                                <label>@lang('site.videoconslutions')</label>

                                <select class="form-control select2" name="videoconslution_id" id="parent">
                                    <option selected disabled>{{trans('site.select')}}</option>
                                    @foreach($videos as $id => $item)
                                        <option value="{{$id}}" >{{$item}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-md-6">

                                <label>@lang('site.details')</label>

                            <input type="text" name="details" class="form-control">

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

{{--<div class="row">--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label class="col-form-label">   @lang('site.images')</label>--}}



{{--                                <input type="file" id="file" multiple="multiple" class="file-input form-control" accept="image/*"--}}
{{--                                       name="images[]">--}}
{{--                        </div>--}}


{{--                        </div>--}}



                        {{--<div class="row">--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>@lang('site.images')</label>--}}
{{--                            <input type="file" class="form-control"  name='images[]'>--}}
{{--                        </div>--}}
{{--</div>--}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
<script src="{{ asset('public/dashboard_files/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.textarea').summernote({
            // set editor height
            minHeight: 300,             // set minimum height of editor
            // maxHeight: 300,
        });
        $('.textarea')
    });
</script>
