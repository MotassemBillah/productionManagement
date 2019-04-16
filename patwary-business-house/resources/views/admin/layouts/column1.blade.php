@include('admin.layouts.header')

@include('admin.layouts.notification')

<div id="body_panel" style="">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

@include('admin.layouts.footer')