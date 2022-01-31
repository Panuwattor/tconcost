@extends('master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">รายงานหัก ณ ที่จ่าย</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">รายงานหัก ณ ที่จ่าย</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="from" value="{{$from}}" id="from">
                        </div>
                        <div class="my-1">
                            <label>ถึงวันที่ </label>
                        </div>

                        <div class="col-12 col-md-2">
                            <input readonly type="text" autocomplete="off" class="form-control form-control-sm" name="to" value="{{$to}}" id="to">
                        </div>

                        <div class="col-12 col-md-4">
                            <select name="customer_select" class="form-control form-control-sm select2">
                                <option value="all">ทั้งหมด</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}" @if($customer->id == $customer_select) selected @endif>{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="icheck-primary d-inline ml-3">
                            <input type="checkbox" name="types[]" value="ภ.ง.ด53" id="checkboxPrimary1" @if(in_array("ภ.ง.ด53", $types)) checked="" @endif>
                            <label for="checkboxPrimary1">
                                ภ.ง.ด53
                            </label>
                        </div>
                        <div class="icheck-primary d-inline ml-3">
                            <input type="checkbox" name="types[]" value="ภ.ง.ด3" id="checkboxPrimary2" @if(in_array("ภ.ง.ด3", $types)) checked="" @endif>
                            <label for="checkboxPrimary2">
                                ภ.ง.ด3
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button style="float: right;" class="btn w-auto btn-outline-success "> <i class="fa fa-search"></i> ค้นหา</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">รางานหัก ณ ที่จ่าย</h3>
        <div class="card-tools">
            <a href="/wht/report/print?from={{$from}}&to={{$to}}&customer_select={{$customer_select}}&branch_select={{$branch_select}}"><button type="button" class="btn btn-outline-secondary btn-sm"><i class="fa fa-print"> พิมพ์</i></button></a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table id="example1" class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center" style="background-color:#8AADCC">
                    <th>รหัส/วันที่จ่าย</th>
                    <th>ผู้ถูกหัก ณ ที่จ่าย</th>
                    <th>TAX ID</th>
                    <th>ที่อยู่</th>
                    <th>รายการ</th>
                    <th>%</th>
                    <th>จำนวนเงิน </th>
                    <th>หัก ณ ที่จ่าย</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $_amount = 0;
                $_wht_tax = 0;
                ?>
                @foreach($data->groupBy('date') as $row_group)
                <tr>
                    <th colspan="8">{{$row_group->first()->date}}</th>
                </tr>
                <?php
                $_am = 0;
                $_tax = 0;
                ?>
                @foreach($row_group as $i => $row)
                <tr>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;"><a target="_bank" href="/wht/show/{{$row->id}}">{{$row->code}}</a></td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;">{{$row->supplier->name}}</td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;">{{$row->tax_id}}</td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;">{{$row->address}}</td>
                    <td class="text-center" style="border-left: 1px solid #ddd;">{{$row->wht_lists->first()->note}}</td>
                    <td class="text-center">{{number_format($row->wht_lists->first()->rate, 2)}}%</td>
                    <td class="text-center">{{number_format($row->wht_lists->first()->amount, 2)}}</td>
                    <td class="text-center">{{number_format($row->wht_lists->first()->wht_tax, 2)}}</td>
                </tr>
                <?php
                $_am = $_am + $row->wht_lists->first()->amount;
                $_tax = $_tax + $row->wht_lists->first()->wht_tax;
                ?>
                @foreach($row->wht_lists as $x => $wht_list)
                @if($x > 0)
                <tr class="text-center">
                    <td style="border-left: 1px solid #ddd;">{{$wht_list->note}}</td>
                    <td>{{number_format($wht_list->amount, 2)}}</td>
                    <td>{{number_format($wht_list->rate, 2)}}</td>
                    <td>{{number_format($wht_list->wht_tax, 2)}}</td>
                </tr>
                <?php
                $_am = $_am + $wht_list->amount;
                $_tax = $_tax + $wht_list->wht_tax;
                ?>
                @endif
                @endforeach
                @endforeach

                <tr style="background-color:#ddd">
                    <th colspan="6" class="text-center">รวม {{$row->date}}</th>
                    <th colspan="" class="text-center">{{number_format($_am, 2)}}</th>
                    <th class="text-center">{{number_format($_tax, 2)}}</th>
                </tr>
                <?php
                $_amount = $_amount + $_am;
                $_wht_tax = $_wht_tax + $_tax;
                ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-center">รวมทั้งสิ้น</th>
                    <th class="text-center">{{number_format(($_amount), 2)}}</th>
                    <th class="text-center">{{number_format(($_wht_tax), 2)}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('header')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 30px !important;
        padding-top: 3px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>

<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            width: '100%'
        })

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();
    });

    //Date picker
    $('#from').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    $('#to').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
    })

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function load() {
        document.getElementById('btn_submit').style.display = 'none';
        document.getElementById('btn_secondary').style.display = 'block';
        await sleep(2000);
        document.getElementById('btn_submit').style.display = 'block';
        document.getElementById('btn_secondary').style.display = 'none';
    }

    function check_vat() {
        if (document.getElementById('customRadio1').checked) {
            document.getElementById('vat').value = 7;
        } else if (document.getElementById('customRadio2').checked) {
            document.getElementById('vat').value = 7;
        } else if (document.getElementById('customRadio3').checked) {
            document.getElementById('vat').value = 0;
        }
    }
</script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection