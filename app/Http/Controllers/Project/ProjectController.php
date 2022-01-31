<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Customer;
use App\ProjectType;
use App\Branch;
use App\UserToBranch;
use DB;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('main_user', 'customer')->where('branch_id',auth()->user()->branch_id)->orderBy('created_at', 'desc')->get();
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        $branch = auth()->user()->branch;
        $users = UserToBranch::where('branch_id',$branch->id)->get();
        $customers = Customer::whereIn('status',[ 'customer','customer , supplier'])->where('branch_id', $branch->id)->get();
        $project_types = ProjectType::all();

        $year = Carbon::today()->format('y');
        $project_count = Project::where('branch_id', $branch->id)->where('year', $year)->count() + 1;
        $code = $branch->code . '-' . $year . sprintf("%'02d", $project_count);
        if(Project::where('code',$code)->exists()){
            $code = $branch->code . '-' . $year . sprintf("%'03d", $project_count);
        }
        return view('project.create', compact('customers', 'project_types', 'users','code'));
    }

    public function store()
    {

        if(Project::where('code',request('code'))->exists()){
            alert()->error('ผิดพลาด', 'มีระหัสโครงการนี้แล้ว');
            return back();
        }
        $id = DB::transaction(function () {

            if(request('new_customer_id')){
                $customer_id = request('new_customer_id');
             }else{
                 if(!request('customer_name')){
                    return 0;
                 }
                $customer = Customer::create([
                 'name'=> request('customer_name'),
                 'tel'=> request('customer_tel'),
                 'fax'=> request('customer_fax'),
                 'address'=> request('customer_address'),
                 'note'=> request('customer_note'),
                 'status'=> request('customer_status'),
                 'txt_tin'=> request('customer_txt_tin'),
                 'email'=> request('customer_email'),
                 'branch_id'=> auth()->user()->branch_id,
            ]);
                $customer_id = $customer->id;
             }

            $year = Carbon::createFromFormat('Y-m-d', request('start_date'))->format('y');
            $project_cost = str_replace(',' , '' , request('project_cost_new') );

            $request = request()->all();
            $request['user_id'] = auth()->user()->id;
            $request['year'] = $year;
            $request['project_cost'] = $project_cost;
            $request['customer_id'] = $customer_id;
            $request['branch_id'] = auth()->user()->branch_id;
            $project = Project::create($request);
            $project->logs()->create([
                'type' => 'project',
                'type_id' => $project->id,
                'user_id' => auth()->user()->id,
                'note' => 'สร้าง'
            ]);
            return $project->id;
        });
        if($id == 0){
            alert()->error('ผิดพลาด', 'ไม่ได้เพิ่มลูกค้า');
            return back();
        }
        return redirect('/project/show/' . $id);
    }
    
    public function show(Project $project)
    {
        if($project->branch_id != auth()->user()->branch_id){
            alert()->error('ผิดพลาด', 'ไม่มีสิทธิ์เข้าถึง');
            return redirect('/project');
        }

        $users = User::all();
        $customers = Customer::where('status', 'customer')->where('branch_id',auth()->user()->branch_id)->get();
        $branchs = Branch::where('status', 1)->get();
        $project_types = ProjectType::all();
        return view('project.show', compact('customers', 'project_types', 'users', 'project', 'branchs'));
    }

    public function update(Project $project)
    {
        DB::transaction(function () use($project){
            $request = request()->all();
            $project->update($request);
            $project->logs()->create([
                'type' => 'project',
                'type_id' => $project->id,
                'user_id' => auth()->user()->id,
                'note' => 'แก้ไข'
            ]);
        });

        return redirect('/project/show/' . $project->id);
    }
    
}
