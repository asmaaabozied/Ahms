@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.consultations')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.consultations')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.consultations') <small>{{ $consultations->total() }}</small></h3>



                        <div class="row">


                            <div class="col-md-4">

                                @if (auth()->user()->hasPermission('create_consultations'))

                                    <a href="{{ route('dashboard.consultations.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                 @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @endif
                            </div>

                        </div>

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($consultations->count() > 0)

                        <table class="table table-hover" id="table">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.users')</th>
{{--                                <th>@lang('site.name')</th>--}}
{{--                                <th>@lang('site.price')</th>--}}
                                <th>@lang('site.typeconslutions')</th>
                                <th>@lang('site.videoconslutions')</th>
{{--                                <th>@lang('site.contact_type')</th>--}}
                                <th>@lang('site.status')</th>
                                @if (auth()->user()->hasPermission('update_consultations','delete_consultations'))

                                <th>@lang('site.action')</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($consultations as $index=>$value)

                                <tr>
                                    <td>{{ $index + 1 }}</td>


                                    <td>
                                        <a href="{{ route('dashboard.users.details', $value->id) }}">
                                        {{ isset($value->user->name)?$value->user->name :'' }}
                                    </td>
{{--                                    <td>{{ isset($value->name)? $value->name :'' }}</td>--}}
{{--                                    <td>{{isset($value->price) ?  $value->price :'' }}</td>--}}

                                    <td>{{isset($value->typeconsultation->name) ?$value->typeconsultation->name :'' }}</td>
                                    <td>{{isset($value->videoconsultation->name) ? $value->videoconsultation->name:'email' }}</td>
{{--                                    @foreach(contact_type as $key=>$value_2)--}}
{{--                                        @if($value->cotact_type==$key)--}}
{{--                                        <td>{{ $value_2 }}</td>--}}
{{--                                        @endif--}}
{{--                                       @endforeach--}}
                                    <td>    <form action="{{ route('dashboard.Consultations.status', $value->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}

                                            @if( $value->status=="finished")
                                                <input type="hidden" name="status" value="finished">
                                                <input type="hidden" name="id" value="{{$value->id}}">
                                                <button type="submit" class="btn btn-success update btn-sm">
                                                    <i class="fa fa-check"></i> @lang('site.finished')
                                                </button>
                                            @elseif( $value->status=="reply")
                                                <input type="hidden" name="status" value="reply">
                                                <input type="hidden" name="id"  value="{{$value->id}}">
                                                <button type="submit" class="btn btn-info update btn-sm">
                                                    <i class="fa fa-reply"></i> @lang('site.reply')
                                                </button>
                                            @elseif( $value->status=="waiting")
                                                <input type="hidden" name="status" value="waiting">
                                                <input type="hidden" name="id"  value="{{$value->id}}">
                                                <button type="submit" class="btn btn-warning update btn-sm">
                                                    <i class="fa fa-info-circle"></i> @lang('site.waiting')
                                                </button>
                                            @endif

                                        </form><!-- end of form -->
                                    </td>
                                    <td>

                                        @if (auth()->user()->hasPermission('update_consultations'))
                                            <a href="{{ route('dashboard.consultations.show', $value->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> @lang('site.show')</a>

                                        @endif

                                        @if (auth()->user()->hasPermission('update_consultations'))
                                            <a href="{{ route('dashboard.consultations.edit', $value->id) }}" class="btn btn-info btn-sm"><i class="fa fa-envelope"></i> @lang('site.sendemail')</a>
                                         @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete_consultations'))
                                            <form action="{{ route('dashboard.consultations.destroy', $value->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
                                         @else
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
