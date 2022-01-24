<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\Income;
use DB;

class IncomeController extends Controller
{
    public function index(Project $project)
    {
        $as = [];
        $bs = [];
        $ts = [];
        foreach($project->incomes()->orderBy('date')->get() as $income){
            $as[] = $income->date;
            $bs[] = $income->total;
            if( $income->status == 1){
                $ts[] = array_sum($bs);
            }
        }

        $aas = collect($as);
        $abs = collect($bs);
        $ats = collect($ts);

        return view('project.income.index', compact('project','aas','abs','ats'));
    }

    public function create(Project $project)
    {
        return view('project.income.create', compact('project'));
    }
    
    public function store(Project $project)
    {
      DB::transaction(function () use($project){
                foreach(request('type') as $key=>$type){
                    $project->incomes()->create([
                        'invoice_id'=> Null,
                        'type'=> $type,
                        'description'=> request('description')[$key],
                        'unit'=> request('unit')[$key],
                        'date'=> request('date')[$key],
                        'price'=> request('price')[$key],
                        'percent'=> request('percent')[$key],
                        'discount'=> request('discount')[$key],
                        'total'=> request('total')[$key],
                        'note'=> request('note')[$key],
                        'status'=> 0
                ]);
                }

               $pro = $project->cost_plans()->exists();
               if($pro){
                $project->update([
                    'status'=>1
                ]);
               }
            });
        return redirect('/project/add-income/new/'.$project->id);
    }

    public function edit(Project $project)
    {
        return view('project.income.edit', compact('project'));
    }

    public function update(Project $project)
    {

        $res = DB::transaction(function () use($project){
            foreach (request('ids') as $key => $in_id) {
                $income = Income::find($in_id);
                if ($income) {
                    if ($income->status == 0) {
                        $income->update([
                            'type'=> request('type')[$key],
                            'description'=> request('description')[$key],
                            'unit'=> request('unit')[$key],
                            'date'=> request('date')[$key],
                            'price'=> request('price')[$key],
                            'percent'=> request('percent')[$key],
                            'discount'=> request('discount')[$key],
                            'total'=> request('total')[$key],
                            'note'=> request('note')[$key],
                        ]);
                    }
                } else {
                    $project->incomes()->create([
                        'invoice_id'=> Null,
                        'type'=> request('type')[$key],
                        'description'=> request('description')[$key],
                        'unit'=> request('unit')[$key],
                        'date'=> request('date')[$key],
                        'price'=> request('price')[$key],
                        'percent'=> request('percent')[$key],
                        'discount'=> request('discount')[$key],
                        'total'=> request('total')[$key],
                        'note'=> request('note')[$key],
                        'status'=> 0
                ]);
                }
            }

        });
        return redirect('/project/add-income/new/'.$project->id);

    }

    public function delete($income)
    {
        $interim_list = Income::find($income);

        if($interim_list->status == 0){
            $interim_list->delete();
        }else{
            return 'error';
        }

        return 'success';
    }


}
