@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{ trans('words.general_setting') }}</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li>Setting</span></li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-xs-12 col-sm-8 col-md-8">
        <div class="gel-setting">
            {!! Form::open(['method' => 'POST', 'url' => 'update-setting', 'enctype'=>'multipart/form-data', 'class' => 'form-horizontal']) !!}
            <ul class="nav nav-tabs nav-justified" role="tablist" style="margin-bottom: 15px;">
                <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
                <li role="presentation" class=""><a href="#misc" aria-controls="misc" role="tab" data-toggle="tab" aria-expanded="false">Miscellaneous</a></li>
                <li role="presentation" class=""><a href="#logos" aria-controls="logos" role="tab" data-toggle="tab" aria-expanded="false">Logos</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="general">
                    <div class="form-group">
                        <label class="col-md-4 text-right">Site Name</label>
                        <div class="col-md-8">
                            <input class="form-control" name="site_name" type="text" value="{{ !empty($setting) ? $setting->title : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="site_description">{{ !empty($setting) ? $setting->description : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Address</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="author_address">{{ !empty($setting) ? $setting->address : '' }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right" >Author</label>
                        <div class="col-md-8">
                            <input class="form-control" name="author_name" type="text" value="{{ !empty($setting) ? $setting->owner : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Author Email</label>
                        <div class="col-md-8">
                            <input class="form-control" name="author_email" type="text" value="{{ !empty($setting) ? $setting->email : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Author Phone</label>
                        <div class="col-md-8">
                            <input class="form-control" name="author_phone" type="text" value="{{ !empty($setting) ? $setting->phone : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Author Mobile</label>
                        <div class="col-md-8">
                            <input class="form-control" name="author_mobile" type="text" value="{{ !empty($setting) ? $setting->mobile : ''  }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Other Contacts</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="other_contacts">{{ !empty($setting) ? $setting->other_contact : '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="misc">
                    <div class="form-group">
                        <label class="col-md-4 text-right">Item Per Page</label>
                        <div class="col-md-8">
                            <input class="form-control" name="pagesize" type="text" value="{{ !empty($setting) ? $setting->pagesize : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right">Copyright Text</label>
                        <div class="col-md-8">
                            <input class="form-control" name="copyright" type="text" value="{{ !empty($setting) ? $setting->copyright : '' }}">
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="logos">
                    <div class="form-group">
                        <label class="col-md-4 text-right" for="Settings_favicon">Favicon</label>
                        <div class="col-md-8">
                            <input class="form-control" name="favicon" type="file">
                        </div>
                        <div class="col-md-8 col-md-offset-4" style="margin-top: 15px;">
                            <div class="thumbnail" style="margin-bottom:0;padding:15px;position:relative;">
                                @if (!empty($setting->favicon))
                                <a class="icon_del remove_img" rel="favicon" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
                                <img class="img-circle auto_img" rel="favicon" src="{{ asset('uploads') }}/{{$setting->favicon }}" style="max-height: 60px;">
                                @else
                                <img class="img-circle auto_img" rel="favicon" src="{{ asset('img/no_photo.gif') }}" style="max-height: 120px;" alt="No Image">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 text-right" for="Settings_logo">Logo</label>
                        <div class="col-md-8">
                            <input class="form-control" type="file" name="logo">
                        </div>
                        <div class="col-md-8 col-md-offset-4" style="margin-top: 15px;">
                            <div class="thumbnail" style="margin-bottom:0;padding:15px;position:relative;">
                                @if (!empty($setting->logo))
                                <a class="icon_del remove_img" rel="logo" href="javascript:void(0);" data-info="logo.png"><i class="fa fa-trash-o"></i></a>
                                <img class="img-circle auto_img" rel="logo" src="{{ asset('uploads') }}/{{$setting->logo}}" style="max-height: 120px;" alt="Image not found">
                                @else
                                <img class="img-circle auto_img" rel="logo" src="{{ asset('img/no_photo.gif') }}" style="max-height: 120px;" alt="No Image">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input class="form-control" name="hid" value="{{ !empty($setting) ? $setting->id : '' }}" type="hidden">
                    </div>
                </div>
            </div>

            <div class="mb_10 clearfix">
                <div class="text-center">
                    <input class="btn btn-primary xsw_100" name="submitSettings" type="submit" value="Save">
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection