@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.videoconslutions')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.videoconslutions')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.videoconslutions') <small>{{ $consultations->total() }}</small></h3>

                    <form action="{{ route('dashboard.videoconsultations.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
{{--                                @if (auth()->user()->hasPermission('create_consultations'))--}}

                                   <a href="{{ route('dashboard.videoconsultations.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
{{--                                --}}{{-- @else--}}
{{--                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a> --}}
{{--                                @endif--}}
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($consultations->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.image')</th>
                                @if (auth()->user()->hasPermission('update_consultations','delete_consultations'))

                                <th>@lang('site.action')</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($consultations as $index=>$value)

                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $value->name }}</td>
{{--                                    @foreach(contact_type as $key=>$value_2)--}}
{{--                                        @if($value->cotact_type==$key)--}}
{{--                                        <td>{{ $value_2 }}</td>--}}
{{--                                        @endif--}}
{{--                                       @endforeach--}}
                                    <td>    <form action="{{ route('dashboard.videoconsultations.status', $value->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}


                                            @if( $value->status==1)
                                                <button type="submit" class="btn btn-success update btn-sm">
                                                    <i class="fa fa-check"></i> @lang('site.open')
                                                </button>
                                            @elseif( $value->status==0)
                                                <button type="submit" class="btn btn-danger update btn-sm">
                                                    <i class="fa fa-close"></i> @lang('site.close')
                                                </button>
                                            @endif

                                        </form><!-- end of form -->
                                    </td>


                                    <td>{{ isset($value->created_at) ? $value->created_at->diffForHumans() :''	 }}</td>


                                    <td><img src="{{asset('uploads/'.$value->image)}}" style="width:100px; height:100px"></td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_consultations'))
                                            <a href="{{ route('dashboard.videoconsultations.edit', $value->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        {{-- @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a> --}}
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_consultations'))
                                            <form action="{{ route('dashboard.videoconsultations.destroy', $value->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
                                        {{-- @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button> --}}
                                        @endif
                                    </td>


                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{ $consultations->appends(request()->query())->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
