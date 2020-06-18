<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //
    protected $fillable = [
        'user_id', 'quotation_id', 'origin', 'destination', 'transportation_type', 'type', 
        'ready_to_load_date', 'value_of_goods', 'isStockable', 'isDGR', 'calculate_by', 
        'total_weight', 'quantity', 'remarks', 'isClearanceReq', 'no_of_containers', 
        'container_size', 'proposals_received', 'pickup_address', 'destination_address',
        'incoterms', 'pallets'
        ];
        
    protected $dates = [
        'ready_to_load_date',
    ];
    
    protected $casts = [
        'pallets' => 'array'
    ];
}
