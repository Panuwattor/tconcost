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
        GL MOVEMENT DETAIL REPORT
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
        @page {
            size: landscape;
        }

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
            border: 2px solid #AEAEAE !important;
        }

        .card-solid1 {
            border: 2px solid #AEAEAE !important;
        }

        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #AEAEAE;
        }

        #example1 {
            border: 2px solid #AEAEAE;
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
                <td style="width: 10%;">
                    @if(auth()->user()->branch->logo)
                    <img style="width: 90%;" src="{{Storage::disk('spaces')->url(auth()->user()->branch->logo)}}" alt="User profile picture">
                    @else
                    <img style="width: 90%;" src="/home.jpg" alt="User profile picture">
                    @endif
                </td>
                <td style="width: 60%;">
                    <span class="subsubject"> <b> {{$branch->company}}</b></span>
                    <small class="subsubject_en"> {{$branch->company_eng}}</small>
                    <hr style="margin-top: 5px ; margin-top: 5px">
                    <small class="subsubject"> {{$branch->address}}</small>
                    <small class="subsubject"> โทร : {{$branch->tel}}</small> <br>
                    <small class="subsubject">เลขประจำตัวผู้เสียภาษี : {{$branch->tax}} ({{$branch->tax_code}})</small> <br>
                </td>
                <td style="width: 30%; text-align: right;">
                    <div id="example2">
                        <table style="width: 100%; text-align: right;" class="purchase-background">
                            <tr>
                                <td style="width: 100%; text-align: center; padding: 16px;">
                                    <span class="subsubject_tax"><b>รายงานหัก ณ ที่จ่าย</b></span><br>
                                    <span class="contents">{{$from}} To {{$to}}</span><br>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 5px; border-radius: 10px!important;" class="card-solid1">
            <tr style="background-color: #8AADCC!important;" class="card-solid1">
                <th style="padding: 5px;"><span class="contents">รหัส/วันที่จ่าย</span></th>
                <th style="padding: 5px;"><span class="contents">ผู้ถูกหัก ณ ที่จ่าย</span></th>
                <th style="padding: 5px;"><span class="contents">TAX ID</span></th>
                <th style="padding: 5px;"><span class="contents">ที่อยู่</span></th>
                <th style="padding: 5px;"><span class="contents">รายการ</span></th>
                <th style="padding: 5px;"><span class="contents">%</span></th>
                <th style="padding: 5px;"><span class="contents">จำนวนเงิน </span></th>
                <th style="padding: 5px;"><span class="contents">หัก ณ ที่จ่าย</span></th>
            </tr>
            <tbody>
                <?php
                $_amount = 0;
                $_wht_tax = 0;
                ?>
                @foreach($data->groupBy('date') as $row_group)
                <tr>
                    <th colspan="9" style="padding: 5px;"><span class="contents">{{$row_group->first()->date}}</span></th>
                </tr>
                <?php
                $_am = 0;
                $_tax = 0;
                ?>
                @foreach($row_group as $i => $row)
                <tr class="card-solid">
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;"><span class="contents">{{$row->code}}</span></td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;"><span class="contents">{{$row->supplier->name}}</span></td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;"><span class="contents">{{$row->tax_id}}</span></td>
                    <td rowspan="{{$row->wht_lists->count()}}" style="vertical-align: middle;"><span class="contents">{{$row->address}}</span></td>
                    <td class="text-center"><span class="contents">{{$row->wht_lists->first()->note}}</span></td>
                    <td class="text-center"><span class="contents">{{number_format($row->wht_lists->first()->rate, 2)}}%</span></td>
                    <td class="text-center"><span class="contents">{{number_format($row->wht_lists->first()->amount, 2)}}</span></td>
                    <td class="text-center"><span class="contents">{{number_format($row->wht_lists->first()->wht_tax, 2)}}</span></td>
                </tr>
                <?php
                $_am = $_am + $row->wht_lists->first()->amount;
                $_tax = $_tax + $row->wht_lists->first()->wht_tax;
                ?>
                @foreach($row->wht_lists as $x => $wht_list)
                @if($x > 0)
                <tr class="text-center">
                    <td>{{$wht_list->note}}</td>
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
                    <th colspan="6" class="text-center"><span class="contents">รวม {{$row->date}}</span></th>
                    <th colspan="" class="text-center"><span class="contents">{{number_format($_am, 2)}}</span></th>
                    <th class="text-center"><span class="contents">{{number_format($_tax, 2)}}</span></th>
                </tr>
                <?php
                $_amount = $_amount + $_am;
                $_wht_tax = $_wht_tax + $_tax;
                ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-center"><span class="contents">รวมทั้งสิ้น</span></th>
                    <th class="text-center"><span class="contents">{{number_format(($_amount), 2)}}</span></th>
                    <th class="text-center"><span class="contents">{{number_format(($_wht_tax), 2)}}</span></th>
                </tr>
            </tfoot>
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