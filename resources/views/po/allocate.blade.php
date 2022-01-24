@extends('master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">จัดสรรต้นทุน</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">จัดสรรต้นทุน</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row" id="app" v-cloak>
    <div class="col-12 col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ต้นทุน</h3>
            </div>
            <div class="card-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                                <th>ราคาต่อหน่วย</th>
                                <th>ส่วนลด/หน่วย</th>
                                <th>จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>{{$polist->name}}</td>
                                <td>{{$polist->amount}}</td>
                                <td>{{$polist->unit}}</td>
                                <td>{{number_format($polist->unit_price, 2)}}</td>
                                <td>{{number_format($polist->unit_discount, 2)}}</td>
                                <td>{{number_format($polist->price, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">จัดสรรต้นทุน</h3>
            </div>
            <div class="card-body">
                <form action="/allocate" method="post">
                    @csrf
                    <input type="hidden" name="po_list_id" value="{{$polist->id}}">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <td>โครงการ</td>
                                <td>ต้นทุน</td>
                                <td>จำนวนเงิน</td>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in arr">
                                    <td>
                                        <div class="form-group">
                                            <select v-model="item.project" required class="form-control" name="project_id[]" :id="'project_id' + index">
                                                <option value="">เลือก</option>
                                                @foreach($projects as $project)
                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input required v-model="item.cost_group_id" name="project_cost_plan_list_id[]" type="hidden" class="form-control readonly" :id="'group_cost' + index" value="" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;" @click="onselect_project(index)">
                                            <input required autocomplete="off" type="text" v-model="item.cost_group" class="form-control readonly" :id="'group_cost_text' + index" value="" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;" @click="onselect_project(index)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input required type="text" v-model="item.price" name="price[]" class="form-control" :id="'allocate_cost' + index" @keyup="cal()">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div>
                                                <span @click="remove(index)" style="cursor: pointer;" v-if="arr.length > 1" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">ต้นทุน</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger alert-dismissible" v-if="!select_state">
                                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                            ยังไม่ได้เลือกโครงการ
                                        </div>

                                        <div v-if="select_state">
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        <tr v-for="(item, loop) in cost_group" @click="select_group_cost(item.cost_plan_name, item.costPlanLists, item.id)" data-dismiss="modal" style="cursor: pointer;">
                                                            <td>@{{item.cost_plan_name}}</td>
                                                            <td>@{{item.costPlanLists}}</td>
                                                            <td>@{{item.note}}</td>
                                                            <td>เหลือ @{{number(item.cost - item.use_cost)}} บาท</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="text-info" style="cursor: pointer;" @click="add()"><i class="fa fa-plus"></i> เพิ่มแถวใหม่</span>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 text-right"></div>
                        <div class="col-12 col-md-6">
                            <div class="card-body">
                                <div class="form-group row" style="margin-bottom: 0px;">
                                    <label class="col-sm-6" style="margin-bottom: 0px;">จัดสรรไปแล้ว</label>
                                    <div class="col-sm-6 text-right">
                                        <label style="margin-bottom: 0px;">@{{number(allocate)}}</label>
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid black">
                                <div class="form-group row" style="margin-bottom: 0px;">
                                    <label class="col-sm-6" style="margin-bottom: 0px;">มูลค่ารายการ</label>
                                    <div class="col-sm-6 text-right">
                                        <label style="margin-bottom: 0px;">{{number_format($polist->price, 2)}}</label>
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid black; margin-bottom: 5px;">
                                <hr style="border-top: 1px solid black; margin-top: 0px;">
                                <div class="form-group row" style="margin-bottom: 0px;">
                                    <label class="col-sm-6 text-danger" style="margin-bottom: 0px;">เหลืออีก</label>
                                    <div class="col-sm-6 text-right">
                                        <label style="margin-bottom: 0px;" class="text-danger">@{{number(total)}}</label>
                                    </div>
                                </div>

                                <br>
                                <button id="btn_submit" type="submit" class="btn btn-block btn-outline-success">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: " ";
        display: block;
        position: absolute;
        width: 80px;
        height: 80px;
        background-image: url(http://pluspng.com/img-png/loader-png-indicator-loader-spinner-icon-512.png);
        background-size: cover;
        left: 40%;
        top: 40%;
    }
</style>
@endsection

@section('footer')
<!-- vue cdn -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js" integrity="sha256-T/f7Sju1ZfNNfBh7skWn0idlCBcI3RwdLSS4/I7NQKQ=" crossorigin="anonymous"></script>
<!-- numeral -->
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                arr: new Array(),
                select_state: '',
                arr_group: '',
                cost_group: {
                    cost_plan_name: '',
                    costPlanLists: '',
                    cost: '',
                },
                id: '',
                allocate: 0,
                TOTAL: '{{-$polist->price}}',
                total: 0,
            }
        },
        mounted() {
            $(".readonly").on('keydown paste', function(e) {
                e.preventDefault();
            });

            this.total = this.TOTAL;
            if (this.total == 0) {
                document.getElementById('btn_submit').disabled = false;
            } else {
                document.getElementById('btn_submit').disabled = true;
            }
        },
        created() {
            this.arr.push({
                project: '{{$polist->po->project_id}}',
                cost_group: '',
                cost_group_id: '',
                price: '',
            });
        },
        methods: {
            add() {
                this.arr.push({
                    project: '{{$polist->po->project_id}}',
                    cost_group: '',
                    cost_group_id: '',
                    price: '',
                });
            },
            remove(id) {
                this.arr.splice(id, 1);
                this.cal();
            },
            onselect_project: async function(index) {
                console.log(this.arr)
                var pro_id = document.getElementById('project_id' + index).value
                this.select_state = pro_id;

                var res = await axios.post('/get/group-cost', {
                    pro_id: pro_id
                });
                this.cost_group = res.data;
                this.id = index;
            },
            number(value) {
                return numeral(value).format('0,0.00');
            },
            select_group_cost(cost_plan_name, costPlanLists, id) {
                this.arr[this.id].cost_group_id = id;
                this.arr[this.id].cost_group = cost_plan_name + '/' + costPlanLists;
                console.log(this.arr)
            },
            cal() {
                var sum = 0;
                for (var x = 0; x < this.arr.length; x++) {
                    sum = sum + parseFloat(this.arr[x].price);
                }

                this.allocate = sum;
                this.total = parseFloat(sum) + parseFloat(this.TOTAL);
                if (this.total == 0) {
                    document.getElementById('btn_submit').disabled = false;
                } else {
                    document.getElementById('btn_submit').disabled = true;
                }
            }
        },
    });
</script>
@endsection