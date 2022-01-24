@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">หัก ณ ที่จ่าย</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">หัก ณ ที่จ่าย</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="card" id="app">
    <div class="card-header">
        <h3 class="card-title">หัก ณ ที่จ่าย</h3>
    </div>
    <div class="card-body table-responsive">
        <form action="/wht/update/{{$wht->id}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ผู้ขาย</label>
                        <select name="supplier_id" id="supplier_id" class="form-control form-control-sm select2">
                            @foreach($suplliers as $supllier)
                            <option value="{{$supllier->id}}" @if($supllier->id == $wht->supplier_id) selected @endif>{{$supllier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ประเภท</label>
                        <select name="type" id="type" class="form-control form-control-sm select2">
                            <option value="ภ.ง.ด53" @if($wht->type == 'ภ.ง.ด53') selected @endif>หัก ภ.ง.ด53</option>
                            <option value="ภ.ง.ด3" @if($wht->type == 'ภ.ง.ด3') selected @endif>ภ.ง.ด3</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ผู้จ่ายเงิน</label>
                        <select name="wht_payment_type" id="wht_payment_type" class="form-control form-control-sm select2">
                            <option value="หัก ณ ที่จ่าย" @if($wht->wht_payment_type == 'หัก ณ ที่จ่าย') selected @endif>หัก ณ ที่จ่าย</option>
                            <option value="ออกตลอด" @if($wht->wht_payment_type == 'ออกตลอด') selected @endif>ออกตลอด</option>
                            <option value="ออกครั้ง1" @if($wht->wht_payment_type == 'ออกครั้ง1') selected @endif>ออกครั้ง1</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>วันที่</label>
                        <input required type="text" readonly autocomplete="off" name="date" class="form-control form-control-sm" id="date" value="{{$wht->date}}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ชื่อ</label>
                        <input required type="text" autocomplete="off" name="name" id="name" class="form-control form-control-sm" value="{{$wht->name}}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>Tax Id</label>
                        <input required type="text" autocomplete="off" name="tax_id" id="tax_id" maxlength="13" minlength="13" class="form-control form-control-sm" value="{{$wht->tax_id}}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>Address</label>
                        <input required type="text" autocomplete="off" name="address" id="address" class="form-control form-control-sm" value="{{$wht->address}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ลักษณะการยื่น</label>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attribute" v-model="attribute" value="ยื่นปกติ" @if($wht->attribute == 'ยื่นปกติ') checked @endif>
                                <label class="form-check-label">ยื่นปกติ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attribute" v-model="attribute" value="ยื่นเพิ่มเติม ครั้งที่" @if($wht->attribute == 'ยื่นเพิ่มเติม ครั้งที่') checked @endif>
                                <label class="form-check-label">ยื่นเพิ่มเติม ครั้งที่</label>
                            </div>
                            <input type="text" autocomplete="off" name="attribute_count" id="attribute_count" class="form-control form-control-sm" value="{{$wht->attribute_count}}">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label>ระบุ</label>
                        <textarea name="note" id="note" cols="30" rows="2" class="form-control">{{$wht->note}}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th>NO</th>
                                <th>Type</th>
                                <th>Article</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>WHT TAX</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(wht, index) in wht_lists">
                                <td>1</td>
                                <td>
                                    <input required v-model="wht.type_show" style="cursor: pointer;" readonly type="text" name="type_show[]" class="form-control form-control-sm" data-toggle="modal" data-target="#modal-default" @click="set_index(index)">
                                    <input required v-model="wht.type" style="cursor: pointer;" readonly type="hidden" name="wht_type[]" class="form-control form-control-sm" data-toggle="modal" data-target="#modal-default" @click="set_index(index)">
                                </td>
                                <td>
                                    <input required v-model="wht.article" type="text" name="article[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input required v-model="wht.note" type="text" name="wht_note[]" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input required v-model="wht.amount" type="text" name="amount[]" class="form-control form-control-sm" @keyup="cal(index)">
                                </td>
                                <td>
                                    <input required v-model="wht.rate" type="text" name="rate[]" class="form-control form-control-sm" @keyup="cal(index)">
                                </td>
                                <td class="text-right">
                                    <input required v-model="wht.wht_tax" type="hidden" name="wht_tax[]" class="form-control form-control-sm">
                                    @{{wht.wht_tax}}
                                </td>
                                <td>
                                    <span class="text-info" style="cursor: pointer;" @click="add()"><i class="fa fa-plus"></i> เพิ่มแถวใหม่</span>
                                    <span @click="remove(index)" style="cursor: pointer;" v-if="wht_lists.length > 1" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span>
                                </td>

                                <div class="modal fade" id="modal-default">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Account</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <select class="form-control form-control-sm select2" id="wht_group_id">
                                                    <option v-for="(wht_group, id) in wht_groups" v-bind:value="wht_group.id">@{{wht_group.name}} (@{{wht_group.percent}}%)</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                                <button type="button" class="btn btn-primary" @click="select_account()" data-dismiss="modal">เลือก</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button style="float: right;" type="submit" class="btn btn-outline-success btn-sm">บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('header')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 30px;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 31px !important;
        padding-top: 5px !important;
        user-select: none;
        -webkit-user-select: none;
        border-radius: 0px;
    }
</style>
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('footer')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<!-- Select2 -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://taweechai-bucket.s3-ap-southeast-1.amazonaws.com/upvc/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({width: '100%'})

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#date').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        })
    })
</script>

<script>
    var sups = {!!$suplliers!!}

    $(function(){
      $('#supplier_id').on('change', getSupplier);
      async function getSupplier()
      {
          console.log(sups)
          var sup = await find($('#supplier_id').val())
          console.log(sup.name)

          document.getElementById('name').value = sup.name;
          document.getElementById('tax_id').value = sup.txt_tin;
          document.getElementById('address').value = sup.address;
      }
    });

    function find(sup_id) {
        for (var i = 0; i < this.sups.length; i++) {
            if (this.sups[i].id == sup_id) {
                return this.sups[i];
            }
        }
    }

    var app = new Vue({
        el: '#app',
        data() {
            return {
                attribute: 'ยื่นปกติ',
                wht_lists: {!!$wht->wht_lists!!},
                wht_groups: '{!!$wht_groups!!}',
                index: '',
            }
        },
        mounted() {
            console.log(this.wht_lists)
            this.wht_groups = JSON.parse(this.wht_groups)

            for(var i = 0; i < this.wht_lists.length; i++){
                var res = this.find(this.wht_lists[i].wht_group_id);

                this.wht_lists[i].type = res.id;
                this.wht_lists[i].type_show = res.name + '(' + res.percent +')';
            }
        },
        watch: {
            attribute() {
                if (this.attribute == 'ยื่นปกติ') {
                    document.getElementById('attribute_count').required = false;
                } else {
                    document.getElementById('attribute_count').required = true;
                }
            }
        },
        methods: {
            select_account: async function() {
                console.log(this.index)
                var wht_group_id = document.getElementById('wht_group_id').value;;

                var res = await this.find(wht_group_id);

                this.wht_lists[this.index].type = res.id;
                this.wht_lists[this.index].type_show = res.name + '(' + res.percent +')';
                this.wht_lists[this.index].rate = res.percent;

                this.cal(this.index)
            },
            set_index(index) {
                this.index = index;
            },
            find(id) {
                for (var i = 0; i < this.wht_groups.length; i++) {
                    if (this.wht_groups[i].id == id) {
                        return this.wht_groups[i];
                    }
                }
            },
            add() {
                this.wht_lists.push({
                    type: '',
                    article: 'มาตรา 3 เตรส',
                    note: '',
                    amount: '',
                    rate: '',
                    wht_tax: 0,
                });
            },
            remove(index) {
                this.wht_lists.splice(index, 1);
            },
            cal(index) {
                if (!this.wht_lists[index].amount || !this.wht_lists[index].rate) {
                    return;
                }
                this.wht_lists[index].wht_tax = ((parseFloat(this.wht_lists[index].amount) * parseFloat(this.wht_lists[index].rate)) / 100).toFixed(2);
            }
        },
    });
</script>
@endsection