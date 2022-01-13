@extends('layouts.dashboard.app')

@section('content')

    <link rel="stylesheet" href="{{ asset('public/dashboard_files/css/AdminLTE.min.css') }}">
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.massages')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.amenities.index') }}"> @lang('site.massages')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.show')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-md-12">
                                    <!-- Box Comment -->
                                    <div class="card card-widget">

                                        <!-- /.card-header -->
                                        <div class="card-body">


                                            <!-- Attachment -->
                                            <div   style="padding: 10px;
    margin: 10px;
    background: #f7f7f7;">

                                                <div class="attachment-pushed">
                                                    <h4 class="attachment-heading" style="color:#0f74a8"><i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                                                        {{$massage->from_name}}</h4>
                                                    <h6 class="attachment-heading" style="color:#0f74a8;  float: right;"><i class="fa fa-calendar" aria-hidden="true"></i>
                                                        {{$massage->updated_at}}</h6>
                                                    <div class="attachment-text">
                                                        {{$massage->massages}}
                                                    </div>
                                                    <!-- /.attachment-text -->
                                                </div>
                                                <!-- /.attachment-pushed -->
                                            </div>
                                            <!-- /.attachment-block -->

                                        </div>
                                        <!-- /.card-body -->


                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->


                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
