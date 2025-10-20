<?php
// FIX 1: Change to the correct manual autoloader path 
// assuming you placed the packaged dompdf folder in your 'teset' directory.
require __DIR__ . '/dompdf/autoload.inc.php'; 

// Include the fixed database connection file
include("connection.php");

// Use the Dompdf namespace
use Dompdf\Dompdf;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $invoice = $conn->query("SELECT * FROM invoices WHERE id=$id")->fetch_assoc();
    $items   = $conn->query("SELECT * FROM invoice_items WHERE invoice_id=$id");

    if (!$invoice) { die("Invoice not found."); }

    $invoice_number = "INV-" . str_pad($invoice['id'], 6, "0", STR_PAD_LEFT);

    // Watermark
    $watermark = strtoupper($invoice['status']) == 'PAID' ? "PAID" : "UNPAID";

    $html = "
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; position: relative; }
      .header { border-bottom: 3px solid #2E86C1; padding-bottom: 10px; margin-bottom: 20px; }
      .company { font-size: 14px; font-weight: bold; }
      .title { background: #2E86C1; color: #fff; padding: 8px; text-align: center; font-size: 18px; margin-bottom: 20px; }
      .invoice-info { width: 100%; margin-bottom: 20px; }
      .invoice-info td { padding: 5px; vertical-align: top; }
      table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
      table.items th { background: #f2f2f2; border: 1px solid #ddd; padding: 8px; }
      table.items td { border: 1px solid #ddd; padding: 8px; }
      .right { text-align: right; }
      .totals { width: 40%; float: right; margin-top: 15px; border: 1px solid #ddd; }
      .totals td { padding: 6px; border: 1px solid #ddd; }
      .footer { margin-top: 40px; font-size: 11px; }
      .status { font-weight: bold; text-transform: uppercase; color: red; }
      .watermark {
        position: fixed;
        display: none;
        top: 40%;
        left: 15%;
        width: 70%;
        text-align: center;
        font-size: 80px;
        color: rgba(200,200,200,0.25);
        transform: rotate(-30deg);
        z-index: -1000;
      }
      .notes, .terms {
        margin-top: 30px;
        padding: 10px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        font-size: 11px;
      }
      .notes h4, .terms h4 { margin: 0 0 8px 0; font-size: 12px; }
    </style>

    <div class='watermark'>{$watermark}</div>

    <div class='header'>
      <table width='100%'>
        <tr>
          <td>
            <img src='images/logo.PNG' height='60'>
          </td>
          <td class='right'>
            <div class='company'>Peaksphere Ken Limited</div>
            <div>Nairobi, Kenya</div>
            <div>+254 712345678</div>
            <div>KRA PIN: PXXXXXXXXX</div>
          </td>
        </tr>
      </table>
    </div>

    <div class='title'>INVOICE</div>

    <table class='invoice-info'>
      <tr>
        <td>
          <strong>Bill To:</strong><br>
          {$invoice['client_name']}<br>
          {$invoice['client_email']}
        </td>
        <td class='right'>
          <strong>Invoice #:</strong> {$invoice_number}<br>
          <strong>Date:</strong> {$invoice['created_at']}<br>
          <strong>Due Date:</strong> {$invoice['due_date']}<br>
          <strong>Status:</strong> <span class='status'>{$invoice['status']}</span>
        </td>
      </tr>
    </table>

    <table class='items'>
      <thead>
        <tr>
          <th>#</th>
          <th>Description</th>
          <th>Qty</th>
          <th>Rate (KES)</th>
          <th>Amount (KES)</th>
        </tr>
      </thead>
      <tbody>";
      
      $count = 1;
      $subtotal = 0;
      while ($item = $items->fetch_assoc()) {
          $subtotal += $item['amount'];
          $html .= "
          <tr>
            <td>{$count}</td>
            <td>{$item['description']}</td>
            <td>{$item['quantity']}</td>
            <td>".number_format($item['price'],2)."</td>
            <td>".number_format($item['amount'],2)."</td>
          </tr>";
          $count++;
      }

      $vat = $subtotal * 0.16;
      $total = $subtotal + $vat;

      $html .= "
      </tbody>
    </table>

    <table class='totals'>
      <tr><td class='right'>Subtotal</td><td class='right'>".number_format($subtotal,2)."</td></tr>
      <tr><td class='right'>VAT (16%)</td><td class='right'>".number_format($vat,2)."</td></tr>
      <tr><td class='right'><strong>Total</strong></td><td class='right'><strong>".number_format($total,2)."</strong></td></tr>
    </table>

    <div style='clear:both;'></div>

    <div class='notes'>
      <h4>Notes</h4>
      <p>This invoice reflects the basic pilot fee only, charged exclusive of any commissions. Commissions will be calculated and invoiced
separately upon pilot closure.</p>
    </div>

    <div class='terms'>
      <h4>Terms & Conditions</h4>
      <ul>
        <li> Payment Due on Demand
.</li>
        <li> Payment shall be made in full in Ksh via acceptable methods, e.g., bank transfer, credit card, M-Pesa Paybill, to the account or
address specified below.</li>
        
      </ul>
    </div>

   <div class='container'>
    <div class='footer'>
      <h4>Payment Instructions</h4>
      Bank: Stanbic Bank Kenya Limited<br>
      Acc Name: Peaksphere Ken Limited<br>
      Acc Number: 0100007197157<br>
      Branch: Nairobi<br>
      Mpesa Paybill: 4030081<br>
      Account: Use Invoice Number<br><br>

      <p><strong>Authorized Signature</strong></p>
       <div>
         <img src='images/logo.PNG' height='60'>
    </div>
    </div>
   </div>
    ";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("invoice_{$invoice_number}.pdf");
}
?>