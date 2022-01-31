<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta http-equiv=Content-Type content="text/html; charset=unicode">
    <meta name=ProgId content=Word.Document>
    <meta name=Generator content="Microsoft Word 15">
    <meta name=Originator content="Microsoft Word 15">
    <link rel=File-List href="contract_files/filelist.xml">
    <style>
        @import url('http://fontlibrary.org/face/thsarabun-new');
    </style>
    <meta charset="utf-8">
    <title>
        {{$po->code}}
    </title>
    <link rel="icon" href="{{ asset('/icon.jpg') }}">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        .table-bordered {
            font-size: 1em;
        }
    </style>

    <style>
        body {
            background: rgb(204, 204, 204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }


        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
                -webkit-print-color-adjust: exact;
            }

            .content-raduis {
                padding: 10px;
                border-radius: 3px;
                border: 1px solid gray;
            }
        }

        .content-raduis {
            padding: 10px;
            border-radius: 3px;
            border: 1px solid gray;
        }

        .content {
            width: 100%;
        }

        span.subject {
            font-size: 20pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
        }

        span.subsubject {
            font-size: 19pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
        }

        span.subsubject_tax {
            font-size: 17pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
        }

        small.subsubject {
            font-size: 14pt;
            line-height: 100%;
            font-family: "TH Sarabun New";
        }

        small.subsubject_en {
            font-size: 17pt;
            line-height: 100%;
            font-family: "TH Sarabun New";
        }

        span.contents {
            font-size: 14pt;
            margin-top: 5px;
            margin-bottom: 5px;
            font-family: "TH Sarabun New";
        }

        span.content_small {
            font-size: 12pt;
            padding: 10px;
            font-family: "TH Sarabun New";
        }

        span.foot_contents {
            font-size: 13pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
            margin-left: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .content-visibility {
            visibility: hidden;
        }

        .purchase-background {
            background-color: #ddd !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }

        .column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .card-solid {
            border: 1px solid #AEAEAE !important;
        }

        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #AEAEAE;
        }

        #example1 {
            border: 1px solid #AEAEAE;
            padding: 10px;
            border-radius: 10px;
            margin-top: 5px;
        }

        #example2 {
            border: 2px solid #AEAEAE;
            border-radius: 12px;
        }

        td.top {
            height: 50px;
            vertical-align: top;
        }
    </style>
</head>


<body lang=EN-US style='tab-interval:.5in'>
    <page size="A4" style="padding: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 20%;">
                    @if($po->project->branch->logo)
                    <img style="width: 90%;" src="{{Storage::disk('spaces')->url($po->project->branch->logo)}}" alt="User profile picture">
                    @else
                    <img style="width: 90%;" src="/home.jpg" alt="User profile picture">
                    @endif
                </td>
                <td style="width: 50%;">
                    <span class="subsubject"> <b> {{$po->project->branch->company}}</b></span> <br>
                    <small class="subsubject_en"> {{$po->project->branch->company_eng}}</small>
                    <hr style="margin-top: 5px ; margin-top: 5px">
                    <small class="subsubject"> {{$po->project->branch->address}}</small> <br>
                    <small class="subsubject"> โทร : {{$po->project->branch->tel}}</small> <br>
                    <small class="subsubject">เลขประจำตัวผู้เสียภาษี : {{$po->project->branch->tax}} ({{$po->project->branch->tax_code}})</small> <br>
                </td>
                <td style="width: 30%; text-align: right;">
                    <div id="example2">
                        <table style="width: 100%; text-align: right;" class="purchase-background">
                            <tr>
                                @if($po->po_type == 'SC')
                                <td style="width: 100%; text-align: center; padding: 16px;">
                                    <span class="subsubject_tax"><b>ใบสั่งจ้าง</b></span><br>
                                    <span class="contents">PURCHASE ORDER</span>
                                </td>
                                @else
                                <td style="width: 100%; text-align: center; padding: 16px;">
                                    <span class="subsubject_tax"><b>ใบสั่งซื้อ</b></span><br>
                                    <span class="contents">PURCHASE ORDER</span>
                                </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <!-- <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <span class="subsubject"></span><br>
                </td>
                <td style="width: 50%;">
                    
                </td>
            </tr>
        </table> -->

        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td style="width: 60%;padding: 5px; " class="card-solid">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>ผู้ติดต่อ (Contract)</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$po->contract ? $po->contract->name : ''}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>ชื่อร้านค้า (Name)</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$po->supplier->name}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;" colspan="2">
                                <span class="contents"><b>เลขประจำตัวผู้เสียภาษี (Tax ID.) : </b> {{$po->supplier->txt_tin}}</span><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%;" colspan="2">
                                <span class="contents"><b>โทรศัพท์ (Tel.) : </b>{{$po->supplier->tel}} <b> โทรสาร (Fax.) : </b> {{$po->supplier->fax}}</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: right;padding: 5px;" class="card-solid">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>วันที่ (Date)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $po->po_date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เลขที่ใบสั่งซื้อ (PO No.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{$po->code}}</span></td>
                        </tr>

                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เลขที่ใบขอซื้อ (PR No.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents"> </span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เงื่อนไขชำระเงิน (Term.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents"> {{$po->payment_type}} @if($po->payment_type == 'เครดิต') {{$po->cradit}} วัน @endif </span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;" colspan="2">
                                <span class="contents"><b>ผู้ติดต่องาน</b> {{$po->main_user ? $po->main_user->name : ''}} ({{$po->tel}})</span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents"> </span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div id="">
            <span class="contents" style="padding: 5px;">โครงการ (Project) : {{$po->project->code}} {{$po->project->name}}</span>
            <table style="width: 100%; border-radius: 10px!important;">
                <tr style="background-color: #ddd!important; padding: 10px;" class="card-solid">
                    <th style="padding: 5px; text-align: center;"><span class="contents">ลำดับ</br>No.</span></th>
                    <th style="padding: 5px; text-align: center; width: 50%;"><span class="contents">รายการ</br>Description</span></th>
                    <th style="padding: 5px; text-align: center;"><span class="contents">จำนวน</br>QTY.</span></th>
                    <th style="padding: 5px; text-align: center;width: 10%;"><span class="contents">หน่วย</br>Unit</span></th>
                    <th style="padding: 5px; text-align: center;width: 15%;"><span class="contents">ราคา/หน่วย</br>Unit/Price</span></th>
                    <th style="padding: 5px; text-align: center;width: 10%;"><span class="contents">ส่วนลด</br>Discount</span></th>
                    <th style="padding: 5px; text-align: center;width: 15%;"><span class="contents">มูลค่าสินค้า</br>Amount</span></th>
                </tr>
                <tbody>
                    @foreach($po->purchaseOrderLists as $i => $list)
                    <tr class="card-solid">
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$i+1}}</span></td>
                        <td style="padding: 5px; text-align: left;"><span class="contents">{{$list->name}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{$list->amount}}</span></td>
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$list->unit}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->unit_price,3)}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->totalDiscount,2)}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->price,2)}}</span></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="" colspan="4" rowspan="4" class="top"><span class="foot_contents"> <b>หมายเหตุ (Remarks) : </b> {{$po->note}}</span></td>
                        <td style=" text-align: right;" colspan="2"><span class="contents">รวมราคา / Amount</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">{{number_format($po->sum_price + $po->vat_amount,2)}}</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">ส่วนลด / Discount</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">0.00</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">มูลค่า / Sub Total</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">{{number_format($po->sum_price,2)}}</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">ภาษีมูลค่าเพิ่ม / Vat 7%</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">{{number_format($po->vat_amount,2)}} </span></td>
                    </tr>
                    <tr class="card-solid">
                        <td style=" padding: 2px;" colspan="3" class="text-center"><b><span class="contents">{{num2thai($po->sum_price + $po->vat_amount)}} </span></b></td>
                        <td style=" padding: 2px;" colspan="3" class="text-right"><b><span class="contents">ยอดเงินสุทธิ / Net Total</span></b></td>
                        <td style=" padding: 2px;" class="text-right"><b><span class="contents">{{number_format($po->sum_price + $po->vat_amount, 2)}}</span></b></td>
                    </tr>

                </tbody>

            </table>
        </div>

        <table style="width: 100%; margin-top: 2px;">
            <tr>
                <td style="width: 30%; text-align: center;">
                    <table style="width: 100%;">
                        <span class="content_small">ผู้สั่งซื้อ (Purchase)</span>
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                <span class="foot_contents">
                                    </br>
                                    </br>{{$po->user->name}}
                                    </br>วันที่/Date {{ \Carbon\Carbon::createFromFormat('Y-m-d', $po->po_date)->format('d/m/Y')}}
                                </span>
                            </th>
                        </tr>
                    </table>
                </td>
                <td style="width: 30%; text-align: center;">
                    <table style="width: 100%;">
                        <span class="content_small">ผู้จัดการฝ่าย (Department Manager)</span>
                        @if($po->approve_user)
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                <span class="foot_contents">
                                    </br>
                                    </br>{{$po->approve_user->name}}
                                    </br>วันที่/Date {{$po->approve_user_time->format('d/m/Y')}}
                                </span>
                            </th>
                        </tr>
                        @else
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 12px;" class="text-center">
                                </br>
                                <span class="foot_contents">
                                    </br>
                                    </br>วันที่/Date</span>
                            </th>
                        </tr>
                        @endif

                    </table>
                </td>
                <td style="width: 30%; text-align: center;">
                    <table style="width: 100%;">
                        <span class="content_small">ผู้อนุมัติ (Authorized Signature)</span>
                        @if($po->main_approve_user && $po->po_type != 'NR')
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                <span class="foot_contents">
                                    </br>
                                    </br>{{$po->main_approve_user->name}}
                                    </br>วันที่/Date {{$po->main_approve_user_time->format('d/m/Y')}}
                                </span>
                            </th>
                        </tr>
                        @elseif($po->approve_user && $po->po_type == 'NR')
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                @if($po->approve_user->signature) <img src="{{ Storage::disk('spaces')->url($po->approve_user->signature)}}" width="100px" height="40px">@endif
                                <span class="foot_contents">
                                    </br>{{$po->approve_user->name}}
                                    </br>วันที่/Date {{$po->approve_user_time->format('d/m/Y')}}
                                </span>
                            </th>
                        </tr>
                        @else
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 12px;" class="text-center">
                                </br>
                                <span class="foot_contents">
                                    </br>
                                    </br>วันที่/Date</span>
                            </th>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 2px;">
            <tr>
                <td style="width: 100%;">
                    <br>
                    <span class="foot_contents"> * โปรดเรียก ใบสั่งซื้อ/ใบสั่งจ้าง (ต้นฉบับ) จากบริษัทฯ ทุกครั้ง</span><br>
                    <span class="foot_contents"> * โปรดลงเลขที่ ใบสั่งซื้อ/ใบสั่งจ้าง ที่ระบุข้างบนลงในใบส่งของที่ท่านส่งมาให้บริษัทฯ ด้วย</span><br>
                    <span class="foot_contents"> * โปรดแนบต้นฉบับ ใบสั่งซื้อ/ใบสั่งจ้าง มากับบิลเก็บเงินทุกครั้ง มิฉะนั้นบริษัทฯ จะไม่รับผิดชอบ</span><br>
                </td>
            </tr>
        </table>

    </page>
</body>

<script>
    $(function() {
        window.focus();
        window.print();
    });
</script>

</html>