<?php
require_once __DIR__ . '/dashboard_admin/vendor/autoload.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/session.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ---------------- SECURITY ----------------
if (!isset($_SESSION['user_id'])) exit("Unauthorized access");
if (!isset($_GET['id'])) exit("Missing ID");

$booking_id = (int)$_GET['id'];

// ---------------- FETCH BOOKING ----------------
$stmt = $mysqli->prepare("
    SELECT b.*, u.name, u.email, p.price 
    FROM bookings b
    JOIN users u ON u.id = b.user_id
    JOIN packages p ON p.title = b.destination
    WHERE b.id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) exit("Booking not found");

// ---------------- CALCULATIONS ----------------
$subtotal = $data['price'] * $data['travelers'];
$gst = round($subtotal * 0.18, 2);
$grand_total = round($subtotal + $gst, 2);

$invoice_no = "HS-" . date("Y") . "-" . str_pad($booking_id, 5, "0", STR_PAD_LEFT);

$qr = "https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=" .
    urlencode("https://hillsagar.42web.io/verify_booking.php?id=$booking_id");

$seal = ($data['status'] === "Confirmed")
    ? "<img src='https://i.ibb.co/7g58N2P/golden-seal.webp' class='seal'>"
    : "";

// ---------------- HTML + CSS ----------------
$html = "
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<style>

:root{
    --primary:#2c786c;
    --secondary:#004445;
    --accent:#fab700;
    --gray:#e0e0e0;
    --font:'DejaVu Sans';
}

body{
    font-family: var(--font);
    background:#fff;
    margin:0;
    padding:25px 30px;
    font-size:13px;
}

/* HEADER STYLE B */
.header{
    text-align:center;
    padding:18px;
    background:#fff;
    border:1px solid var(--gray);
    border-radius:10px;
}
.header h1{
    margin:0;
    font-size:26px;
    color:var(--primary);
}
.header p{
    margin:5px 0 0;
    font-size:13px;
    color:var(--secondary);
}
.underline{
    height:4px;
    background:var(--accent);
    margin-top:10px;
    border-radius:3px;
}

/* CARDS */
.box{
    border:1px solid var(--gray);
    border-radius:8px;
    padding:12px;
    margin-top:12px;
}

/* TABLE */
.table{
    width:100%;
    border-collapse:collapse;
}
.table th{
    background:var(--primary);
    color:white;
    padding:9px;
    text-align:left;
}
.table td{
    border:1px solid var(--gray);
    padding:9px;
}

/* TOTALS */
.total td:nth-child(2){
    background:var(--accent);
    font-weight:bold;
}

/* QR */
.qr-box{
    text-align:center;
    margin-top:10px;
}

/* SEAL */
.seal{
    width:120px;
    margin-top:10px;
}

/* SIGNATURE */
.signature{
    text-align:right;
    font-weight:bold;
    margin-top:20px;
    color:var(--secondary);
}

/* FOOTER */
.footer{
    text-align:center;
    font-size:11px;
    margin-top:15px;
}

</style>
</head>

<body>

<div class='header'>
    <h1>HillSagar</h1>
    <p>Explore the Hills of India • Official Travel Invoice</p>
    <div class='underline'></div>
</div>

<div class='box'>
<b>Invoice No:</b> $invoice_no<br>
<b>Issued On:</b> ".date("d M Y")."<br>
<b>Booking ID:</b> $booking_id
</div>

<div class='box'>
<table class='table'>
<tr><th>Name</th><td>{$data['name']}</td></tr>
<tr><th>Email</th><td>{$data['email']}</td></tr>
<tr><th>Destination</th><td>{$data['destination']} – {$data['state']}</td></tr>
<tr><th>Travel Date</th><td>{$data['travel_start_date']}</td></tr>
<tr><th>Travelers</th><td>{$data['travelers']}</td></tr>
<tr><th>Status</th><td>{$data['status']}</td></tr>
</table>
</div>

<div class='box'>
<table class='table total'>
<tr><th>Subtotal</th><td>₹$subtotal</td></tr>
<tr><th>GST (18%)</th><td>₹$gst</td></tr>
<tr><th>Grand Total</th><td>₹$grand_total</td></tr>
</table>
</div>

<div class='qr-box'>
<img src='$qr' width='130'><br>
<small>Scan to verify booking</small>
$seal
</div>

<div class='signature'>
Authorized Signature<br>HillSagar Travels
</div>

<div class='footer'>
© HillSagar Travels — Ahmedabad, Gujarat<br>
Thank you for choosing HillSagar ❤️
</div>

</body>
</html>
";

// ---------------- GENERATE PDF ----------------
$dompdf = new Dompdf(["enable_remote" => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();

$pdfOutput = $dompdf->output();
$pdfName = "invoice_$invoice_no.pdf";

// ---------------- SEND EMAIL ----------------
$mail = new PHPMailer(true);

try{
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    // CHANGE THESE
    $mail->Username = "bharadavavivan358@gmail.com";
    $mail->Password = "kvam bpkt bccs wacr";

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom("bharadavavivan358@gmail.com", "HillSagar Travels");
    $mail->addAddress($data["email"], $data["name"]);

    $mail->Subject = "Your HillSagar Invoice $invoice_no";
    $mail->Body = "Dear {$data['name']},<br><br>Your invoice is attached.<br><br>Regards,<br>HillSagar Team";
    $mail->isHTML(true);

    $mail->addStringAttachment($pdfOutput, $pdfName);
    $mail->send();

}catch(Exception $e){
    // ignore email error
}

// ---------------- DOWNLOAD PDF ----------------
$dompdf->stream($pdfName, ["Attachment" => true]);
exit;

?>
