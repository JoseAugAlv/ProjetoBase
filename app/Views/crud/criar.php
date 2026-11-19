<?php
// app/Views/crud/criar.php — formulário genérico de criação (CrudController)

$cssPagina = 'crud.css';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/nav.php';
?>

<section class="crud-section animate-in">
    <div class="container">
        <div class="crud-content">

            <div class="crud-hero">
                <div>
                    <h1><i class="fas fa-plus-circle" style="color: var(--color-impact-green);"></i> Novo <?= e($labelSingular) ?></h1>
                    <p class="crud-subtitle">Preencha os dados abaixo</p>
                </div>
            </div>

            <form action="<?= url($routePrefix . '/salvar') ?>" method="POST" class="crud-form">
                <?= csrf_field() ?>

                <?php require __DIR__ . '/_campos.php'; ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-new"><i class="fas fa-save"></i> Salvar</button>
                    <a href="<?= url($routePrefix) ?>" class="btn"><i class="fas fa-times"></i> Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
