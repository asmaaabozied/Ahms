@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.consultation')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.consultations.index') }}"> @lang('site.consultation')</a></li>
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

                    <form action="{{ route('dashboard.consultations.update', $consultation->id) }}" enctype="multipart/form-data" method="post">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="row">
                            <div class="form-group ">

                                @foreach (config('translatable.locales') as $locale)
                                    <div class="form-group col-md-6">
                                        @if(count(config('translatable.locales'))>1)
                                            <label>@lang('site.' . $locale . '.name')</label>
                                        @else
                                            <label>@lang('site.name')</label>
                                        @endif
                       <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ isset($consultation->translate($locale)->name) ? $consultation->translate($locale)->name :'' }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="row">
                        <div class="form-group col-lg-6 ">
                            <label>@lang('site.contact_type')</label>
                            <select id="contact_type" name="typeconslution_id" class="form-control" required>
                                <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>
                                @foreach( $types as $key => $value)
                                    <option value="{{$key}}" @if($consultation->typeconslution_id ==$key) selected @endif>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                            <div class="form-group col-lg-6 ">
                                <label>@lang('site.users')</label>
                                <select id="contact_type" name="user_id" class="form-control" required>
                                    <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>
                                    @foreach( $users as $key => $value)
                                        <option value="{{$key}}" @if($consultation->user_id ==$key) selected @endif>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="row">
                        <div class="form-group col-lg-6 ">
                            <label>@lang('site.status')</label>
                            <select id="contact_type" name="status" class="form-control" required>
                                <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>
                                @foreach( consultation_status_type as $key => $value)
                                    <option value="{{$key}}" @if($consultation->status ==$key) selected @endif>
                                        {{$value}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                            <div class="form-group col-lg-6 ">
                                <label>@lang('site.videoconslutions')</label>
                                <select id="contact_type" name="videoconslution_id" class="form-control" required>
                                    <option value="" disabled selected hidden>@lang('site.pleaseChoose')  ... </option>
                                    @foreach( $videos as $key => $value)
                                        <option value="{{$key}}" @if($consultation->videoconslution_id ==$key) selected @endif>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group ">

                                @foreach (config('translatable.locales') as $locale)
                                    <div class="form-group col-md-6">
                                        @if(count(config('translatable.locales'))>1)
                                            <label>@lang('site.' . $locale . '.price')</label>
                                        @else
                                            <label>@lang('site.price')</label>
                                        @endif
                                        <input type="number" name="{{ $locale }}[price]" class="form-control" value="{{ isset($consultation->translate($locale)->price) ? $consultation->translate($locale)->price :'' }}">
                                    </div>
                                @endforeach

                            </div>

{{--                            <div class="form-group col-lg-6">--}}
{{--                                <label>@lang('site.price')</label>--}}
{{--                                <input type="number" name="price" class="form-control"   value="{{ $consultation->price }}"   >--}}
{{--                            </div>--}}




{{--                        <div class="form-group col-lg-6">--}}
{{--                            <label>@lang('site.file_attachment')</label>--}}
{{--                            <input type="file" name="images[]" class="form-control" accept="image/*"  multiple="multiple"  >--}}

{{--                            <a href="{{ asset('storage/app/public/'.consultation_files.$consultation->file_attachment) }}" download>@lang('site.download_file')</a>--}}

{{--                        </div>--}}


                        </div>

                        <div class="row">
                            <div class="form-group ">

                                @foreach (config('translatable.locales') as $locale)
                                    <div class="form-group col-md-6">
                                        @if(count(config('translatable.locales'))>1)
                                            <label>@lang('site.' . $locale . '.description')</label>
                                        @else
                                            <label>@lang('site.description')</label>
                                        @endif
{{--                                            {{ isset($consultation->translate($locale)->name) ? $consultation->translate($locale)->name :'' }}--}}
                                        <textarea class="textarea" name="{{ $locale }}[description]" row="5"
                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{(strip_tags(isset($consultation->translate($locale)->description))? $consultation->translate($locale)->description :'') }}</textarea>
                                    </div>
                                @endforeach

                            </div>
                        </div>

<div class="row">
                        <div class="form-group col-lg-6">
                            <label >{{__('site.consultation_details')}}</label>

                            <textarea class="textarea" name="details"   row="5"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required>{{ $consultation->details }}</textarea>

                        </div>
</div>

{{--                        <div class="form-group">--}}
{{--                            <label>@lang('site.payment_type')</label>--}}
{{--                            <input type="text" name="payment_type" class="form-control"   value="{{ $consultation->payment_type }}"   >--}}
{{--                        </div>--}}
                        <div class="row">
                        <div class="form-group col-lg-3 ">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
<script>
    $(document).ready(function() {
        $('.textarea').summernote({
            // set editor height
            minHeight: 300,             // set minimum height of editor
            // maxHeight: 300,
        });
    });
</script>
