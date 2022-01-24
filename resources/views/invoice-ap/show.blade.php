@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Invoice Show</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/invoice-ap">รายการ Invoice</a></li>
                    <li class="breadcrumb-item active">Invoice Show</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app">
    <div class="card-header">
        <div class="card-tools">
            <a href="/invoice-ap/show/{{$invoice->id}}/print" target="back_"><button type="button" class="btn btn-block btn-outline-secondary"><i class="fa fa-print"></i> พิมพ์</button> </a>
        </div>
        <h3 class="card-title">Invoice Show</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th>AP ID</th>
                        <th>โครงการ</th>
                        <th>ผู้ขาย</th>
                        <th>วันที่</th>
                        <th>รวม</th>
                        <th>ไม่รวม vat</th>
                        <th>vat</th>
                        <th>ผู้สร้าง</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>{{$invoice->code}}</td>
                        <td>{{$invoice->project->name}}</td>
                        <td>{{$invoice->supplier->name}}</td>
                        <td>{{$invoice->date}}</td>
                        <td>{{number_format($invoice->amount,2)}}</td>
                        <td>{{number_format($invoice->tax_base,2)}}</td>
                        <td>
                            {{number_format($invoice->vat,2)}}
                        </td>
                        <td>{{$invoice->user->name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr class="text-center">
                        <th>Code</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Special Discount</th>
                        <th>Invoice Discount</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoice_lists as $invoice_list)
                    @foreach($invoice_list->receive->receive_lists as $receive_list)
                    <tr class="text-center">
                        <td><a href="/revice/show/{{$invoice_list->receive->id}}">{{$invoice_list->receive->receive_code}}</a></td>
                        <td>{{$receive_list->name}}</td>
                        <td>{{number_format($receive_list->amount, 2)}}</td>
                        <td>{{$receive_list->unit}}</td>
                        <td>{{number_format($receive_list->unit_price,2)}}</td>
                        <td>{{number_format($receive_list->unit_discount,2)}}</td>
                        <td>{{number_format($receive_list->special_discount,2)}}</td>
                        <td>{{number_format($receive_list->invoice_discount,2)}}</td>
                        <td class="text-right">{{number_format($receive_list->price - $receive_list->invoice_discount,2)}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="row mb-3">
                    <div class="col-12">
                        <textarea name="note" id="note" cols="30" rows="3" class="form-control" placeholder="Note..." readonly style="border: 1px solid #ededed; background-color: #ededed;">{{$invoice->note}}</textarea>
                    </div>
                </div>
                <?php
                $deposit_method_sum = 0;
                ?>
                @if($invoice->deposit_methods->count() > 0)
                <h5 style="color: gray;">Deposit Method</h5>
                @foreach($invoice->deposit_methods as $deposit_method)
                <?php
                $deposit_method_sum = $deposit_method_sum + $deposit_method->amount;
                ?>
                <div class="row mb-3">
                    <div class="col-3">
                        <input type="text" readonly class="form-control form-control-sm" value="{{$deposit_method->deposit->code}}" title="{{$deposit_method->deposit->code}}">
                    </div>
                    <div class="col-3">
                        <input type="text" readonly class="form-control form-control-sm" value="{{number_format($deposit_method->amount,2)}}" title="{{number_format($deposit_method->amount,2)}}">
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <div class="col-12 col-md-4" style="color: gray;">
                <h5 style="color: gray;">Payment</h5>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">SPECIAL DISCOUNT</label>
                    <div class="col-sm-8 text-right">
                        {{number_format($invoice_list->receive->special_discount,2)}}
                    </div>
                </div>
                <?php
                $retention_amount = 0;
                ?>
                <div style="padding: 5px;">
                    @foreach($invoice->invoice_lists as $invoice_list)
                    @if($invoice_list->receive->retention)
                    <?php
                    $retention_amount = $retention_amount + $invoice_list->receive->retention->price;
                    ?>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">RETENTION</label>
                        <div class="col-sm-8 text-right">
                            {{number_format($invoice_list->receive->retention->price,2)}}
                        </div>
                    </div>
                    @endif
                    @endforeach

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">TOTAL</label>
                        <div class="col-sm-8 text-right">
                            {{number_format($invoice->amount,2)}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">TAX BASE</label>
                        <div class="col-sm-8 text-right">
                            {{number_format($invoice->tax_base,2)}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">VAT</label>
                        <div class="col-sm-8 text-right">
                            {{number_format($invoice->vat,2)}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">GRAN TOTAL</label>
                        <div class="col-sm-8 text-right">
                            {{number_format((($invoice->tax_base + $invoice->vat) - $retention_amount),2)}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                @if($invoice->account_views->count() > 0)
                <h5 style="color: gray;">Account View</h5>
                <div class="table-responsive p-0">
                    <table class="table text-nowrap" style="color: gray; padding: 5px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Account</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->account_views as $x => $account_view)
                            <tr>
                                <td>{{$x + 1}}</td>
                                <td>{{$account_view->accounting->code}}: {{$account_view->accounting->name}}</td>
                                <td class="text-right">{{number_format($account_view->debit,2)}}</td>
                                <td class="text-right">{{number_format($account_view->credit,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        @if($invoice->status == 0 || $invoice->status == 2)
        <div class="row mt-3">
            <div class="col-12">
                @if($invoice->status == 0)
                <form action="/invoice-approve" method="post" onsubmit="return confirm('ต้องการที่จะ อนุมัติ การรับของรายการนี้ ?')">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                    <button type="submit" style="float: right; margin-left: 20px;" class="btn btn-outline-success btn-sm w-auto">อนุมัติ</button>
                </form>
                @endif
                <button type="button" style="float: right;" class="btn btn-outline-danger btn-sm w-auto" data-toggle="modal" data-target="#reject">ไม่อนุมัติ</button>
            </div>
        </div>
        <div class="modal fade" id="reject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">เหตุผลที่ไม่ อนุมัติ</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/invoice-reject" method="post" onsubmit="return confirm('ต้องการที่จะ ไม่อนุมัติ Invoice ?')">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                            <textarea required name="reject_note" cols="30" rows="3" placeholder="Enther....." class="form-control"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
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
        padding-top: 10px !important;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
@endsection

@section('footer')
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection