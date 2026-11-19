<?php
// app/Views/crud/editar.php — formulário genérico de edição (CrudController)

$cssPagina = 'crud.css';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/nav.php';
?>

<section class="crud-section animate-in">
    <div class="container">
        <div class="crud-content">

            <div class="crud-hero">
                <div>
                    <h1><i class="fas fa-edit" style="color: var(--color-impact-green);"></i> Editar <?= e($labelSingular) ?></h1>
                    <p class="crud-subtitle">Atualize os dados abaixo</p>
                </div>
                <span class="badge-count"><i class="fas fa-hashtag"></i> ID #<?= e($id) ?></span>
            </div>

            <form action="<?= url($routePrefix . '/atualizar') ?>" method="POST" class="crud-form">
                <?= csrf_field() ?>
                <input type="hidden" name="<?= e($primaryKey) ?>" value="<?= e($id) ?>">

                <?php require __DIR__ . '/_campos.php'; ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-new"><i class="fas fa-save"></i> Salvar alterações</button>
                    <a href="<?= url($routePrefix) ?>" class="btn"><i class="fas fa-times"></i> Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
