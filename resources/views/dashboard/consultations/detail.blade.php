@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.consultations')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.detailcases')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users') </h3>

                    <table class="table table-hover">
                    <thead>
               <tr>
                 <th>#</th>
                <th>@lang('site.name')</th>
               <th>@lang('site.email')</th>
               <th>@lang('site.phone')</th>
              <th>@lang('site.status')</th>
              <th>@lang('site.created_at')</th>
             <th>@lang('site.image')</th>

            </tr>
               </thead>

                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>{{$user->name}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->phone}}</th>
                            <th>

                @if($user->status==1)

                 <i class="btn btn-primary">  @lang('site.open')</i>
                 @else
                <i class="btn btn-danger">   @lang('site.close') </i>
             @endif

                            </th>
                            <th>{{$user->created_at}}</th>
                            <th>
                           <img src="{{asset('uploads/'.$user->image)}}" style="width:200px; height:100px">

                            </th>


                        </tr>


                        </tbody>
                    </table>



                </div><!-- end of box header -->
<hr>
                <div class="btn btn-primary form-control align-content-lg-center">


                </div>




            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
