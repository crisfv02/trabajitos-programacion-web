<?php
session_start();

if (!isset($_SESSION['ultima_compra'])) {
    die("ERROR: No existe ultima_compra en la sesión");
}

if (count($_SESSION['ultima_compra']) == 0) {
    die("ERROR: ultima_compra está vacía");
}

require_once __DIR__ . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$productos = $_SESSION['ultima_compra'];
$usuario   = $_SESSION['usuario'] ?? 'Cliente';
$fecha     = date("d/m/Y H:i:s");


$total = 0;
foreach ($productos as $p) {
    $total += $p['precio'];
}

$folio = "PAC-" . date("YmdHis");

ob_start();
?>

<page>
    <h1 style="text-align:center;">PAC MENSWEAR</h1>

    <p><b>Folio:</b> <?= $folio ?></p>
    <p><b>Cliente:</b> <?= $usuario ?></p>
    <p><b>Fecha:</b> <?= $fecha ?></p>

    <hr>

    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th>Producto</th>
            <th>Talla</th>
            <th>Precio</th>
        </tr>

        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= $p['nombre'] ?></td>
            <td><?= $p['talla'] ?></td>
            <td>$<?= number_format($p['precio'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3 style="text-align:right;">
        TOTAL: $<?= number_format($total, 2) ?> MXN
    </h3>

    <p style="text-align:center;">
        Gracias por su compra
    </p>
</page>

<?php
$html = ob_get_clean();

$pdf = new Html2Pdf('P', 'Letter', 'es');
$pdf->writeHTML($html);
$pdf->output('ticket.pdf', 'I');