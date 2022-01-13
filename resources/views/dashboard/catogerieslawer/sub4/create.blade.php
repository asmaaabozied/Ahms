@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.subcategory')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.catogery.index') }}"> @lang('site.subcategory')</a></li>
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

                    <form action="{{ route('dashboard.subcatogerieslawer4.store') }}" method="post" enctype="multipart/form-data">

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


                        <div class="form-group">
                            <label>@lang('site.categories')</label>
                            <select class="form-control select2 parent2" name="parent_id" id="parent2" required>
                                <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>
                                {{--                                <option selected disabled>{{trans('site.select')}}</option>--}}
                                @foreach($catogeries as $id => $item)
                                    <option value="{{$id}}" >{{$item}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="row">


                        <div class="form-group col-md-6">
                            <label>@lang('site.file')</label>
                           <input type="file" name="file" class="form-control image">

                        </div>


                            <div class="form-group col-sm-3">
                                <img src="{{ asset('public/uploads/file') }}" style="width: 100px"
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>






                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
