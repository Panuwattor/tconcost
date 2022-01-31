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
        {{$receive->receive_code}}
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
            border: 1px solid #AEAEAE;
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
                    <img style="width: 90%;" src="{{ Storage::disk('spaces')->url($receive->branch->logo)}}" alt="User profile picture">
                </td>
                <td style="width: 50%;">
                    <span class="subsubject"> <b> {{$receive->branch->company}}</b></span> <br>
                    <small class="subsubject_en"> {{$receive->branch->company_eng}}</small>
                    <hr style="margin-top: 5px ; margin-top: 5px">
                    <small class="subsubject"> {{$receive->branch->address}}</small> <br>
                    <small class="subsubject"> โทร : {{$receive->branch->tel}}</small> <br>
                    <small class="subsubject">เลขประจำตัวผู้เสียภาษี : {{$receive->branch->tax}} ({{$receive->branch->tax_code}})</small> <br>
                </td>
                <td style="width: 30%; text-align: right;">
                    <div id="example2">
                        <table style="width: 100%; text-align: right;" class="purchase-background">
                            <tr>
                                <td style="width: 100%; text-align: center; padding: 16px;">
                                    <span class="subsubject_tax"><b>ใบรับสินค้า</b></span><br>
                                    <span class="contents">RECEIVE SUPPLIER</span>
                                </td>
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
                            <td style="width: 100%;" colspan="2">
                                <span class="contents"><b>เลขที่ใบส่งของ (Delivery No.)</b> {{$receive->po->po_id}} ({{ \Carbon\Carbon::createFromFormat('Y-m-d', $receive->po->po_date)->format('d/m/Y')}})</span><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>ชื่อร้านค้า (Name)</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$receive->supplier->name}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b></b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">เลขประจำตัวผู้เสียภาษี {{$receive->supplier->txt_tin}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>โทรศัพท์ (Tel.) :</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents"> {{$receive->supplier->tel}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>โทรสาร (Fax.) :</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$receive->supplier->fax}}</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: right;padding: 5px;" class="card-solid">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>วันที่ (Date)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $receive->date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เลขที่ (No.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{$receive->receive_code}}</span></td>
                        </tr>

                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เลขที่ใบสั่งซื้อ (PO No.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{$receive->po->po_id}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>มูลค่าคงเหลือ (Remain)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents"> {{number_format($receive->po_remain,2)}} </span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เงื่อนไขชำระเงิน (Term.)</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents"> {{$receive->po->payment_type}} @if($receive->po->payment_type == 'เครดิต') {{$receive->po->cradit}} วัน @endif</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div >

            <table style="width: 100%; margin-top: 5px; border-radius: 10px!important;">
                <tr style="background-color: #ddd!important; padding: 10px;" class="card-solid">
                    <th style="padding: 5px; text-align: center;"><span class="contents">ลำดับ</span></th>
                    <th style="padding: 5px; text-align: center; width: 50%;"><span class="contents">รายการ</span></th>
                    <th style="padding: 5px; text-align: center;"><span class="contents">จำนวน</span></th>
                    <th style="padding: 5px; text-align: center;width: 10%;"><span class="contents">หน่วย</span></th>
                    <th style="padding: 5px; text-align: center;width: 15%;"><span class="contents">ราคา/หน่วย</span></th>
                    <th style="padding: 5px; text-align: center;width: 10%;"><span class="contents">ส่วนลด</span></th>
                    <th style="padding: 5px; text-align: center;width: 15%;"><span class="contents">มูลค่าสินค้า</span></th>
                </tr>
                <tbody>
                    @foreach($receive->receive_lists as $index => $list)
                    <tr class="card-solid">
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$index+1}}</span></td>
                        <td style="padding: 5px; text-align: left;"><span class="contents">{{$list->name}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->amount, 2)}}</span></td>
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$list->unit}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->unit_price,3)}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format(($list->amount * $list->unit_discount )+ $list->special_discount,2)}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($list->price,2)}}</span></td>
                    </tr>
                    @foreach($list->po_list->listNotes as $_note)
                    <tr style="background-color: #f2f2f2!important;" class="card-solid">
                        <td style="padding: 5px; text-align: center;" colspan="7"><span class="contents">{{$_note->note}}</span></td>
                    </tr>
                    @endforeach
                    @endforeach
                    <tr>
                        <td style="" colspan="4" rowspan="4" class="top"><span class="foot_contents"> <b>หมายเหตุ (Remarks) : </b> {{$receive->note}}</span></td>
                        <td style=" text-align: right;" colspan="2"><span class="contents">รวมราคา / Amount</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">{{number_format($receive->sum_price,2)}}</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">ส่วนลด / Discount</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">0.00</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">มูลค่า / Sub Total</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">0.00</span></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right;" colspan="2"><span class="contents">ภาษีมูลค่าเพิ่ม / Vat 7%</span></td>
                        <td style=" text-align: right; padding-right: 2px;"><span class="contents">{{number_format($receive->vat_amount,2)}} </span></td>
                    </tr>
                    <tr class="card-solid">
                        <td style=" padding: 2px;" colspan="3" class="text-center"><b><span class="contents">{{num2thai($receive->sum)}} </span></b></td>
                        <td style=" padding: 2px;" colspan="3" class="text-right"><b><span class="contents">ยอดเงินสุทธิ / Net Total</span></b></td>
                        <td style=" padding: 2px;" class="text-right"><b><span class="contents">{{number_format($receive->sum, 2)}}</span></b></td>
                    </tr>

                </tbody>

            </table>
        </div>
        <table style="width: 100%; margin-top: 2px;">
            <tr>
                <td style="width: 30%; text-align: center;">
                    <table style="width: 100%;">
                        <span class="content_small">Create by</span>
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                @if($receive->user->signature) <img src="{{ Storage::disk('spaces')->url($receive->user->signature)}}" width="100px" height="40px">@endif
                                <span class="foot_contents">
                                    </br>{{$receive->user->name}}
                                    </br>วันที่/Date {{ \Carbon\Carbon::createFromFormat('Y-m-d', $receive->date)->format('d/m/Y')}}</span>
                            </th>
                        </tr>
                    </table>
                </td>
                <td style="width: 30%; text-align: center;">
                    <table style="width: 100%;">
                        <span class="content_small">Approve by</span>
                        @if($receive->user_approve)
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                @if($receive->user_approve->signature) <img src="{{ Storage::disk('spaces')->url($receive->user_approve->signature)}}" width="100px" height="40px">@endif
                                <span class="foot_contents">
                                    </br>{{$receive->user_approve->name}}
                                    </br>วันที่/Date @if($receive->approveDate){{ $receive->approveDate->format('d/m/Y') }}@endif</span>
                            </th>
                        </tr>
                        @else
                        <tr class="card-solid">
                            <th style="padding-top: 10px; padding: 11px;" class="text-center">
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



    </page>
</body>

<script>
    $(function() {
        window.focus();
        window.print();
    });
</script>

</html>