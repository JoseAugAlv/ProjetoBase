<?php
// app/Views/errors/erro.php — página única para 403, 404, 419 e 500 (View::erro)

$tituloPagina = $codigo . ' - ' . $titulo;
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/nav.php';
?>

<section class="section-block animate-in" style="min-height:60vh;display:flex;align-items:center">
    <div class="container" style="text-align:center;max-width:640px">
        <div style="font-size:5rem;font-weight:800;line-height:1;color:#10b981"><?= (int) $codigo ?></div>
        <h1 style="margin:1rem 0 .5rem"><?= e($titulo) ?></h1>
        <p style="color:#64748b"><?= e($mensagem) ?></p>
        <p style="margin-top:2rem">
            <a href="<?= url('/') ?>" class="btn btn-primary"><i class="fas fa-home"></i> Ir para o início</a>
        </p>
        <?php if (!empty($detalhe)): ?>
            <pre style="text-align:left;margin-top:2rem;padding:1rem;background:#0f172a;color:#e2e8f0;border-radius:8px;overflow:auto;font-size:12px"><?= e($detalhe) ?></pre>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
