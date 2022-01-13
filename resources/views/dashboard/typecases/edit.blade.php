@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.cases')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.cases.index') }}"> @lang('site.cases')</a></li>
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


                    <form action="{{ route('dashboard.typecases.update', $type->id) }}" method="post" enctype="multipart/form-data">


                        {{ csrf_field() }}
                        {{ method_field('put') }}
<div class="row">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6 ">
                            @if(count(config('translatable.locales'))>1)
                                <label>@lang('site.' . $locale . '.name')</label>
                        @else
                        <label>@lang('site.name')</label>
                        @endif
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $type->translate($locale)->name }}">
                            </div>
                        @endforeach


</div>

                        <div class="row">
                            <div class="form-group col-md-6 ">

                                <label>@lang('site.cases')</label>
                                <select class="form-control select2" name="lawercase_id" id="parent" required>
                                    <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>

                                    @foreach($cases as $id => $item)
                                        <option value="{{$id}}" @if($type->lawercase_id ==$id) selected @endif>{{$item}}</option>

                                    @endforeach
                                </select>
                            </div>

{{--                        <div class="form-group col-sm-6 ">--}}
{{--                            <label>@lang('site.image')</label>--}}
{{--                            <input type="file" onchange="readURL(this, 'ImagePreview', 'ImagePreview');" name="file" id="image" @if(! isset($category)) required @endif>--}}
{{--                        </div>--}}


                            <div class="form-group col-md-6">
                                <label>@lang('site.images')</label>
                                <input type="file" class="form-control"  name='images[]'>
                            </div>
                        </div>
                            <div class="row">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-md-6 ">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.' . $locale . '.description')</label>
                                @else
                                    <label>@lang('site.description')</label>
                                @endif

                                <textarea class="textarea" name="{{ $locale }}[description]" row="5"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $type->translate($locale)->description }}</textarea>                            </div>
                        @endforeach
                            </div>


                        <div class="row">
                            <div class="form-group col-md-6">

                                <input type="checkbox" name="status" value="1">

                                <span>@lang('site.active')</span>
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
