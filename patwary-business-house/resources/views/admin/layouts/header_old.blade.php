<?php

use App\Models\GeneralSetting;

$setting = GeneralSetting::get_setting();
$title = !empty($setting) ? $setting->title : '';
?>
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        @yield('extra_css_file')
        <style type="text/css">
            @yield('page_style')
        </style>

        <!--<script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>-->
        <script src="{{ asset('js/jquery-1.12.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
        @yield('extra_js_file')
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!}
        </script>
    </head>
    <body class="{{ body_class() }}">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin:0;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/home') }}"><?php echo!empty($title) ? $title : "Patwary House"; ?></a>
                </div>

                @if (!Auth::guest())
                <ul class="nav navbar-nav topnav">
                    <?php if (has_user_access('generel_setting')) : ?>
                        <li><a href="{{ url('/general-setting') }}">{{ trans('words.general_setting') }}</a></li>
                    <?php endif; ?>                        

                    <?php if (has_user_access('manage_institute')) : ?>
                        <li>
                            <a href="{{ url('/institute') }}">{{ trans('words.institute_list') }}</a>
                        </li>
                    <?php endif; ?>

                    <?php if (has_user_access('permission_accounts')) : ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('words.accounts') }}&nbsp;<i class="fa fa-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/dailyreport') }}">{{ trans('words.daily_report') }}</a></li>
                                <li><a href="{{ url('/ledger/dailysheet') }}">{{ trans('words.daily_sheet') }}</a></li>
                                <li><a href="{{ url('/head') }}">{{ trans('words.account_head') }}</a></li>
                                <li><a href="{{ url('/subhead') }}">{{ trans('words.subhead') }}</a></li>
                                <li><a href="{{ url('/particulars') }}">{{ trans('words.particular') }}</a></li>
                                <li><a href="{{ url('/ledger') }}">{{ trans('words.ledger') }}</a></li>
                                <li><a href="{{ url('/transactions') }}">{{ trans('words.all_transactions') }}</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (has_user_access('manage_user')) : ?>
                        <li>
                            <a href="{{ url('/user') }}">{{ trans('words.user_list') }}</a>
                        </li>
                    <?php endif; ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user"></i> Business List <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php if (has_user_access('permission_ricemill')) : ?>
                                <li>
                                    <a href="{{ url('/rice/') }}">{{ trans('words.ricemill') }}</a>
                                </li>                        
                            <?php endif; ?>                        
                            <?php if (has_user_access('permission_flourmill')) : ?>
                                <li>
                                    <a href="{{ url('/flour/') }}">{{ trans('words.flourmill') }}</a>
                                </li>                        
                            <?php endif; ?>
                            <?php if (has_user_access('permission_chiramill')) : ?>
                                <li>
                                    <a href="{{ url('/chira/') }}">{{ trans('words.chiramill') }}</a>
                                </li>                        
                            <?php endif; ?>
                            <?php if (has_user_access('permission_murimill')) : ?>
                                <li>
                                    <a href="{{ url('/muri/') }}">{{ trans('words.murimill') }}</a>
                                </li>                        
                            <?php endif; ?>
                            <?php if (has_user_access('permission_inventory')) : ?>
                                <li>
                                    <a href="{{ url('/inv/') }}">{{ trans('words.inventory') }}</a>
                                </li>                        
                            <?php endif; ?>
                            <?php if (has_user_access('permission_bag')) : ?>
                                <li>
                                    <a href="{{ url('/bag/') }}">{{ trans('words.bag_production') }}</a>
                                </li>                        
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
                @endif

                <ul class="nav navbar-right top-nav">
                    @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user"></i> Hi, {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/home') }}">
                                    <i class="fa fa-fw fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('user') }}/{{ Auth::user()->_key }}">
                                    <i class="fa fa-fw fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('password') }}">
                                    <i class="fa fa-fw fa-lock"></i> Change Password
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-power-off"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
