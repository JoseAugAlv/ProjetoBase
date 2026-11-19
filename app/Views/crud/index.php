<?php
// app/Views/crud/index.php — listagem genérica (CrudController)

$cssPagina = 'crud.css';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/nav.php';
?>

<section class="crud-section animate-in">
    <div class="container">
        <div class="crud-content">

            <div class="crud-hero">
                <div>
                    <h1><i class="fas fa-list" style="color: var(--color-impact-green);"></i> <?= e($labelPlural) ?></h1>
                    <p class="crud-subtitle">Gerenciar <?= e(mb_strtolower($labelPlural)) ?></p>
                </div>
                <span class="badge-count"><i class="fas fa-database"></i> <?= (int) $total ?> registro(s)</span>
            </div>

            <div class="crud-actions">
                <a href="<?= url($routePrefix . '/criar') ?>" class="btn btn-new"><i class="fas fa-plus"></i> Novo <?= e($labelSingular) ?></a>
            </div>

            <div class="crud-search">
                <form method="GET" action="<?= url($routePrefix) ?>">
                    <div class="search-group">
                        <input type="text" name="busca" class="form-control" placeholder="Buscar..." value="<?= e($busca) ?>">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        <?php if ($busca !== ''): ?>
                            <a href="<?= url($routePrefix) ?>" class="btn btn-clear"><i class="fas fa-times"></i></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if (empty($registros)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Nenhum registro encontrado</h3>
                    <a href="<?= url($routePrefix . '/criar') ?>" class="btn btn-new"><i class="fas fa-plus"></i> Novo <?= e($labelSingular) ?></a>
                </div>
            <?php else: ?>
                <div class="crud-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <?php foreach ($fields as $field): ?>
                                    <th><?= e(ucfirst(str_replace('_', ' ', $field))) ?></th>
                                <?php endforeach; ?>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registros as $registro): ?>
                                <?php $id = (int) $registro[$primaryKey]; ?>
                                <tr>
                                    <?php foreach ($fields as $field): ?>
                                        <td>
                                            <?php
                                            $valor = $registro[$field] ?? '';
                                            if ($field === 'ativo') {
                                                echo $valor ? '<span class="status-badge ativo">Ativo</span>' : '<span class="status-badge inativo">Inativo</span>';
                                            } elseif (strpos($field, 'data') === 0) {
                                                echo e(ViewHelper::formatDate($valor, strlen((string) $valor) > 10 ? 'd/m/Y H:i' : 'd/m/Y'));
                                            } else {
                                                echo e(mb_strimwidth((string) $valor, 0, 80, '…'));
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= url($routePrefix . '/editar?id=' . $id) ?>" class="btn btn-sm btn-edit" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="<?= url($routePrefix . '/excluir') ?>" method="POST" style="display:inline" onsubmit="return confirm('Tem certeza que deseja remover este registro?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Remover"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($paginationHtml)): ?>
                    <div class="pagination-container"><?= $paginationHtml ?></div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
