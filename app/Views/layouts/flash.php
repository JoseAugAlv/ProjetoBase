<?php
// app/Views/layouts/flash.php — mostra (uma vez) a mensagem gravada com flash().
// Incluído automaticamente pelo nav.php.

if (!empty($_SESSION['flash'])):
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $tipoFlash = in_array($flash['tipo'] ?? '', ['sucesso', 'erro', 'aviso', 'info'], true) ? $flash['tipo'] : 'info';
?>
    <div class="flash-<?= $tipoFlash ?>" role="alert">
        <?= e($flash['mensagem'] ?? '') ?>
        <?php if (!empty($flash['acao']['url'])): ?>
            <a href="<?= e($flash['acao']['url']) ?>" style="margin-left:.5rem;font-weight:600;text-decoration:underline;color:inherit"><?= e($flash['acao']['texto'] ?? 'Clique aqui') ?></a>
        <?php endif; ?>
    </div>
<?php endif; ?>
