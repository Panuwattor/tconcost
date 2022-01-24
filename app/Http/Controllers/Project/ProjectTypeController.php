<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $project_types = ProjectType::all();
        return view('project.project-type-index', compact('project_types'));
    }

    public function store()
    {
        DB::transaction(function(){
            ProjectType::create(request()->all());

            alert()->success('สำเร็จ', 'เพิ่มเรียบร้อย');
        });

        return back();
    }

    public function update(ProjectType $project_type)
    {
        DB::transaction(function() use ($project_type){
            $project_type->update(request()->all());

            alert()->success('สำเร็จ', 'แก้ไขเรียบร้อย');
        });

        return back();
    }
}
