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

<!-- id="app" v-cloak -->
<div class="row" id="app" v-cloak>
    <div class="col-12">
        <template v-for="(po_list, po_lists_index) in po_lists">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ต้นทุน</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover" style="font-size: 8pt;">
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
                                            <td>@{{po_list.name}}</td>
                                            <td>@{{po_list.amount}}</td>
                                            <td>@{{po_list.unit}}</td>
                                            <td>@{{number(po_list.unit_price)}}</td>
                                            <td>@{{number(po_list.unit_discount)}}</td>
                                            <td>@{{number(po_list.price)}}</td>
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
                            <input type="hidden" name="po_list_id">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover" style="font-size: 10pt;">
                                    <thead>
                                        <td style="width: 30%;">โครงการ</td>
                                        <td style="width: 30%;">ต้นทุน</td>
                                        <td style="width: 20%;">จำนวนเงิน</td>
                                        <td style="width: 20%;"class=" text-right">
                                            <span class="text-info" style="cursor: pointer;" @click="add(po_lists_index)"><i class="fa fa-plus"></i> เพิ่มแถว</span>
                                        </td>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(allocate, allocate_index) in po_list.allocates">
                                            <td>
                                                <div class="form-group">
                                                    <select v-model="allocate.project_id" required class="form-control form-control-sm">
                                                        <option value="">เลือก</option>
                                                        @foreach($projects as $project)
                                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input required autocomplete="off" readonly type="text" v-model="allocate.project_cost_plan_list_name" :title="allocate.project_cost_plan_list_name" class="form-control form-control-sm readonly" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;" @click="get_group_cost(po_lists_index, allocate_index)">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input required type="text" v-model="allocate.price" class="form-control form-control-sm"  @click="sum_price()" @change="sum_price()">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <div>
                                                        <span @click="remove(po_lists_index, allocate_index)" style="cursor: pointer;" v-if="po_list.allocates.length > 1" class="text-danger"><i class="fa fa-trash-o"></i> ลบ</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    ทั้งหมด <code>@{{number(po_list.price)}}</code> บาท จัดสรรไปแล้ว <code>@{{number(po_list.sum_price)}}</code> บาท ( <a class="text-success">@{{number(po_list.price - po_list.sum_price)}}</a> )
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <div class="modal fade bd-example-modal-lg" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ต้นทุน</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="row mb-3">
                            <div class="col-6"></div>
                            <div class="col-6 input-group">
                                <input type="text" v-model="search_value" class="form-control form-control-sm" placeholder="Search">
                                <div class="input-group-append">
                                    <span style="cursor: pointer;" class="input-group-text form-control form-control-sm" @click="search"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div> -->

                        <div class="alert alert-danger alert-dismissible" v-if="!project_id">
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                            ยังไม่ได้เลือกโครงการ
                        </div>

                        <div v-if="project_id">
                            <div class="card-body table-responsive  p-0" id="select_cost">
                                <table class="table table-hover table-sm">
                                    <tbody>
                                        <tr v-for="(item, item_index) in group_cost" @click="select_group_cost(item_index)" data-dismiss="modal" style="cursor: pointer;">
                                            <td>@{{item.cost_plan.count_cost}} : @{{item.cost_plan_name}}</td>
                                            <td>@{{item.cost_plan_list.code}} @{{item.costPlanLists}}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-10">
    </div>
    <div class="col-12 col-md-2">
        <div class="card-body">
            <a class="btn btn-app bg-success" style="width: 100%; cursor: grab;" @click="submit()">
                <i class="fas fa-save"></i> บันทึกข้อมูล
            </a>
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
                po_lists: {!!$po_lists!!},
                group_cost: '',
                project_id: '',
                g_po_lists_index: '',
                g_allocate_index: '',
                po: {!!$po!!},
                search_value: '',
            }
        },
        mounted() {
            for (var i = 0; i < this.po_lists.length; i++) {
                this.po_lists[i].allocates.push({
                    price: this.po_lists[i].price,
                    project_cost_plan_list_id: '',
                    project_cost_plan_list_name: '',
                    project_id: this.po_lists[i].project.id,
                });
            }

            this.sum_price();
        },
        methods: {
            add(po_lists_index) {
                this.po_lists[po_lists_index].allocates.push({
                    price: 0,
                    project_cost_plan_list_id: '',
                    project_cost_plan_list_name: '',
                    project_id: this.po_lists[po_lists_index].project.id,
                });
            },
            remove(po_lists_index, allocate_index) {
                this.po_lists[po_lists_index].allocates.splice(allocate_index, 1);

                this.sum_price();
            },
            number(num) {
                return numeral(num).format('0,0.00');
            },
            get_group_cost: async function(po_lists_index, allocate_index) {
                this.project_id = this.po_lists[po_lists_index].allocates[allocate_index].project_id;
                this.g_po_lists_index = po_lists_index;
                this.g_allocate_index = allocate_index;

                var res = await axios.post('/get/group-cost', {
                    pro_id: this.po_lists[po_lists_index].allocates[allocate_index].project_id
                });

                console.log(res.data);
                this.group_cost = res.data;
            },
            search: async function() {
                var res = await axios.post('/get/group-cost/search', {
                    pro_id: this.project_id,
                    value: this.search_value,
                });

                console.log(res.data);
                this.group_cost = res.data;
            },
            select_group_cost(item_index) {
                this.po_lists[this.g_po_lists_index].allocates[this.g_allocate_index].project_cost_plan_list_id = this.group_cost[item_index].id;
                this.po_lists[this.g_po_lists_index].allocates[this.g_allocate_index].project_cost_plan_list_name = this.group_cost[item_index].cost_plan_name + '/' + this.group_cost[item_index].costPlanLists;
            },
            sum_price() {
                for (var i = 0; i < this.po_lists.length; i++) {
                    this.po_lists[i].sum_price = 0;
                    for (var l = 0; l < this.po_lists[i].allocates.length; l++) {
                        this.po_lists[i].sum_price = parseFloat(this.po_lists[i].sum_price) + parseFloat(this.po_lists[i].allocates[l].price);
                    }
                }
            },
            submit: async function() {
                if(confirm('ยืนยันการจัด สรรต้นทุน ?')){
                    for (var i = 0; i < this.po_lists.length; i++) {
                        this.po_lists[i].sum_price = 0;
                        for (var l = 0; l < this.po_lists[i].allocates.length; l++) {
                            if (this.po_lists[i].allocates[l].project_cost_plan_list_name == '') {
                                alert('มีบางรายการยังไม่เลือก กลุ่มต้นทุน');
                                return;
                            }
                            this.po_lists[i].sum_price = parseFloat(this.po_lists[i].sum_price) + parseFloat(this.po_lists[i].allocates[l].price);
                        }

                        if (this.po_lists[i].sum_price != this.po_lists[i].price) {
                            alert('จัดสรรไม่ครบ หรือไม่ก็มีการจัดสรรเกิน');
                            return;
                        }
                    }

                    var res = await axios.post('/new-allocate', {
                        po_lists: this.po_lists,
                    });
                    
                    if(res.data == 'fail'){
                        location.href = '/po/show/' + this.po.id;
                    }else{
                        location.href = '/po/show/' + this.po.id;
                    }
                }
            }
        },
    });
</script>
@endsection