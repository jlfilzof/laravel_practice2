<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InvoiceResource;
use App\Filters\V1\InvoicesFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request); // ['column', 'operator','value']

        // if no queryItem, return data as normal
        if (count($queryItems) == 0) {
            return InvoiceResource::collection(Invoice::paginate(10));
        }
        // else, filter data
        return Invoice::where($queryItems)->paginate(10);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        
    }

    public function bulkStore(BulkStoreInvoiceRequest $request) {
        $bulk = collect($request->all()->map(function($arr, $key) {
           return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        }));

        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new InvoicesFilter($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
