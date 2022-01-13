@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.jobs')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.jobs')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.jobs') <small>{{ $jobs->total() }}</small></h3>

                    <form action="{{ route('dashboard.jobs.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
{{--                               @if (auth()->user()->hasPermission('create_jobs'))--}}

                                    <a href="{{ route('dashboard.jobs.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
{{--                               @else--}}
{{--                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>--}}
{{--                               @endif--}}
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($jobs->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>

                                <th>@lang('site.email')</th>

                                <th>@lang('site.jobs')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.file')</th>
                                <th>@lang('site.action')</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($jobs as $index=>$job)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $job->name }}</td>
                                    <td>{{ $job->phone }}</td>
                                    <td>{{ $job->email }}</td>
                                    <td>{{isset($job->catogeryjob->name) ? $job->catogeryjob->name:'' }}</td>
                                    <td>{{ $job->created_at	 }}</td>
                                    <td>

                                        <form action="{{ route('dashboard.jobs.status', $job->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}

                                            @if( $job->status==1)
                                                <button type="submit" class="btn btn-success update btn-sm">
                                                    <i class="fa fa-check"></i> @lang('site.open')
                                                </button>
                                            @elseif( $job->status==0)
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-close"></i> @lang('site.close')
                                                </button>
                                            @endif

                                        </form>

                                    </td>

                                    @php

                                        $pro=App\Image::where('imageable_type','App\Job')->where('imageable_id',$job->id)->first();
                                    @endphp
{{--                                    <td> <img src="{{isset($pro->image)?asset('uploads/' . $pro->image):''}}" style="width:100px; height:100px"></td>--}}
                                      <td><a href="{{isset($pro->image)?asset('uploads/' . $pro->image):''}}">{{isset($pro->image)?$pro->image :''}}</a></td>

                                    <td>
{{--                                        @if (auth()->user()->hasPermission('edit_jobs'))--}}

                                            <a href="{{ route('dashboard.jobs.edit', $job->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
{{--                                        @else--}}
{{--                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>--}}
{{--                                        @endif--}}
{{--                                            @if (auth()->user()->hasPermission('delete_jobs'))--}}


                                            <form action="{{ route('dashboard.jobs.destroy', $job->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
{{--                                        @else--}}
{{--                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>--}}
{{--                                            @endif--}}
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->





                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
