<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['project_id', 'invoice_id', 'type', 'description', 'unit', 'date', 'price', 'percent', 'discount', 'total', 'note', 'status','receive_price','vat','price_before_vat','sum_price_vat'];

    function project(){
        return $this->belongsTo(\App\Project::class, 'project_id');
    }

    function invoice(){
        return $this->belongsTo(\App\ProjectInvoice::class, 'invoice_id');
    }
}
