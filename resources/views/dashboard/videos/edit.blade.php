@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.videoconslutions')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.videoconsultations.index') }}"> @lang('site.videoconslutions')</a></li>
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

                    <form action="{{ route('dashboard.videoconsultations.update', $consultation->id) }}" enctype="multipart/form-data" method="post">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

{{--                        <div class="form-group">--}}
{{--                            <label>@lang('site.name')</label>--}}
{{--                            <input type="text" name="user_name" class="form-control" value="{{ $consultation->user->name }}"  readonly>--}}
{{--                            <input type="hidden" name="user_id" class="form-control" value="{{ $consultation->user->id }}"  readonly>--}}

{{--                            --}}
{{--                            --}}
{{--                        </div>--}}

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-lg-12">
                                @if(count(config('translatable.locales'))>1)
                                    <label>@lang('site.' . $locale . '.name')</label>
                                @else
                                    <label>@lang('site.name')</label>
                                @endif
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $consultation->translate($locale)->name }}">
                            </div>
                        @endforeach

                        <div class="form-group col-md-6 ">

                            <label>@lang('site.image')</label>


                            <input type="file" onchange="readURL(this, 'ImagePreview', 'ImagePreview');" name="image" class="form-control image" >
                        </div>

                        <div class="form-group col-md-6">
                            <img src="{{ asset('public/uploads/image') }}" style="width: 100px"
                                 class="img-thumbnail image-preview" alt="">
                        </div>
                        <br>
                        <div class="form-group col-md-12">

                            <input type="checkbox" name="status" value="1">

                            <span>@lang('site.active')</span>
                        </div>


                        <div class="form-group col-lg-12 ">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection

