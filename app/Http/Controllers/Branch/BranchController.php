<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Branch;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index()
    {
        $branchs = Branch::all();

        return view('branchs.index', compact('branchs'));
    }
    
    public function store()
    {

        $branch = Branch::create(array_merge(request()->all()));

        if (request('logo')) {
            $logo = Storage::disk('spaces')->putFile('tconcost/branch/'.$branch->id, request('logo'), 'public');
            $branch->update([
                'logo' => $logo
            ]);
        } 

        return back();
    }

    public function update(Branch $branch)
    {
        if (request('logo')) {
            Storage::disk('spaces')->delete($branch->logo);
            $logo = Storage::disk('spaces')->putFile('tconcost/branch/'.$branch->id, request('logo'), 'public');
        } else {
            $logo = $branch->logo;
        }
        $branch->update(array_merge(request()->all(), ['logo' => $logo]));

        return back();
    }
}
