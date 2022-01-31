<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Builder</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            font-family: "TH Sarabun New";
        }

        .font-head {
            font-size: 26pt;
        }

        .font-subhead {
            font-size: 24pt;
        }

        .font-content {
            font-size: 18pt;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-6 text-center">
                @if($ap->branch->logo)
                    <img src="{{Storage::disk('spaces')->url($ap->branch->logo)}}" style="width: 130px;">

                    @else
                    <img src="{{asset('/home.jpg')}}" style="width: 130px;">
                    @endif
                <br>
                <b class="font-head">ใบขอราคา</b>
            </div>
            <div class="col-6 text-right">
                <b class="font-subhead">ใบขอราคา</b>
                <div class="form-group">
                    <b class="font-content">เลขที่ใบขอราคา </b> <span class="font-content">#{{$ap->ap_id}}</span><br>
                    <b class="font-content">วันที่ </b> <span class="font-content">{{$ap->ap_date}}</span><br>
                    <b class="font-content">หมดเขต </b> <span class="font-content">{{$ap->finish_date}}</span><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <b class="font-content">Supplier </b> <span class="font-content">{{$supplier->name}}</span><br>
                    <b class="font-content">ที่อยู่ </b> <span class="font-content">{{$supplier->address}}</span><br>
                    <b class="font-content">โทรศัพท์ </b> <span class="font-content">{{$supplier->tel}}</span><br>
                    <b class="font-content">โทรสาร </b> <span class="font-content">{{$supplier->fax}}</span><br>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <b class="font-content">ผู้ซื้อ </b> <span class="font-content">Taweechai perfect builder co. ltd</span><br>
                    <b class="font-content">ที่อยู่ </b> <span class="font-content">998/55-56 ถนนกวงเฮง ตำบลเมืองใต้ อำเภอเมือง จังหวัดศรีสะเกษ 33000</span><br>
                    <b class="font-content">เบอร์โทร </b> <span class="font-content">045 - 962627</span><br>
                    <b class="font-content">เลขประจำตัวผู้เสียภาษี </b> <span class="font-content">0564423198</span><br>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <b class="font-content">วิธีจัดส่ง </b> <span class="font-content">{{$ap->delivery}}</span><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table font-content">
                    <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">รายการ</th>
                            <th scope="col">จำนวน</th>
                            <th scope="col">หน่วย</th>
                            <th scope="col">ราคาต่อหน่วย</th>
                            <th scope="col">ส่วนลด</th>
                            <th scope="col">มูลค่า</th>
                            <th scope="col">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ap->Ask_price_lits as $i => $list)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->amount}}</td>
                            <td>{{$list->unit}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <b class="font-content">หมายเหตุ </b> <span class="font-content">{{$ap->note}}</span><br>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <b class="font-content">รวมเป็นเงิน </b> <span class="font-content">_____________________________________________</span><br>
                        <b class="font-content">ส่วนลดพิเศษ </b> <span class="font-content">____________________________________________</span><br>
                        <b class="font-content">จำนวนเงินหลังหักส่วนลด </b> <span class="font-content">__________________________________</span><br>
                        <b class="font-content">VAT 7% </b> <span class="font-content">_______________________________________________</span><br>
                        <b class="font-content">จำนวนเงินรวมทั้งสิ้น </b> <span class="font-content">______________________________________</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>

</html>