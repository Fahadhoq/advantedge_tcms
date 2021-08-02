<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>advantedge tcms</title>
    <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Morris Chart CSS for all blade -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- Morris Chart CSS for all blade end-->


    <!-- jquery-confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!-- jquery-growl -->
    <link href="{{URL::to('assets/jquery-growl/stylesheets/jquery.growl.css')}}" rel="stylesheet" type="text/css" />
    
    
    @yield('css')

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        @include('layouts.partials.dashboard-navbar')
        <!-- Top Bar End -->
          
        <!-- side bar -->
        @include('layouts.partials.dashboard-sidebar')
        <!-- side bar end -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        
        @yield('container')
        
        <!-- footer start -->
        @include('layouts.partials.dashboard-footer')
        <!-- footer end -->

        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- add jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
   <!-- for all balde jquery -->
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.min.js"></script>

    <!--Morris Chart-->
    <script src="../plugins/morris/morris.min.js"></script>
    <script src="../plugins/raphael/raphael.min.js"></script>

    <script src="assets/pages/dashboard.init.js"></script>
    
    <!-- add page wise jquery link -->
    @yield('jquery')
    <!-- add page wise js link end -->

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- for all balde jquery end -->

    <!-- jquery-confirm -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
     
     <!-- jquery-growl -->
    <script src="{{URL::to('assets/jquery-growl/javascripts/jquery.growl.js')}}" type="text/javascript"></script>
    
    
    
     
     @yield('script')

</body>

</html>