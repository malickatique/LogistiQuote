<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quotation;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quotations'] = Quotation::where('user_id', Auth::user()->id)->get();
        $data['page_name'] = 'view_quotations';
        $data['page_title'] = 'View quotations | LogistiQuote';
        return view('panels.quotation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_name'] = 'create_quotation';
        $data['page_title'] = 'Create quotation | LogistiQuote';
        return view('panels.quotation.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origin_city' => ['required', 'string', 'min:3', 'max:255'],
            'origin_state' => ['required', 'string', 'min:3', 'max:255'],
            'origin_country' => ['required', 'string', 'min:3', 'max:255'],
            'origin_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'destination_city' => ['required', 'string', 'min:3', 'max:255'],
            'destination_state' => ['required', 'string', 'min:3', 'max:255'],
            'destination_country' => ['required', 'string', 'min:3', 'max:255'],
            'destination_zip' => ['required', 'numeric', 'min:3', 'max:9999999'],
            'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255'],
            'date' => ['required', 'string', 'min:3', 'max:255'],
            'value_of_goods' => ['required', 'numeric', 'min:3', 'max:255'],
            'calculate_by' => ['required', 'string', 'min:3', 'max:255'],
            'remarks' => ['required', 'string', 'min:3', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $quotation = new Quotation;
        $quotation->user_id = Auth::user()->id;
        $quotation->quotation_id = mt_rand();
        $quotation->origin = $request->origin_city.', '.$request->origin_state.', '.$request->origin_country.'. '.$request->origin_zip;
        $quotation->destination = $request->destination_city.', '.$request->destination_state.', '.$request->destination_country.'. '.$request->destination_zip;
        $quotation->transportation_type = $request->transportation_type;
        $quotation->type = $request->type;
        $quotation->ready_to_load_date = $request->ready_to_load_date;
        
        $quotation->value_of_goods = $request->value_of_goods;
        $quotation->isStockable = $request->isStockable ? $request->isStockable : 'No';
        $quotation->isDGR = $request->isDGR ? $request->isDGR : 'No';
        $quotation->calculate_by = $request->calculate_by;
        $quotation->remarks = $request->remarks;
        $quotation->isClearanceReq = $request->isClearanceReq ? $request->isClearanceReq : 'No';
        
        $quotation->total_weight = $request->total_weight;

        if($request->transportation_type == 'sea' && $request->type == 'fcl')
        {
            $quotation->container_size = $request->container_size;
            $quotation->no_of_containers = $request->no_of_containers;
        }
        if($request->calculate_by == 'units')
        {
            $quotation->quantity = $request->quantity_units;
        }
        else
        {
            $quotation->quantity = $request->quantity;
        }
        $quotation->save();

        return redirect(route('user.quotations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['quotation'] = Quotation::where('id', $id)->first();
        $data['page_name'] = 'view_quotation';
        $data['page_title'] = 'View quotation | LogistiQuote';
        return view('panels.quotation.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['quotation'] = Quotation::where('id', $id)->first();
        $data['page_name'] = 'edit_quotation';
        $data['page_title'] = 'Edit quotation | LogistiQuote';
        return view('panels.quotation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'origin' => ['required', 'string', 'min:3', 'max:255'],
            'destination' => ['required', 'string', 'min:3', 'max:255'],
            'transportation_type' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255'],
            'date' => ['required', 'string', 'min:3', 'max:255'],
            'value_of_goods' => ['required', 'numeric', 'min:3', 'max:255'],
            'calculate_by' => ['required', 'string', 'min:3', 'max:255'],
            'remarks' => ['required', 'string', 'min:3', 'max:255'],
            'total_weight' => ['required', 'numeric', 'min:3', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $quotation = Quotation::findorFail($id);
        $quotation->origin = $request->origin;
        $quotation->destination = $request->destination;
        $quotation->transportation_type = $request->transportation_type;
        $quotation->type = $request->type;
        $quotation->ready_to_load_date = $request->ready_to_load_date;
        
        $quotation->value_of_goods = $request->value_of_goods;
        $quotation->isStockable = $request->isStockable ? $request->isStockable : 'No';
        $quotation->isDGR = $request->isDGR ? $request->isDGR : 'No';
        $quotation->calculate_by = $request->calculate_by;
        $quotation->remarks = $request->remarks;
        $quotation->isClearanceReq = $request->isClearanceReq ? $request->isClearanceReq : 'No';
        
        $quotation->total_weight = $request->total_weight;

        if($request->transportation_type == 'sea' && $request->type == 'fcl')
        {
            $quotation->container_size = $request->container_size;
            $quotation->no_of_containers = $request->no_of_containers;
        }
        if($request->calculate_by == 'units')
        {
            $quotation->quantity = $request->quantity_units;
        }
        else
        {
            $quotation->quantity = $request->quantity;
        }
        $quotation->save();
        return redirect(route('user.quotations'));
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quotation::destroy($id);
        return redirect(route('user.quotations'));
    }
}