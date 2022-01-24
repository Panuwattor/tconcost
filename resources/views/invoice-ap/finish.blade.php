@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Invoice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app" v-cloak>
    <div class="card-header">
        <h3 class="card-title">Invoice</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>ลำดับ</th>
                    <th>AP ID</th>
                    <th>Receive ID</th>
                    <th>โครงการ</th>
                    <th>ผู้ขาย</th>
                    <th>วันที่</th>
                    <th>ยอดรวม</th>
                    <th>สถานะ</th>
                    <th>ผู้สร้าง</th>
                    <th>ผู้อนุมัติ</th>
                    <th>อนุมัติเวลา</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $i => $invoice)
                <tr class="text-center">
                    <td>{{$i + 1}}</td>
                    <td>{{$invoice->code}}</td>
                    <td>
                        @foreach($invoice->invoice_lists as $invoice_list)
                        <a href="/receive-waiting-approve/show/{{$invoice_list->id}}">{{$invoice_list->receive->receive_code}}</a>
                        @endforeach
                    </td>
                    <td>{{$invoice->project->name}}</td>
                    <td>{{$invoice->supplier->name}}</td>
                    <td>{{$invoice->date}}</td>
                    <td>{{number_format($invoice->tax_base + $invoice->vat, 2)}}</td>
                    <td>{!!$invoice->state!!}</td>
                    <td>{{$invoice->user->name}}</td>
                    <td>
                        @if($invoice->user_approve)
                        {{$invoice->user_approve->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{$invoice->user_approve_time}}</td>
                    <td>
                        <a href="/invoice-ap/show/{{$invoice->id}}"><button type="button" class="w-auto btn btn-outline-info btn-sm">รายละเอียด</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('header')
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 38px !important;
        padding-top: 8px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>

<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: " ";
        display: block;
        position: absolute;
        width: 80px;
        height: 80px;
        background-image: url(http://pluspng.com/img-png/loader-png-indicator-loader-spinner-icon-512.png);
        background-size: cover;
        left: 50%;
        top: 50%;
    }
</style>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                search_receives: '',
                select_receives: new Array(),
                search_code: '',
            }
        },
        methods: {
            search: async function() {
                var project_id = document.getElementById('project_id').value
                var supplier_id = document.getElementById('supplier_id').value

                var res = await axios.get('/getReceive', {
                    params: {
                        project_id: project_id,
                        supplier_id: supplier_id,
                        search_code: this.search_code,
                    }
                });

                this.search_receives = res.data;
            },
            remove(index) {
                this.select_receives.splice(index, 1);

                if (this.select_receives.length > 0) {
                    document.getElementById('div_select').style.display = 'none'

                    var element = document.getElementById("div_selected");
                    element.classList.add("col-12");
                } else {
                    document.getElementById('div_select').style.display = 'block'

                    var element = document.getElementById("div_selected").className = 'col-6';
                }
            },
            select(receive) {
                for (var i = 0; i < this.select_receives.length; i++) {
                    if (receive.id == this.select_receives[i].id) {
                        alert('มีรายการนี้อยู่แล้ว');
                        return;
                    }
                }
                for (var i = 0; i < this.select_receives.length; i++) {
                    if (receive.project_id != this.select_receives[i].project_id) {
                        alert('คนละโครงการ');
                        return;
                    }
                }
                for (var i = 0; i < this.select_receives.length; i++) {
                    if (receive.supplier_id != this.select_receives[i].supplier_id) {
                        alert('supplier คนละคน');
                        return;
                    }
                }
                for (var i = 0; i < this.select_receives.length; i++) {
                    if (receive.vat_type != this.select_receives[i].vat_type) {
                        alert('vat คนละประเภทกับที่มีอยู่');
                        return;
                    }
                }
                this.select_receives.push(receive);

                if (this.select_receives.length > 0) {
                    document.getElementById('div_select').style.display = 'none'

                    var element = document.getElementById("div_selected");
                    element.classList.add("col-12");
                } else {
                    document.getElementById('div_select').style.display = 'block'

                    var element = document.getElementById("div_selected");
                    element.classList.add("col-6");
                }
            }
        },
    });
</script>
@endsection