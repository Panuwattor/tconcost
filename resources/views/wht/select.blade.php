@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Other Payment Wht</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Other Payment Wht</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app">
    <div class="card-header">
        <h3 class="card-title">Other Payment Wht</h3>
    </div>

    <div class="card-body p-0">
        <form action="/other-payment/wht">
            @csrf
            <div class=" table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>
                                <div class="form-group clearfix m-0" onclick="select_all()">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="all">
                                        <label for="all">
                                            ทั้งหมด
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th>NO</th>
                            <th>Code</th>
                            <th>ผู้ขาย</th>
                            <th>วันที่</th>
                            <th>ประเภท</th>
                            <th>หัก ณ ที่จ่าย</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($whts as $i => $wht)
                        <tr class="text-center">
                            <td>
                                <div class="form-group clearfix m-0">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="wht{{$i}}" name="whts_id[]" value="{{$wht->id}}">
                                        <label for="wht{{$i}}">
                                            เลือก
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td>{{$i + 1}}</td>
                            <td>{{$wht->code}}</td>
                            <td>{{$wht->supplier->name}}</td>
                            <td>{{$wht->date}}</td>
                            <td>{{$wht->type}}</td>
                            <td>{{$wht->wht_payment_type}}</td>
                            <td>
                                <a href="/wht/show/{{$wht->id}}"><button type="button" class="btn btn-outline-success btn-sm">รายละเอียด</button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row m-3">
                <div class="col-12">
                    <button type="submit" class="btn w-auto btn-outline-info btn-sm float-right">ต่อไป</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('header')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 31px !important;
        padding-top: 5px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section('footer')
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

<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var whts = {!!$whts!!}

    function select_all() {
        if (document.getElementById('all').checked == true) {
            for (var i = 0; i < whts.length; i++) {
                document.getElementById('wht' + i).checked = true;
            }
        } else {
            for (var i = 0; i < whts.length; i++) {
                document.getElementById('wht' + i).checked = false;
            }
        }
    }
</script>
@endsection