<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationList extends Model
{
    protected $fillable = ['quotation_id','invoice_id','type','description','unit','date','price',
                            'percent','discount','total','note','status','receive_price',
                            'vat','price_before_vat','sum_price_vat',
                    ];

    function quotation(){
        return $this->belongsTo(\App\Quotation::class, 'quotation_id');
    }
}
