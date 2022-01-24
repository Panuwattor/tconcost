<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectLog extends Model
{
    protected $fillable = ['project_id','type','type_id','user_id','note'];

    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    function getLinkAttribute(){
        if($this->type == "project"){
            return '/project/show/'.$this->type_id;
        }else if($this->type == "PO"){
            return '/po/show/'.$this->type_id;
        }else if($this->type == "IS"){
            return '/inspection/show/'.$this->type_id;
        }else if($this->type == "AR"){
            return '/project/invoice/show/'.$this->type_id;
        }else if($this->type == "REC" || $this->type == "TIV-" ){
            return '/receipt-ar/show/'.$this->type_id;
        }else{
            return '#';
        }

    }
}
