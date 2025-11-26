<?php
// ✅ No space or BOM above this line!

require_once __DIR__ . "/vendor/dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// ✅ Recommended config
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$html = "
<h1 style='color:#2c786c;'>HillSagar Test PDF</h1>
<p>If you can read this, Dompdf is working ✅</p>
";

// ✅ Load HTML
$dompdf->loadHtml($html);

// ✅ Set paper size
$dompdf->setPaper('A4', 'portrait');

// ✅ Render HTML → PDF
$dompdf->render();

// ✅ Clear previous output buffer so PDF doesn't break
if (ob_get_length()) ob_end_clean();

// ✅ Stream PDF to browser
$dompdf->stream("test.pdf", ["Attachment" => false]);
exit;
