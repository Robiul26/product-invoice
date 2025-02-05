<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'product_name' => 'required|array',
            'product_description' => 'required|array',
            'unit_price' => 'required|array',
            'quantity' => 'required|array',
            'total_price' => 'required|array',
        ]);
        $invoiceNumber = $request->input('invoice_number') ?? $this->generateInvoiceNumber();


        $invoice = new Invoice();
        $invoice->invoice_number = $invoiceNumber;
        $invoice->total_amount = $request->total_amount;
        if ($invoice->save()) {

            // Prepare the details for invoice_details table
            $productNames = $request->product_name;
            $productDescriptions = $request->product_description;
            $unitPrices = $request->unit_price;
            $quantities = $request->quantity;
            $totalPrices = $request->total_price;

            for ($i = 0; $i < count($productNames); $i++) {

                $currentDescriptions = $productDescriptions[$i];

                // Encode descriptions as JSON
                $encodedDescriptions = json_encode($currentDescriptions);

                // Create invoice detail for each product
                $detail = new InvoiceDetail();
                $detail->invoice_id = $invoice->id;
                $detail->product_name = $productNames[$i];
                $detail->product_description = $encodedDescriptions; // Save the JSON encoded descriptions
                $detail->unit_price = $unitPrices[$i];
                $detail->quantity = $quantities[$i];
                $detail->total_price = $totalPrices[$i];
                $detail->save();
            }
        }
        return redirect()->route('product.index')->with('message', 'Invoice was created');
    }

    private function generateInvoiceNumber()
    {
        do {
            $invoiceNumber = random_int(10000000, 99999999); // 8-digit random number
        } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }
}
