<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Builder</title>
    <style>
        @import url('http://fontlibrary.org/face/thsarabun-new');
    </style>
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
                <img src="{{asset('/logo.jpg')}}" style="width: 130px;">
                <br>
                <b class="font-head">ใบสั่งซื้อ</b>
            </div>
            <div class="col-6 text-right">
                <b class="font-subhead">ใบสั่งซื้อ</b>
                <div class="form-group">
                    <b class="font-content">เลขที่ใบสั่งซื้อ </b> <span class="font-content">#{{$po->code}}</span><br>
                    <b class="font-content">วันที่สั่งซื้อ </b> <span class="font-content">{{$po->po_date}}</span><br>
                    <b class="font-content">กำหนดส่ง </b> <span class="font-content">{{$po->due_date}}</span><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <b class="font-content">ผู้ขาย </b> <span class="font-content">{{$po->supplier->name}}</span><br>
                    <b class="font-content">ที่อยู่ </b> <span class="font-content">{{$po->supplier->address}}</span><br>
                    <b class="font-content">โทรศัพท์ </b> <span class="font-content">{{$po->supplier->tel}}</span><br>
                    <b class="font-content">เลขประจำตัวผู้เสียภาษี </b> <span class="font-content">{{$po->supplier->txt_tin}}</span><br>
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
                    <b class="font-content">สถานที่จัดส่ง </b> <span class="font-content">{{$po->address}}</span><br>
                    <b class="font-content">ผู้รับผิดชอบ </b> <span class="font-content">{{$po->main_user->name}}</span><br>
                    <b class="font-content">โทรศัพท์ </b> <span class="font-content">{{$po->tel}}</span><br>
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
                            <th scope="col" class="text-right">ราคาต่อหน่วย</th>
                            <th scope="col" class="text-right">ส่วนลดต่อหน่วย</th>
                            <th scope="col" class="text-right">จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($po->purchaseOrderLists as $i => $list)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->amount}}</td>
                            <td>{{$list->unit}}</td>
                            <td class="text-right">{{number_format($list->unit_price,3)}}</td>
                            <td class="text-right">{{number_format($list->unit_discount,2)}}</td>
                            <td class="text-right">{{number_format($list->price,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">
                        <b class="font-content">เงื่อนไขการชำระเงิน </b> <span class="font-content">{{$po->patment_condition}}</span><br>
                        <b class="font-content">การชำระเงิน </b> <span class="font-content">
                            {{$po->payment_type}} @if($po->payment_type == 'เครดิต') {{$po->cradit}} วัน @endif
                        </span><br>
                        <b class="font-content">หมายเหตุ </b> <span class="font-content">{{$po->note}}</span><br>
                    </div>
                    <div class="col-6 text-right">
                        @if($po->vat_type == 'นอก' || $po->vat_type == 'ใน')
                        <b class="font-content">รวมเป็นเงิน </b> <span class="font-content">{{number_format($po->sum_price,2)}}</span><br>
                        <b class="font-content">VAT</b> <span class="font-content">{{number_format($po->vat_amount,2)}}</span><br>
                        @endif
                        <b class="font-content">จำนวนเงินรวมทั้งสิ้น </b> <span class="font-content">{{number_format($po->sum_price + $po->vat_amount, 2)}}</span><br>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-2 text-center"></div>
                    <div class="col-4 text-center">
                        <span class="font-content">__________________</span><br>
                        <span class="font-content">( {{$po->main_user->name}} )</span><br>
                        <span class="font-content">ผู้สั่งซื้อ</span><br>
                        <span class="font-content">{{$po->po_date}}</span><br>
                    </div>
                    <div class="col-4 text-center text-right">
                        <span class="font-content">_____________________</span><br>
                        <span class="font-content">(_____________________)</span><br>
                        <span class="font-content">ผู้อนมัติ</span><br>
                        <span class="font-content">{{$po->po_date}}</span><br>
                    </div>
                    <div class="col-2 text-center text-right"></div>
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