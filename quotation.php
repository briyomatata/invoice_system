<?php
require __DIR__ . '/dompdf/autoload.inc.php';
include("connection.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Load logo
$logoPath = "/home/peaksphereken/public_html/images/logo.png"; // adjust if needed
if (file_exists($logoPath)) {
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoSrc  = 'data:image/png;base64,' . $logoData;
} else {
    $logoSrc = ''; // fallback if not found
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $quotation = $conn->query("SELECT * FROM quotations WHERE id=$id")->fetch_assoc();
    $items     = $conn->query("SELECT * FROM quotation_items WHERE quotation_id=$id");

    if (!$quotation) { die("Quotation not found."); }

    $quotation_number = "QTN-" . str_pad($quotation['id'], 6, "0", STR_PAD_LEFT);

    $html = "
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
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
      .notes, .terms { margin-top: 30px; padding: 10px; border: 1px solid #ddd; background: #f9f9f9; font-size: 11px; }
      .notes h4, .terms h4 { margin: 0 0 8px 0; font-size: 12px; }
    </style>

    <div class='header'>
      <table width='100%'>
        <tr>
          <td>
            <img src='{$logoSrc}' height='60'>
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

    <div class='title'>QUOTATION</div>

    <table class='invoice-info'>
      <tr>
        <td>
          <strong>To:</strong><br>
          {$quotation['client_name']}<br>
          {$quotation['client_email']}
        </td>
        <td class='right'>
          <strong>Quotation #:</strong> {$quotation_number}<br>
          <strong>Date:</strong> {$quotation['created_at']}<br>
          <strong>Valid Until:</strong> {$quotation['valid_until']}<br>
          <strong>Status:</strong> {$quotation['status']}
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
      <p>This quotation is valid until the date specified. Prices are exclusive of VAT unless otherwise stated.</p>
    </div>

    <div class='terms'>
      <h4>Terms & Conditions</h4>
      <ul>
        <li>Payment is due as per agreement upon acceptance of this quotation.</li>
        <li>Work will commence once an official confirmation is received.</li>
        <li>Any additional work not listed will be quoted separately.</li>
      </ul>
    </div>

    <div class='footer'>
      <p><strong>Thank you for considering Peaksphere Ken Limited.</strong></p>
    </div>
    ";

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("quotation_{$quotation_number}.pdf");
}
?>
