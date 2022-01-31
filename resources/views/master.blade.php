<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tcon Cost</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="icon" href="{{ asset('/logo.jpg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @yield('header')
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown ">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="fa fa-home"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @foreach(auth()->user()->to_branchs as $to_branch)
                        <a href="/auth/user/checkout/tobranch/{{$to_branch->id}}" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                @if($to_branch->branch->logo)
                                <img src="{{ Storage::disk('spaces')->url($to_branch->branch->logo) }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                @else
                                <img src="/home.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                @endif
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        @if($to_branch->branch_id == auth()->user()->branch_id)<span class="float-right text-sm text-danger"><i class="fas fa-star"></i>@else <span class="float-right text-sm"> <i class="fa fa-star-o"></i>@endif</span>
                                    </h3>
                                    <p class="text-sm">{{$to_branch->branch->company}}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$to_branch->branch->company_eng}}</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-center">
                            <i class="fa fa-share-square mr-2"></i> ออกจากระบบ
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-danger">

            <a href="/admin/index3.html" class="brand-link">
                @if(auth()->user()->branch)
                <img src="{{ auth()->user()->branch->logo ? Storage::disk('spaces')->url(auth()->user()->branch->logo) : '/home.jpg' }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{auth()->user()->branch->name}}</span>
                @else
                <img src="{{ asset('/home.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">ยังไม่ได้เลือกบริษัท</span>
                @endif
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if(auth()->user()->photo)
                        <img src="{{ Storage::disk('spaces')->url(auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
                        @else
                        <img src="/user.jpg" class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{auth()->user()->name}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/project" class="nav-link {{ (request()->is('project')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-home"></i>
                                <p>
                                    โครงการ
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-success"><i class="fas fa-caret-down"></i> งานขาย</li>

                        <li class="nav-item">
                            <a href="/sale/quotations" class="nav-link {{ (request()->is('sale/quotations')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-clipboard"></i>
                                <p>
                                    เสนอราคา
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/project/invoices" class="nav-link {{ (request()->is('project/invoices')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-file-text"></i>
                                <p>
                                    ใบแจ้งหนี้
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/receipt-ars" class="nav-link {{ (request()->is('receipt-ars')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-file-text-o"></i>
                                <p>
                                    ใบเสร็จ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/tax-invoices" class="nav-link {{ (request()->is('tax-invoices')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-bookmark"></i>
                                <p>
                                    ใบกำกับภาษี
                                </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-success"><i class="fas fa-caret-down"></i> จัดซื้อ</li>
                        <li class="nav-item">
                            <a href="/ask-price" class="nav-link {{ (request()->is('ask-price') ? 'active' : '' ) }}">
                                <i class="nav-icon fa fa-money"></i>
                                <p>ขอราคา</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (request()->is('ask-price') ? 'active' : '' ) }} {{ (request()->is('ask-price/create') ? 'active' : '' ) }} {{ (request()->is('ask-price/expired') ? 'active' : '' ) }}">
                    <i class="nav-icon fa fa-money"></i>
                    <p>
                        ขอราคา
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (request()->is('ask-price') ? 'block' : '' ) }} {{ (request()->is('ask-price/create') ? 'block' : '' ) }} {{ (request()->is('ask-price/expired') ? 'block' : '' ) }};">
                    <li class="nav-item">
                        <a href="/ask-price" class="nav-link {{ (request()->is('ask-price') ? 'active' : '' ) }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายการ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ask-price/expired" class="nav-link {{ (request()->is('ask-price/expired') ? 'active' : '' ) }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายการที่หมดอายุ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ask-price/create" class="nav-link {{(request()->is('ask-price/create') ? 'active' : '')}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>สร้าง</p>
                        </a>
                    </li>
                </ul>
            </li> -->
                        <li class="nav-item">
                            <a href="/po/search_report?types%5B%5D=PO&types%5B%5D=SC&project_id=&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{(request()->is('po/search_report') ? 'active' : '')}}">
                                <i class="nav-icon fa fa-pencil-square-o"></i>
                                <p>สั่งซื้อ</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link  {{ (request()->is('po/report') ? 'active' : '' ) }} {{ (request()->is('po') ? 'active' : '' ) }} {{ (request()->is('po/create') ? 'active' : '' ) }} {{ (request()->is('po/reject') ? 'active' : '' ) }} {{ (request()->is('po/approve') ? 'active' : '' ) }} {{ (request()->is('po/cancels') ? 'active' : '' ) }} {{ (request()->is('po/approves') ? 'active' : '' ) }} {{(request()->is('po/search_report') ? 'active' : '')}}">
                  <i class="nav-icon fa fa-pencil-square-o"></i>
                  <p>
                      
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview" style="display: {{ (request()->is('po/report') ? 'block' : '' ) }} {{ (request()->is('po') ? 'block' : '' ) }} {{ (request()->is('po/create') ? 'block' : '' ) }} {{ (request()->is('po/reject') ? 'block' : '' ) }} {{ (request()->is('po/approve') ? 'block' : '' ) }} {{ (request()->is('po/cancels') ? 'block' : '' ) }} {{ (request()->is('po/approves') ? 'block' : '' ) }} {{ (request()->is('po/search_report') ? 'block' : '' ) }};">

                    <li class="nav-item">
                      <a href="/po" class="nav-link {{ (request()->is('po') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการรออนุมัติ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/po/approves" class="nav-link {{ (request()->is('po/approves') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการรอรับของ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/po/cancels" class="nav-link {{(request()->is('po/cancels') ? 'active' : '')}}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการยกเลิก</p>
                      </a>
                  </li>

              </ul>
          </li> -->
                        <li class="nav-item">
                            <a href="/receive/report/RR?project_id=all&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{ (request()->is('receive/report/RR') ? 'active' : '' ) }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>รับของ</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link {{ (request()->is('receive') ? 'active' : '' ) }} {{ (request()->is('receive/finish') ? 'active' : '' ) }} {{ (request()->is('receive/reject') ? 'active' : '' ) }} {{ (request()->is('receive/approve') ? 'active' : '' ) }} {{ (request()->is('receive/close') ? 'active' : '' ) }} {{ (request()->is('receive/report') ? 'active' : '' ) }} ">
                  <i class="nav-icon fas fa-box-open"></i>
                  <p>
                      รับของ
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview" style="display: {{ (request()->is('receive') ? 'block' : '' ) }} {{ (request()->is('receive/finish') ? 'block' : '' ) }} {{ (request()->is('receive/reject') ? 'block' : '' ) }} {{ (request()->is('receive/approve') ? 'block' : '' ) }} {{ (request()->is('receive/close') ? 'block' : '' ) }} {{ (request()->is('receive/report') ? 'block' : '' ) }} ;">
                <li class="nav-item">
                      <a href="/receive/report?types%5B%5D=RR&project_id=all&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{ (request()->is('receive/report') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการทั้งหมด</p>
                      </a>
                  </li>
                <li class="nav-item">
                      <a href="/receive" class="nav-link {{ (request()->is('receive') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการสร้าง</p>    
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/receive/approve" class="nav-link {{ (request()->is('receive/approve') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการอนุมัติ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/receive/reject" class="nav-link {{ (request()->is('receive/reject') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการไม่อนุมัติ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/receive/finish" class="nav-link {{ (request()->is('receive/finish') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการเสร็จสิ้น</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/receive/close" class="nav-link {{ (request()->is('receive/close') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ยกเลิก การรับของ</p>
                      </a>
                  </li>

              </ul>
          </li> -->
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-success"><i class="fas fa-caret-down"></i> จัดจ้าง</li>

                        <li class="nav-item">
                            <a href="/sc/search_report?project_id=&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{(request()->is('sc/search_report') ? 'active' : '')}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>สั่งจ้าง</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/receive/report/PAD?project_id=all&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{ (request()->is('receive/report/PAD') ? 'active' : '' ) }}">
                                <i class="nav-icon fas fa-pie-chart"></i>
                                <p>เบิกงวดงาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/retentions" class="nav-link {{ (request()->is('retentions') ? 'active' : '' ) }}">
                                <i class="nav-icon fas fa-registered"></i>
                                <p>ประกันผลงาน</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link  {{ (request()->is('sc/search_report') ? 'active' : '' ) }}  {{ (request()->is('sc/cancels') ? 'active' : '' ) }} {{ (request()->is('sc') ? 'active' : '' ) }} {{ (request()->is('sc/approves') ? 'active' : '' ) }} ">
                  <i class="nav-icon fa fa-users"></i>
                  <p>
                      สั่งจ้าง
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview" style="display: {{ (request()->is('sc/search_report') ? 'block' : '' ) }} {{ (request()->is('sc/cancels') ? 'block' : '' ) }} {{ (request()->is('sc') ? 'block' : '' ) }} {{ (request()->is('sc/approves') ? 'block' : '' ) }} ;">
                    <li class="nav-item">
                      <a href="/sc/search_report?project_id=&date_type=date&from={{Carbon\Carbon::today()->format('Y-01-01')}}&to={{Carbon\Carbon::today()->format('Y-m-d')}}" class="nav-link {{(request()->is('sc/search_report') ? 'active' : '')}}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการทั้งหมด</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/sc" class="nav-link {{ (request()->is('sc') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการรออนุมัติ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/sc/approves" class="nav-link {{ (request()->is('sc/approves') ? 'active' : '' ) }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการรอรับของ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/sc/cancels" class="nav-link {{(request()->is('sc/cancels') ? 'active' : '')}}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>รายการยกเลิก</p>
                      </a>
                  </li>
              </ul>
          </li> -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ (request()->is('wht') ? 'active' : '' ) }} {{ (request()->is('wht/finish') ? 'active' : '' ) }} {{ (request()->is('wht/reject') ? 'active' : '' ) }} {{ (request()->is('wht/group') ? 'active' : '' ) }} {{ (request()->is('wht/payment/finish') ? 'active' : '' ) }} {{ (request()->is('wht/report') ? 'active' : '' ) }}">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    หัก ณ ที่จ่าย
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview" style="display: {{ (request()->is('wht') ? 'block' : '' ) }} {{ (request()->is('wht/finish') ? 'block' : '' ) }} {{ (request()->is('wht/reject') ? 'block' : '' ) }} {{ (request()->is('wht/group') ? 'block' : '' ) }} {{ (request()->is('wht/payment/finish') ? 'block' : '' ) }} {{ (request()->is('wht/report') ? 'block' : '' ) }};">
                                <li class="nav-item">
                                    <a href="/wht" class="nav-link {{ (request()->is('wht') ? 'active' : '' ) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>รายการ</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="/wht/finish" class="nav-link {{ (request()->is('wht/finish') ? 'active' : '' ) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>เสร็จ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/wht/reject" class="nav-link {{ (request()->is('wht/reject') ? 'active' : '' ) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ยกเลิก</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/wht/payment/finish" class="nav-link {{ (request()->is('wht/payment/finish') ? 'active' : '' ) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ชำระเงินเรียบร้อย</p>
                                    </a>
                                </li> -->
                                <!-- <li class="nav-item">
                                    <a href="/wht/report" class="nav-link {{ (request()->is('wht/report') ? 'active' : '' ) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>รายงาน</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>

                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-success"><i class="fas fa-caret-down"></i> SETTING</li>

                        <li class="nav-item">
                            <a href="/user/to/branch" class="nav-link {{ (request()->is('user/to/branch')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    จัดการบริษัท
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="/customers" class="nav-link {{ (request()->is('customers')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    ลูกค้า/ซับ
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/cost-plan" class="nav-link {{ (request()->is('cost-plan')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-money"></i>
                                <p>
                                    กลุ่มต้นทุน
                                </p>
                            </a>
                        </li>
                    </ul>
                    @can('manage')
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-success"><i class="fas fa-caret-down"></i> DEVELOPER</li>
                        <li class="nav-item">
                            <a href="/wht/group" class="nav-link {{ (request()->is('wht/group') ? 'active' : '' ) }}">
                            <i class="nav-icon fas fa-list-ul"></i>
                                <p>หมวด หัก ณ ที่จ่าย</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/branch" class="nav-link {{ (request()->is('branch')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-code-branch"></i>
                                <p>
                                    สาขา
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/project-type" class="nav-link {{ (request()->is('project-type')) ? 'active' : '' }}">
                                <i class="nav-icon fa fa-cubes"></i>
                                <p>
                                    ประเภท โครงการ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link {{ (request()->is('jb/admin/users')) ? 'active' : '' }} {{ (request()->is('jb/admin/permissions')) ? 'active' : '' }} {{ (request()->is('jb/admin/roles')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    พนักงาน
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: {{ (request()->is('jb/admin/users')) ? 'block' : '' }} {{ (request()->is('jb/admin/permissions')) ? 'block' : '' }} {{ (request()->is('jb/admin/roles')) ? 'block' : '' }};">
                                <li class="nav-item">
                                    <a href="/jb/admin/users" class="nav-link {{ (request()->is('jb/admin/users')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>รายชื่อพนักงาน</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/jb/admin/roles" class="nav-link {{ (request()->is('jb/admin/roles')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ตำแหน่ง</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/jb/admin/permissions" class="nav-link {{ (request()->is('jb/admin/permissions')) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>สิทธิ์การใช้งาน</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    @endcan
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.5
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/admin/plugins/moment/moment.min.js"></script>
    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/admin/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/admin/dist/js/demo.js"></script>
    @include('sweetalert::alert')
    @yield('footer')
    <script>
        $('form').submit(function(e) {
            if ($(this).hasClass('form-submitted')) {
                e.preventDefault();
                alert('กรุณารอสักครู่ (Please wait)')
                return;
            }
            $(this).addClass('form-submitted');
        });
    </script>
</body>

</html>