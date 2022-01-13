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

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.consultations') </h3>

                    <table class="table table-hover">
                    <thead>
               <tr>
                 <th>#</th>
                <th>@lang('site.description')</th>




            </tr>
               </thead>

                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>{{$consulations->details}}</th>



                        </tr>


                        </tbody>
                    </table>



                </div><!-- end of box header -->
<hr>
                <div class="btn btn-primary form-control align-content-lg-center">


                </div>



                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('site.file')</th>

                        <th>@lang('site.created_at')</th>

                        <th>@lang('site.download')</th>


                    </tr>
                    </thead>

                    <tbody>
                    @foreach($images as $image)
                    <tr>
                        <th>#</th>


                        <td>
                            <a href="{{asset('uploads/' . $image->image)}}">
                       {{$image->image}}
                            </a>

                        </td>
                        <td> {{isset($image->created_at) ? $image->created_at->diffForHumans() :'' }}</td>

                        <td>
    <button>

     <a  href="{{ route('dashboard.download_file.downloadSingleFile', $image->id) }}" class="fa fa-download fa-1.9x"> @lang('site.download')

       </a> </button>

                        </td>

                        @endforeach

                    </tr>


                    </tbody>
                </table>





            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
