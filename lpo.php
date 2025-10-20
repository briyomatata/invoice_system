<?php
require __DIR__ . '/dompdf/autoload.inc.php';
include("connection.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Load logo
$logoPath = "/home/peaksphereken/public_html/images/logo.png";
$logoSrc = file_exists($logoPath)
    ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
    : '';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $lpo   = $conn->query("SELECT * FROM lpos WHERE id=$id")->fetch_assoc();
    $items = $conn->query("SELECT * FROM lpo_items WHERE lpo_id=$id");

    if (!$lpo) { die("LPO not found."); }

    $lpo_number = "LPO-" . str_pad($lpo['id'], 4, "0", STR_PAD_LEFT);

    // Calculate totals
    $subtotal = 0;
    while ($item = $items->fetch_assoc()) {
        $subtotal += $item['amount'];
        $all_items[] = $item;
    }
    $vat = $subtotal * 0.16;
    $total = $subtotal + $vat;
    $paid = 0; // you can add payments table later
    $balance = $total - $paid;

    $html = "
    <style>
      body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
      .header {
        background: #2E3094; color: #fff; padding: 15px;
      }
      .header td { color: #fff; }
      .company { font-size: 16px; font-weight: bold; }
      .title { font-size: 22px; font-weight: bold; text-align: right; color: #B7F000; }
      .supplier, .info { margin-top: 20px; }
      table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
      table.items th { background: #C6E57A; padding: 8px; border: 1px solid #ccc; }
      table.items td { padding: 8px; border: 1px solid #ccc; }
      .right { text-align: right; }
      .balance-box {
        margin-top: 15px; padding: 8px; background: #2E3094; color: #fff;
        font-size: 16px; text-align: center; border-radius: 5px;
      }
      .balance-box span { background: #C6E57A; padding: 4px 12px; border-radius: 5px; color: #333; }
      .footer { margin-top: 50px; text-align: center; font-size: 12px; }
    </style>

    <!-- HEADER -->
    <table width='100%' class='header'>
      <tr>
        <td width='70%'>
          <img src='{$logoSrc}' height='50'><br>
          <div class='company'>Peaksphere Ken Limited</div>
          <div>Nairobi, Kenya</div>
          <div>Mobile: +254 712345678</div>
          <div>Email: info@peaksphereken.com</div>
        </td>
        <td class='title'>PURCHASE ORDER</td>
      </tr>
    </table>

    <!-- SUPPLIER + LPO INFO -->
    <table width='100%' class='supplier'>
      <tr>
        <td>
          <strong>Supplier:</strong><br>
          {$lpo['supplier_name']}<br>
          {$lpo['supplier_email']}
        </td>
        <td class='right'>
          <strong>PO NO:</strong> {$lpo_number}<br>
          <strong>Date:</strong> {$lpo['created_at']}<br>
          <strong>Delivery Date:</strong> {$lpo['delivery_date']}<br>
          <strong>Status:</strong> {$lpo['status']}
        </td>
      </tr>
    </table>

    <!-- ITEMS -->
    <table class='items'>
      <thead>
        <tr>
          <th>Sl.</th>
          <th>Description</th>
          <th>Qty</th>
          <th>Rate (KES)</th>
          <th>Amount (KES)</th>
        </tr>
      </thead>
      <tbody>";
    
    $count = 1;
    foreach ($all_items as $item) {
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

    $html .= "
      </tbody>
    </table>

    <!-- TOTALS -->
    <table width='100%' style='margin-top:20px;'>
      <tr>
        <td class='right'><strong>Subtotal:</strong></td>
        <td width='15%' class='right'>".number_format($subtotal,2)."</td>
      </tr>
      <tr>
        <td class='right'><strong>VAT (16%):</strong></td>
        <td class='right'>".number_format($vat,2)."</td>
      </tr>
      <tr>
        <td class='right'><strong>Total:</strong></td>
        <td class='right'>".number_format($total,2)."</td>
      </tr>
      <tr>
        <td class='right'><strong>Paid:</strong></td>
        <td class='right'>".number_format($paid,2)."</td>
      </tr>
    </table>

    <!-- BALANCE -->
    <div class='balance-box'>
      Balance Due: <span>KES ".number_format($balance,2)."</span>
    </div>

    <!-- SIGNATURE -->
    <div class='footer'>
      <p>___________________________</p>
      <p>Authorized Signatory</p>
    </div>
    ";

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("lpo_{$lpo_number}.pdf");
}
?>
