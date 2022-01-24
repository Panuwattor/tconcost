<div class="col-1 text-right">
    <span style="font-size:20px; cursor:pointer; color: rgba(0,0,0,.5);" onclick="openNav()"><i class="fas fa-bars"></i></span>
    <div id="mySidenav" class="sidenav">
        <div class="row">
            <div class="col-12 text-center" style="padding: 10px; border-bottom: 1px solid #4f5962; cursor: pointer;" onclick="closeNav()">
                <span>Close <i class="far fa-times-circle"></i></i></span>
            </div>
        </div>
        @if($po->receives->whereIn('status', [0, 1, 2])->count() > 0)
        <ul class="mt-2" style="padding: 5px; text-align: left;" data-widget="treeview" role="menu" data-accordion="false">
            <li><i class="fas fa-box-open"></i> รายการรับของ</li>
            <ul class="mt-2" style="padding: 5px;" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($po->receives->whereIn('status', [0, 1, 2]) as $i => $receive)
                <li>
                    <div class="row">
                        <div class="col-12">
                            <a target="_bank" href="/revice/show/{{$receive->id}}"><i class="far fa-circle"></i> {{$receive->receive_code}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </ul>
        @endif
        @if($po->deposits->count() > 0)
        <ul class="mt-2" style="padding: 5px; text-align: left;" data-widget="treeview" role="menu" data-accordion="false">
            <li><i class="fas fa-coins"></i> รายการตั้งมัดจำ</li>
            <ul class="mt-2" style="padding: 5px;" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($po->deposits as $x => $deposit)
                <li>
                    <div class="row">
                        <div class="col-12">
                            <a href="/deposit-pay/show/{{$deposit->id}}"><i class="far fa-circle"></i> {{$deposit->code}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </ul>
        @endif
        @if($po->other_payment_lists->count() > 0)
        <ul class="mt-2" style="padding: 5px; text-align: left;" data-widget="treeview" role="menu" data-accordion="false">
            <li><i class="fas fa-coins"></i> OtherPayment</li>
            <ul class="mt-2" style="padding: 5px;" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($po->other_payment_lists->whereIn('status', [0, 1]) as $x => $other_payment_list)
                <li>
                    <div class="row">
                        <div class="col-12">
                            <a href="/pv/show/{{$other_payment_list->other_payment->id}}"><i class="far fa-circle"></i> {{$other_payment_list->other_payment->code}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </ul>
        @endif

        @if(sizeof($po->invoices_ap) > 0)
        <ul class="mt-2" style="padding: 5px; text-align: left;" data-widget="treeview" role="menu" data-accordion="false">
            <li><i class="fas fa-coins"></i> Invoice AP</li>
            <ul class="mt-2" style="padding: 5px;" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($po->invoices_ap as $x => $invoices_ap)
                <li>
                    <div class="row">
                        <div class="col-12">
                            <a href="/invoice-ap/show/{{$invoices_ap->id}}"><i class="far fa-circle"></i> {{$invoices_ap->code}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </ul>
        @endif
        
        @if(sizeof($po->main_payment) > 0)
        <ul class="mt-2" style="padding: 5px; text-align: left;" data-widget="treeview" role="menu" data-accordion="false">
            <li><i class="fas fa-coins"></i> Main Payment</li>
            <ul class="mt-2" style="padding: 5px;" data-widget="treeview" role="menu" data-accordion="false">
                @foreach($po->main_payment as $x => $main_payment)
                <li>
                    <div class="row">
                        <div class="col-12">
                            <a href="/pm/show/{{$main_payment->id}}"><i class="far fa-circle"></i> {{$main_payment->code}}</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </ul>
        @endif
    </div>
</div>