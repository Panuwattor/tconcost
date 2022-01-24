@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">แก้ไขใบเสนอราคา</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">สร้างใบเสนอราคา</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">ใบเสนอราคา  {{$quotation->code}}</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <form id="form_submit" action="/sale/quotation/{{$quotation->id}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group" hidden>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="customRadio_type1" value="0" name="type" checked="">
                                                <label for="customRadio_type1" class="custom-control-label">โครงการทั่วไป</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">ชื่อโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <input required type="text" class="form-control" value="{{$quotation->name}}" name="name" placeholder="ชื่อ" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group" hidden>
                                    <span for="inputEmail3">สาขา <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="branch_id" class="form-control select2" id="">
                                            @foreach($branchs as $branch)
                                            <option value="{{$branch->id}}">{{$branch->code}} {{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" hidden>
                                    <span for="inputEmail3">ประเภทโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="project_type_id" class="form-control select2" id="">
                                            @foreach($project_types as $project_type)
                                            <option value="{{$project_type->id}}">{{$project_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">VAT</span>
                                    <div>
                                        <input type="number" class="form-control" id="vat2" name="vat" placeholder="VAT" value="{{$quotation->vat}}" step="any">
                                    </div>
                                    <div class="form-group clearfix mt-2" onclick="check_vat()">
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio1" value="ใน" name="vat_type" @if($quotation->vat_type == 'ใน') checked="" @endif>
                                            <label for="customRadio1" class="custom-control-label">Vat ใน</label>
                                        </div>
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio2" value="นอก" name="vat_type" @if($quotation->vat_type == 'นอก') checked="" @endif>
                                            <label for="customRadio2" class="custom-control-label">Vat นอก</label>
                                        </div>
                                        <div class="custom-control custom-radio d-inline">
                                            <input class="custom-control-input" type="radio" id="customRadio3" value="ไม่มี" name="vat_type" @if($quotation->vat_type == 'ไม่มี') checked="" @endif>
                                            <label for="customRadio3" class="custom-control-label">ไม่มี Vat</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">สถานที่ก่อสร้าง <span class="text-danger">*</span></span>
                                    <div>
                                        <textarea required class="form-control" rows="3" name="address_project"  placeholder="Enter ..."> {{$quotation->address}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">วันที่เริ่มต้นใบเสนอ <span class="text-danger">*</span></span>
                                    <div>
                                        <input required autocomplete="off" type="date" name="start_date" class="form-control datepicker" id="datepicker" value="{{$quotation->start_date}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span for="inputEmail3">วันที่หมดอายุใบเสนอ <span class="text-danger">*</span></span>
                                    <div>
                                        <input required autocomplete="off" type="date" name="finish_date" class="form-control datepicker" id="finish_datepicker" value="{{$quotation->finish_date}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                             <div class="form-group" hidden>
                                    <span for="inputEmail3">ผู้รับผิดชอบโครงการ <span class="text-danger">*</span></span>
                                    <div>
                                        <select required name="main_user_id" class="form-control select2" id="">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" @if($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card direct-chat direct-chat-primary collapsed-card">
                                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                                        <div class="form-group">
                                            <span for="inputEmail3">ชื่อลูกค้า  </span>
                                            <div class="input-group">
                                                <select name="customer_id" class="form-control select2" id="">
                                                    <option value="">เลือก</option>
                                                    @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}" @if($customer->id == $quotation->customer_id) selected @endif>{{$customer->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-12" >
                                            <button id="removeRowNew" type="button" class="btn btn-outline-danger  pull-right">- ลบ</button>
                                            <button id="addRowNew" type="button" class="btn btn-outline-success  pull-right"> + เพิ่มรายการอื่นๆ</button> 
                                            <span for="inputEmail3">รายรับโครงการ <span class="text-danger">*</span></span>

                                        </div>
                                        <div class="col-md-12 mt-2">
                                        <div class="table-responsive">
                                            <table id="myTblNew" class="table table-vcenter table-condensed table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">วันที่</th>
                                                        <th class="text-center">รายละเอียด</th>
                                                        <th class="text-center">หน่วย</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @foreach($quotation->lists as $list)
                                                    <tr id="firstTrNew">
                                                    <td>
                                                        <input type="date" class="form-control text-center" value="{{ $list->date }}" id="dates" name="dates[]" >
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control text-center" id="details" name="details[]" value="{{ $list->description }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control text-center" id="units" name="units[]" value="{{ $list->unit }}" required>
                                                    </td>
                                                    <td>            
                                                        <input type="number" value="{{ $list->price }}"  step="any" class="form-control text-center" id="prices[]" name="prices[]" required>
                                                        <input type="hidden" name="check" value="1" class="checkCountNew" />
                                                    </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer justify-content-between">
                            <div class="form-group">
                                <span for="inputEmail3">หมายเหตุ</span>
                                <div>
                                    <textarea class="form-control" rows="3" name="note" placeholder="Enter ...">{{$quotation->note}}</textarea>
                                </div>
                            </div>
                            <button id="btn_submit" type="submit" class="btn btn-block btn-outline-success btn-lg" >บันทึก สร้างโครงการ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });

    function check_vat() {
        if (document.getElementById('customRadio1').checked) {
            document.getElementById('vat2').value = 7;
        } else if (document.getElementById('customRadio2').checked) {
            document.getElementById('vat2').value = 7;
        } else if (document.getElementById('customRadio3').checked) {
            document.getElementById('vat2').value = 0;
        }
    }
</script>

<script type="text/javascript">
$(function(){
    $("#addRowNew").click(function(){
        $("#myTblNew").append($("#firstTrNew").clone());
    });

    $("#removeRowNew").click(function(){
        var sum = 0;
        $('.checkCountNew').each(function(){
            sum += parseFloat(this.value);
        });

        if(sum > 1){
            $("#myTblNew tr:last").remove();
        }else{
            alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
        }
    }); 
});
</script>
@endsection