@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.jobs')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.jobs.index') }}"> @lang('site.jobs')</a></li>
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

                    <form action="{{ route('dashboard.jobs.update', $job->id) }}" method="post"  enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}
<div class="row">
                        <div class="form-group col-md-6">

                            <label>@lang('site.name')</label>

                            <input type="text" name="name" class="form-control" value="{{$job->name}}" >
                        </div>


                        <div class="form-group col-md-6">

                            <label>@lang('site.phone')</label>

                            <input type="text" name="phone" class="form-control" value="{{$job->phone}}" >
                        </div>
</div>
  <div class="row">

                        <div class="form-group col-md-6">

                            <label>@lang('site.email')</label>

                            <input type="text" name="email" class="form-control" value="{{$job->email}}" >
                        </div>

                        <div class="form-group col-md-6">

                            <label>@lang('site.jobs')</label>

                            <input type="text" name="job" class="form-control"  value="{{$job->job}}">
                        </div>
  </div>

<div class="row">
                        <div class="form-group col-md-6">

                            <label>@lang('site.users')</label>

                            <select class="form-control select2" name="user_id" id="parent" required>
                                <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>

{{--                                <option selected disabled>{{trans('site.select')}}</option>--}}
                                @foreach($users as $id => $item)
                                    <option value="{{$id}}" >{{$item}}</option>
                                @endforeach
                            </select>

                        </div>

    <div class="form-group col-md-6">

        <label>@lang('site.categories')</label>

        <select class="form-control select2" name="catogeryjob_id" id="parent" required>
            <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>

{{--            <option selected disabled>{{trans('site.select')}}</option>--}}
            @foreach($catogeries as $id => $item)
                <option value="{{$id}}" >{{$item}}</option>
            @endforeach
        </select>

    </div>

    <div class="row">
                        <div class="form-group col-md-6">
                            <br>
                            <input type="file" id="file" multiple="multiple" class="file-input form-control" accept="image/*"
                                   name="images[]">
                        </div>




</div>


                        <div class="form-group col-md-6">

                            <label>@lang('site.description')</label>
                            <textarea  name="description" class="form-control" id="editor" rows="11" cols="80" value="{{$job->description}}" ></textarea>
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
