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
       {{$invoice->code}}
    </title>
    <link rel="icon" href="{{ asset('/icon.jpg') }}">
    <link rel="stylesheet" media="screen" href="http://fontlibrary.org/face/thsarabun-new" type="text/css"/>
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
            font-size: 16pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
        }

        span.subsubject_tax {
            font-size: 17pt;
            line-height: 115%;
            font-family: "TH Sarabun New";
        }

        small.subsubject {
            font-size: 13pt;
            line-height: 100%;
            font-family: "TH Sarabun New";
        }
        small.subsubject_en {
            font-size: 12pt;
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
            margin-left: 10px ;
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
        .card-solid-foot {
            border: 1px solid #AEAEAE !important;
        }
        
        hr {
            margin-top: 5px ;
            margin-bottom: 5px ;
            border: 1px solid #AEAEAE ;
        }

        #example1 {
            border: 2px solid #AEAEAE;
            padding: 10px;
            border-radius: 10px;
            margin-top: 5px ;
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
                    <img style="width: 90%;" src="https://mytcg.sgp1.digitaloceanspaces.com/{{$invoice->project->branch->logo}}" alt="User profile picture">
                </td>
                <td style="width: 65%;">
                <span class="subsubject"> <b> {{$invoice->project->branch->company}}</b></span> 
                <small class="subsubject_en">  {{$invoice->project->branch->company_eng}}</small>
                <hr style="margin-top: 5px ; margin-top: 5px">
                <small class="subsubject"> {{$invoice->project->branch->address}}</small>
                <small class="subsubject"> โทร : {{$invoice->project->branch->tel}}</small> <br>
                <small class="subsubject">เลขประจำตัวผู้เสียภาษี : {{$invoice->project->branch->tax}} ({{$invoice->project->branch->tax_code}})</small> <br>
                </td>
                <td style="width: 25%; text-align: center;">
                <small class="subsubject"> ใบสำคัญซื้อ (ตั้งหนี้จาก PO)</small>
                     <div id="example2">
                        <table style="width: 100%; text-align: right;">
                            <tr>
                                <td style="width: 100%; text-align: center; padding: 10px;">
                                    <span class="subsubject_tax"><b>ใบสำคัญซื้อ</b></span><br>
                                    <small class="subsubject"> ACCOUNTPAYABLE VOUCHER</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>


        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td style="width: 60%;padding: 5px; " class="card-solid" >
                    <table style="width: 100%; " >
                        <tr >
                            <td style="width: 25%;">
                                <span class="contents"><b>ผู้ขาย / พนักงาน</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$invoice->supplier->name}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <span class="contents"><b>โครงการ</b></span><br>
                            </td>
                            <td style="width: 60%;"><span class="contents">{{$invoice->project->code}} {{$invoice->project->name}}</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: right;padding: 5px;" class="card-solid">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>เลขที่ใบสำคัญ</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{$invoice->code}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;">
                                <span class="contents"><b>วันที่เอกสาร</b></span><br>
                            </td>
                            <td style="width: 50%;"><span class="contents">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->date)->format('d/m/Y')}} </span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width: 100%; margin-top: 5px; border-radius: 10px!important;" border>
            <tr style="background-color: #ddd!important; padding: 10px;" class="card-solid">
                <th style="padding: 5px; text-align: center;"><span class="contents">รหัสบัญชี</span></th>
                <th style="padding: 5px; text-align: center; width: 50%;"><span class="contents">ชื่อบัญชี</span></th>
                <th style="padding: 5px; text-align: center;"><span class="contents">เดบิต</span></th>
                <th style="padding: 5px; text-align: center;"><span class="contents">เครดิต</span></th>
                <th style="padding: 5px; text-align: center;"><span class="contents">รหัสโครงการ</span></th>
            </tr>
            <tbody>
            @foreach($invoice->account_views as $x => $account_view)
                    <tr class="card-solid">
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$account_view->accounting->code}}</span></td>
                        <td style="padding: 5px; text-align: left;"><span class="contents">{{$account_view->accounting->name}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($account_view->debit,2)}}</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($account_view->credit,2)}}</span></td>
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{$account_view->project->code}}</span></td>
                    </tr>
            @endforeach   
            </tbody>
            <tfoot>
                    <tr class="card-solid">
                        <td style="padding: 5px; text-align: center;" colspan="2"><span class="contents">TOTAL</span></td>
                        <td style="padding: 5px; text-align: right;"><span class="contents">{{number_format($invoice->account_views->sum('debit'),2)}}</span></td>
                        <td style="padding: 5px; text-align: center;"><span class="contents">{{number_format($invoice->account_views->sum('credit'),2)}}</span></td>
                        <td style="padding: 5px; text-align: center;"></td>
                    </tr>
            </tfoot>
        </table>
        <span class="contents">หมายเหตุ : {{$invoice->note}}</span>
        <table style="width: 100%; margin-top: 2px;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <table style="width: 100%;">
                        <tr class="card-solid">
                        <th style="padding-top: 10px; padding: 10px;" class="text-center">

                           <span class="content_small">ผู้จัดทำ / ผู้ลงบัญชี</span> </br>
                                @if($invoice->user->signature) <img src="{{ Storage::disk('spaces')->url($invoice->user->signature) }}" width="100px" height="40px">@endif
                                <span class="foot_contents">
                                    </br>{{$invoice->user->name}}
                                    </br>วันที่/Date {{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->date)->format('d/m/Y')}}</span>
                            </th>
                        </tr>
                    </table>
                </td>

                <td style="width: 50%; text-align: center;">
                    <table style="width: 100%;">
                         <tr class="card-solid">
                        <th style="padding-top: 10px; padding: 10px;" class="text-center">
                                <span class="content_small">ผู้อนุมัติ</span></br>
                                @if($invoice->user_approve && $invoice->user_approve_time)
                                @if($invoice->user_approve->signature) <img src="{{ Storage::disk('spaces')->url($invoice->user_approve->signature) }}" width="100px" height="40px">@endif
                                <span class="foot_contents"></br>{{$invoice->user_approve->name}}</br>วันที่/Date  {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $invoice->user_approve_time)->format('d/m/Y')}}</span>
                                @else
                                <span class="foot_contents"></br></br>----------------------------------------------</br>วันที่/Date  _______/____________/__________</span>
                                @endif
                            </th>
                        </tr>
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