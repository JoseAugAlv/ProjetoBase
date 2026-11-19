<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <title><?= e($tituloPagina ?? App::getName()) ?></title>

    <?php if (MenuHelper::isModuleEnabled('acessibilidade')): ?>
    <!-- Acessibilidade: aplica tema/fonte/cores salvos ANTES de desenhar a página (sem "piscar") -->
    <script>
        window.pbAplicarAcessibilidade = function (p) {
            var h = document.documentElement, filtros = [];
            h.setAttribute('data-tema', p.tema === 'escuro' ? 'escuro' : 'claro');
            h.setAttribute('data-cor', p.cor || 'normal');
            h.style.fontSize = (100 + (p.fonte || 0) * 12.5) + '%';
            if (p.contraste) { h.setAttribute('data-contraste', 'alto'); } else { h.removeAttribute('data-contraste'); }
            if (p.links) { h.setAttribute('data-links', 'destacar'); } else { h.removeAttribute('data-links'); }
            if (p.tema === 'escuro') { filtros.push('invert(1) hue-rotate(180deg)'); }
            if (p.cor === 'cinza') { filtros.push('grayscale(1)'); }
            else if (p.cor && p.cor !== 'normal') { filtros.push('url(#pb-' + p.cor + ')'); }
            if (p.contraste) { filtros.push('contrast(1.35)'); }
            h.style.filter = filtros.join(' ');
        };
        try { window.pbAplicarAcessibilidade(JSON.parse(localStorage.getItem('pb-acessibilidade') || '{}')); } catch (e) {}
    </script>
    <link rel="stylesheet" href="<?= asset('css/acessibilidade.css') ?>">
    <?php endif; ?>

    <link rel="shortcut icon" href="<?= asset('uploads/image/logo.ico') ?>" type="image/x-icon">

    <!-- CSS base -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- CSS específico da página (definido na view: $cssPagina = 'arquivo.css') -->
    <?php if (!empty($cssPagina) && preg_match('/^[a-zA-Z0-9_\-]+\.css$/', $cssPagina)): ?>
        <link rel="stylesheet" href="<?= asset('css/' . $cssPagina) ?>">
    <?php endif; ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 (versão fixa) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <!-- Navegação e rodapé -->
    <link rel="stylesheet" href="<?= asset('css/nav.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
</head>
<body>
