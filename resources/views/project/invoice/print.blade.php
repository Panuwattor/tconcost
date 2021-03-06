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
    <title> INVOICE {{$invoice->code}}</title>
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
            line-height: 115%;
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
            margin-top: 5px ;
            margin-bottom: 5px ;
            border: 1px solid #AEAEAE ;
        }

        #example1 {
            border: 1px solid #AEAEAE;
            padding: 10px;
            border-radius: 10px;
            margin-top: 5px ;
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
                    @if($invoice->project->branch->logo)
                    <img style="width: 90%;" src="{{Storage::disk('spaces')->url($invoice->project->branch->logo)}}" alt="User profile picture">
                    @else
                    <img style="width: 90%;" src="/home.jpg" alt="User profile picture">
                    @endif
                </td>
                <td style="width: 50%;">
                <span class="subsubject"> <b> {{$invoice->project->branch->company}}</b></span> <br>
                <small class="subsubject_en">  {{$invoice->project->branch->company_eng}}</small>
                <hr style="margin-top: 5px ; margin-top: 5px">
                <small class="subsubject"> {{$invoice->project->branch->address}}</small> <br>
                <small class="subsubject"> ????????? : {{$invoice->project->branch->tel}}</small> <br>
                <small class="subsubject">?????????????????????????????????????????????????????????????????? : {{$invoice->project->branch->tax}} ({{$invoice->project->branch->tax_code}})</small> <br>
                </td>
                <td style="width: 30%; text-align: right;">
                <div id="example2">
                    <table style="width: 100%; text-align: right;" class="purchase-background">
                        <tr>
                            <td style="width: 100%; text-align: center; padding: 15px;">
                                <span class="subsubject"><b>??????????????????????????????</b></span><br>
                                <span class="contents">INVOICE</span>
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
                <td style="width: 60%;" class="card-solid">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 20%; padding: 5px;">
                                <span class="contents"><b>????????????????????? (Project)</b></span><br>
                            </td>
                            <td style="width: 60%; padding: 5px;"><span class="contents"> {{$invoice->project->code}} {{$invoice->project->name}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; padding: 5px;">
                                <span class="contents"><b>???????????? (Name)</b></span><br>
                            </td>
                            <td style="width: 60%; padding: 5px;"><span class="contents">{{$invoice->project->customer->name}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; padding: 5px;">
                                <span class="contents"><b>????????????????????? (Address)</b></span><br>
                            </td>
                            <td style="width: 60%; padding: 5px;"><span class="contents">{{$invoice->project->customer->address}}</span></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%; text-align: right;" class="card-solid">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 60%; padding: 5px;">
                                <span class="contents"><b>?????????????????? (No.)</b></span><br>
                            </td>
                            <td style="width: 40%; padding: 5px;"><span class="contents">{{$invoice->code}}</span></td>
                        </tr>
                        <tr>
                            <td style="width: 60%; padding: 5px;">
                                <span class="contents"><b>?????????????????? (Date)</b></span><br>
                            </td>
                            <td style="width: 40%; padding: 5px;"><span class="contents">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->date)->format('d/m/Y')}}</span></td>
                        </tr>

                        <tr>
                            <td style="width: 60%; padding: 5px;">
                                <span class="contents"><b>????????????????????????????????????(DueDate)</b></span><br>
                            </td>
                            <td style="width: 40%; padding: 5px;"><span class="contents">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->date)->addDays($invoice->credit_amount ?: 0)->format('d/m/Y')}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div>

        <table style="width: 100%; margin-top: 5px; border-radius: 10px!important;">
            <tr style="background-color: #ddd!important; padding: 10px;" class="card-solid">
                <th style="padding: 10px; text-align: center;"><span class="contents">???????????????</br>No.</span></th>
                <th style="padding: 10px; text-align: center; width: 60%;"><span class="contents">??????????????????</br>Description</span></th>
                <th style="padding: 10px; text-align: center;"><span class="contents">???????????????</br>QTY.</span></th>
                <th style="padding: 10px; text-align: right;width: 15%;"><span class="contents">????????????/???????????????</br>Unit/Price</span></th>
                <th style="padding: 10px; text-align: right;"><span class="contents">????????????????????????????????????</br>Amount</span></th>
            </tr>
            <tbody>
            @foreach($invoice->incomes as $no=>$list)
                    <tr class="card-solid">
                        <td style="padding: 10px; text-align: center;"><span class="contents">{{$no+1}}</span></td>
                        <td style="padding: 10px; text-align: left;"><span class="contents">{{$list->description}}</span></td>
                        <td style="padding: 10px; text-align: center;"><span class="contents">1</span></td>
                        <td style="padding: 10px; text-align: right;"><span class="contents">{{number_format($list->total, 2)}}</span></td>
                        <td style="padding: 10px; text-align: right;"><span class="contents">{{number_format($list->total, 2)}}</span></td>
                    </tr>
            @endforeach   
                <tr>
                    <td style="padding-top: 5px;" colspan="2" rowspan="5" class="top"><span class="foot_contents"> <b>???????????????????????? (Remarks) : </b> {{$invoice->note}}</span></td>
                    <td style="padding-top: 5px;" colspan="2"><span class="contents">??????????????????????????? (Total)</span></td>
                    <td style="padding-top: 5px; text-align: right; padding-right: 5px;"><span class="contents">{{number_format($invoice->incomes->sum('total'),2)}}</span></td>
                </tr>
                <tr>
                    <td style="padding-top: 5px;" colspan="2"><span class="contents">?????????????????? (Discount)</span></td>
                    <td style="padding-top: 5px; text-align: right; padding-right: 5px;"><span class="contents">{{number_format($invoice->discount,2)}}</span></td>
                </tr>
                <tr>
                    <td style="padding-top: 5px;" colspan="2"><span class="contents">??????????????????????????????????????? (Taxbase)</span></td>
                    <td style="padding-top: 5px; text-align: right; padding-right: 5px;"><span class="contents">{{number_format($invoice->tax_base,2)}} </span></td>
                </tr>
                <tr>
                    <td style="padding-top: 5px;" colspan="2"><span class="contents">????????????????????????????????????????????? (Vat)</span></td>
                    <td style="padding-top: 5px; text-align: right; padding-right: 5px;"><span class="contents">{{number_format($invoice->vat_amount,2)}}</span></td>
                </tr>

                </tbody>

        </table>
        <table style="width: 100%; margin-top: 5px;">
                <tr class="card-solid">
                    <th style="padding-top: 10px; padding: 10px;" class="text-center"><b><span class="contents">{{num2thai($invoice->total)}} </span></b></th>
                    <th style="padding-top: 10px; padding: 10px;" class="text-right"><b><span class="contents">????????????????????????????????????????????? (Grand Total)</span></b></th>
                    <th style="padding-top: 10px; padding: 10px;" class="text-right"><b><span class="contents">{{number_format($invoice->total,2)}}</span></b></th>
                </tr>
        </table>
        </div>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 40%;"></td>
                <td style="width: 30%; text-align: center;">
                <table style="width: 100%; margin-top: 2px;">
                        <tr class="card-solid">
                        <th style="padding-top: 10px; padding: 10px;" class="text-center"></b><span class="foot_contents"></br></br></br>????????????????????????????????????</span></b></th>
                        </tr>
                </table>
                </td>
                <td style="width: 30%; text-align: center;">
                <table style="width: 100%; margin-top: 2px;">
                        <tr class="card-solid">
                        <th style="padding-top: 10px; padding: 10px;" class="text-center"></b><span class="foot_contents"></br></br></br>???????????????????????????</span></b></th>
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