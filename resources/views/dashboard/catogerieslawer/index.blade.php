@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.categories')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories') <small>{{ $categories->total() }}</small></h3>

                    <form action="{{ route('dashboard.catogerieslawer.index') }}" method="get">

                        <div class="row">


                            <div class="col-md-6">


                                    <a href="{{ route('dashboard.catogerieslawer.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>

                                    <a href="{{ route('dashboard.subcatogerieslawer.index') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.subcategory')</a>



                                {{-- @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</a> --}}

                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($categories->count() > 0)

                        <table class="table table-hover" id="table" >

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>

                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.image')</th>

                                @if (auth()->user()->hasPermission('update_categories','delete_categories'))

                                <th>@lang('site.action')</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($categories as $index=>$category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ isset($category->name) ? $category->name :'' }}</td>


                                    <td>{{isset($category->created_at) ? $category->created_at->diffForHumans() :'' }}</td>


                                    <td> <img src="{{asset('/uploads/' . $category->icons)}}" style="width:100px; height:100px"></td>

                                    <td>
{{--                                        @if (auth()->user()->hasPermission('update_categories'))--}}
                                            <a href="{{ route('dashboard.catogerieslawer.edit', $category->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        {{-- @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a> --}}
{{--                                        @endif--}}
{{--                                        @if (auth()->user()->hasPermission('delete_categories'))--}}
                                            <form action="{{ route('dashboard.catogerieslawer.destroy', $category->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form><!-- end of form -->
                                        {{-- @else
                                            <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button> --}}
{{--                                        @endif--}}
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{ $categories->appends(request()->query())->links() }}

                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
