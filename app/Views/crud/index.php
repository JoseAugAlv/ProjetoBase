<?php
// app/Views/crud/index.php

$basePath = App::getBasePath();
?>

<section class="crud-section animate-in">
    <div class="container">
        <div class="crud-content">

            <!-- Hero -->
            <div class="crud-hero">
                <div>
                    <h1><i class="fas fa-list" style="color: var(--color-impact-green);"></i> <?= htmlspecialchars($labelPlural) ?></h1>
                    <p class="crud-subtitle">Gerenciar <?= strtolower($labelPlural) ?></p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-database"></i> <?= $total ?? 0 ?> registro(s)
                </span>
            </div>

            <!-- Ações -->
            <div class="crud-actions">
                <a href="<?= $basePath ?>/<?= $routePrefix ?>/criar" class="btn btn-new">
                    <i class="fas fa-plus"></i> Novo <?= $labelSingular ?>
                </a>
            </div>

            <!-- Busca -->
            <div class="crud-search">
                <form method="GET" action="<?= $basePath ?>/<?= $routePrefix ?>">
                    <div class="search-group">
                        <input type="text" name="busca" class="form-control" 
                               placeholder="Buscar <?= strtolower($labelPlural) ?>..." 
                               value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if (!empty($_GET['busca'])): ?>
                            <a href="<?= $basePath ?>/<?= $routePrefix ?>" class="btn btn-clear">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Lista -->
            <?php if (empty($registros)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Nenhum <?= strtolower($labelSingular) ?> encontrado</h3>
                    <p>Comece criando o primeiro registro.</p>
                    <a href="<?= $basePath ?>/<?= $routePrefix ?>/criar" class="btn btn-new">
                        <i class="fas fa-plus"></i> Novo <?= $labelSingular ?>
                    </a>
                </div>
            <?php else: ?>
                <div class="crud-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <?php foreach ($fields as $field): ?>
                                    <th><?= ucfirst(str_replace('_', ' ', $field)) ?></th>
                                <?php endforeach; ?>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registros as $registro): ?>
                                <tr>
                                    <?php foreach ($fields as $field): ?>
                                        <td>
                                            <?php
                                            $value = $registro[$field] ?? '';
                                            if ($field === 'ativo') {
                                                echo $value ? '<span class="status-badge ativo">Ativo</span>' : '<span class="status-badge inativo">Inativo</span>';
                                            } elseif (strpos($field, 'data') === 0) {
                                                echo $value ? date('d/m/Y H:i', strtotime($value)) : '-';
                                            } else {
                                                echo htmlspecialchars($value);
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= $basePath ?>/<?= $routePrefix ?>/editar?id=<?= $registro['id'] ?? $registro['id_' . $routePrefix] ?? '' ?>" class="btn btn-sm btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= $basePath ?>/<?= $routePrefix ?>/excluir?id=<?= $registro['id'] ?? $registro['id_' . $routePrefix] ?? '' ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover este registro?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <?php if (isset($paginationHtml)): ?>
                    <div class="pagination-container">
                        <?= $paginationHtml ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Voltar -->
            <div class="crud-voltar">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>