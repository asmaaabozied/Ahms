@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.catogery.index') }}"> @lang('site.categories')</a></li>
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

                    <form action="{{ route('dashboard.catogerieslawer.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}
<div class="row">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group col-sm-6">
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
                        <div class="form-group col-sm-6">
                            <label>@lang('site.image')</label>
                            <input type="file" name="icons" class="form-control image" >

                        </div>

                        <div class="form-group col-sm-6">
                            <img src="{{ asset('public/uploads/icons') }}" style="width: 100px"
                                 class="img-thumbnail image-preview" alt="">
                        </div>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                        </div>




                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
