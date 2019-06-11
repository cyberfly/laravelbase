<?php

namespace App\Http\Controllers\Example;

use App\Http\Requests\Example\StoreInvoiceRequest;
use App\Http\Requests\Example\UpdateInvoiceRequest;
use App\Http\Resources\Example\InvoiceResource;
use App\Models\Common\PublishStatus;
use App\Models\Example\Invoice;
use App\Models\Example\InvoiceItem;
use App\Models\Example\InvoiceStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VueInvoiceController extends Controller
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
        $invoice = $this->getInvoice();

        return view('examples.vueinvoices.create', compact('invoice'));
    }

    /**
     * @param StoreInvoiceRequest $request
     * @return InvoiceResource
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = $this->invoice->create($request->get('invoice'));

        // set invoice items

        $this->syncInvoiceItems($invoice, $request);

        // set status

        $this->setInvoiceStatus($invoice, $request);

        // do something if form is SUBMITTED instead of SAVE

        $this->doSomethingIfSubmit($invoice, $request);

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
        return view('examples.vueinvoices.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->getInvoice($id);

//        return $invoice;

        return view('examples.vueinvoices.edit', compact('invoice'));
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

        $invoice->update($request->get('invoice'));

        // set invoice items

        $this->syncInvoiceItems($invoice, $request);

        // sync deleted items

        $this->syncDeletedItems($invoice, $request);

        // set status

        $this->setInvoiceStatus($invoice, $request);

        // do something if form is SUBMITTED instead of SAVE

        $this->doSomethingIfSubmit($invoice, $request);

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

    private function setInvoiceStatus($model, $request)
    {
        // get latest status

        $current_status = $model->status;

        if ($request->submitted === true) {

            if ($current_status !== InvoiceStatus::SUBMITTED) {

                // published invoice

                $model->publish();

                // set status as SUBMITTED

                $model->setStatus(InvoiceStatus::SUBMITTED);

            }

        } else {

            if ($current_status !== InvoiceStatus::DRAFT) {

                // set status as DRAFT

                $model->setStatus(InvoiceStatus::DRAFT);
            }
        }
    }

    /**
     * Extra business logic if user click SUBMIT instead of SAVE
     * @param $model
     * @param $request
     */
    private function doSomethingIfSubmit($model, $request)
    {
        if ($request->submitted === true) {

        }
    }

    /**
     * Get Invoice data. If new invoice, we return a default Invoice Object
     * @param null $id
     * @return mixed
     */
    private function getInvoice($id = null)
    {
        if (!$id) {

            $default_data = [
                'customer_id' => null,
                'invoice_number' => null,
                'po_number' => null,
                'invoice_date' => null,
                'payment_due' => null,
                'publish_status' => PublishStatus::DRAFT,
                'published_at' => null,
            ];

            $invoice = $this->invoice
                ->fill($default_data)
                ->load('invoiceItems');

        }
        else {

            $invoice = $this->invoice
                ->with('invoiceItems')
                ->findOrFail($id);

        }

        return $invoice;
    }

    /**
     * Sync invoice items based on request
     * @param $invoice
     * @param $request
     */
    private function syncInvoiceItems($invoice, $request)
    {
        if ($request->filled('invoice_items')) {

            $invoice_items = $request->get('invoice_items');

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

            $deleted_invoice_item_ids = $request->get('deleted_items.invoice_item_ids');

            if (!empty($deleted_invoice_item_ids)) {

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
