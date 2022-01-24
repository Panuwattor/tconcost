<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Customer;
use App\ProjectType;
use App\Branch;
use DB;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('main_user', 'customer')->orderBy('created_at', 'desc')->get();
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        $customers = Customer::whereIn('status',[ 'customer','customer , supplier'])->get();
        $projects = Project::with('main_user', 'customer')->orderBy('created_at', 'desc')->get();
        $branchs = Branch::where('status', 1)->get();
        $project_types = ProjectType::all();

        $branch = Branch::find(1);
        $year = Carbon::today()->format('y');
        $project_count = Project::where('branch_id', $branch->id)->where('year', $year)->count() + 1;
        $code = $branch->code . '-' . $year . sprintf("%'02d", $project_count);
        if(Project::where('code',$code)->exists()){
            $code = $branch->code . '-' . $year . sprintf("%'03d", $project_count);
        }
        return view('project.create', compact('customers', 'project_types', 'users', 'projects', 'branchs','code'));
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
                $customer = Customer::create([
                 'name'=> request('customer_name'),
                 'tel'=> request('customer_tel'),
                 'fax'=> request('customer_fax'),
                 'address'=> request('customer_address'),
                 'note'=> request('customer_note'),
                 'status'=> request('customer_status'),
                 'txt_tin'=> request('customer_txt_tin'),
                 'email'=> request('customer_email')
                ]);
                $customer_id = $customer->id;
             }

            $year = Carbon::createFromFormat('Y-m-d', request('start_date'))->format('y');
            $project_cost = str_replace(',' , '' , request('project_cost_new') );

            $request = request()->all();
            $request['user_id'] = auth()->user()->id;
            $request['year'] = $year;
            $request['project_cost'] = $project_cost;
            $request['supplier_id'] = $customer_id;

            $project = Project::create($request);
            $project->logs()->create([
                'type' => 'project',
                'type_id' => $project->id,
                'user_id' => auth()->user()->id,
                'note' => 'สร้าง'
            ]);
            return $project->id;
        });

        return redirect('/project/show/' . $id);
    }
    
    public function show(Project $project)
    {
        $users = User::all();
        $customers = Customer::where('status', 'customer')->get();
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
