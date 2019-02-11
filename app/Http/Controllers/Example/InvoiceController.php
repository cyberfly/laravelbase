<?php

namespace App\Http\Controllers\Example;


use App\Http\Requests\Example\StoreInvoiceRequest;
use App\Http\Requests\Example\UpdateInvoiceRequest;
use App\Http\Resources\Example\InvoiceResource;
use App\Models\Example\Invoice;
use App\Models\Example\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    protected $invoice;
    protected $invoiceItem;

    public function __construct(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        $this->invoice = $invoice;
        $this->invoiceItem = $invoiceItem;
    }

    public function create()
    {
        return view('examples.invoices.create');
    }

    /**
     * @param StoreInvoiceRequest $request
     * @return InvoiceResource
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = $this->invoice->create($request->input('invoice'));

        // set invoice items

        $this->syncInvoiceItems($invoice, $request);

        return new InvoiceResource($invoice->load('invoiceItems'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('examples.invoices.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->invoice
            ->with('invoiceItems')
            ->findOrFail($id);

        return view('examples.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInvoiceRequest|Request $request
     * @param  int $id
     * @return InvoiceResource
     */
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $invoice = $this->invoice
            ->with('invoiceItems')
            ->findOrFail($id);

        $invoice->update($request->input('invoice'));

        // set invoice items

        $this->syncInvoiceItems($invoice, $request);

        // sync deleted items

        $this->syncDeletedItems($invoice, $request);

        $invoice->refresh();

        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Sync invoice items based on request
     * @param $invoice
     * @param $request
     */
    private function syncInvoiceItems($invoice, $request)
    {
        if ($request->filled('invoice_items')) {

            $invoice_items = $request->invoice_items;

            foreach ($invoice_items as $item) {

                $item_id = $item['id'];

                if (!empty($item_id)) {
                    // update existing invoice item

                    $invoice_item = $this->invoiceItem->find($item_id);

                    if ($invoice_item) {

                        $item_data = collect($item)->except('id', 'invoice_id')->all();

                        $invoice_item->update($item_data);
                    }

                }
                else {
                    // new invoice item

                    $item_data = ['invoice_id' => $invoice->id] + collect($item)->except('id')->all();

                    $this->invoiceItem->create($item_data);
                }
            }
        }
    }

    private function syncDeletedItems($invoice, $request)
    {
        if ($request->filled('deleted_items')) {

            // delete invoice items

            if ($request->filled('deleted_items.invoice_item_ids')) {

                $deleted_invoice_item_ids = $request->input('deleted_items.invoice_item_ids');

                foreach ($deleted_invoice_item_ids as $item_id) {

                    $invoice_item = $this->invoiceItem->find($item_id);

                    if ($invoice_item) {
                        $invoice_item->delete();
                    }

                }

            }

        }
    }
}
