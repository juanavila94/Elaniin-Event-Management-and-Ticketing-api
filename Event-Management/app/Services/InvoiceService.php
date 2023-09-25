<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class InvoiceService
{
     public function createInvoice($invoiceData)
     {
          $invoice = [
               'id' => $invoiceData['id'],
               'name' => $invoiceData['name'],
               'email' => $invoiceData['email'],
               'date_of_purchase' => $invoiceData['date_of_purchase'],
               'total_amount' => $invoiceData['total_amount'],
               'tickets' => $invoiceData['tickets'],
           ];
   
           $jsonContent = json_encode($invoice, JSON_PRETTY_PRINT);
   
           Mail::raw($jsonContent, function ($message) use ($invoice) {
               $message->to($invoice['email'], $invoice['name'])
                   ->subject('Invoice for Your Order')
                   ->from('juan.avila@live.com.ar', 'Your Name');
           });
     }
}

?>