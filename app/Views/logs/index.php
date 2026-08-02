<?php
// app/Views/logs/index.php

$tituloPagina = 'Logs do Sistema - ' . App::getName();
$cssPagina = 'logs.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';
?>

<section class="logs-section animate-in">
    <div class="container">
        <div class="logs-content">

            <!-- Hero -->
            <div class="logs-hero">
                <div>
                    <h1><i class="fas fa-history" style="color: #6c757d;"></i> Logs do Sistema</h1>
                    <p class="logs-subtitle">
                        <i class="fas fa-list"></i> Visualize todas as atividades do sistema
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-file-alt"></i> <?= $total ?? 0 ?> registro(s)
                </span>
            </div>

            <!-- Filtros -->
            <div class="logs-filtros">
                <form method="GET" action="<?= $basePath ?>/logs">
                    <div class="filtros-grid">
                        <div class="filtro-group">
                            <label for="buscar"><i class="fas fa-search"></i> Buscar</label>
                            <input type="text" id="buscar" name="buscar" class="form-control" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>" placeholder="Digite para buscar...">
                        </div>
                        
                        <div class="filtro-group">
                            <label for="tabela"><i class="fas fa-table"></i> Tabela</label>
                            <select id="tabela" name="tabela" class="form-control">
                                <option value="">Todas</option>
                                <?php foreach ($tabelas as $t): ?>
                                    <option value="<?= htmlspecialchars($t) ?>" <?= ($_GET['tabela'] ?? '') == $t ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filtro-group">
                            <label for="acao"><i class="fas fa-tag"></i> Ação</label>
                            <select id="acao" name="acao" class="form-control">
                                <option value="">Todas</option>
                                <?php foreach ($acoes as $a): ?>
                                    <option value="<?= htmlspecialchars($a) ?>" <?= ($_GET['acao'] ?? '') == $a ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($a) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filtro-group filtro-actions">
                            <label>&nbsp;</label>
                            <div class="filtro-buttons">
                                <button type="submit" class="btn btn-filter">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                                <a href="<?= $basePath ?>/logs" class="btn btn-clear">
                                    <i class="fas fa-undo"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Lista de Logs -->
            <?php if (empty($logs)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Nenhum log encontrado</h3>
                    <p>Tente ajustar os filtros para encontrar o que procura.</p>
                </div>
            <?php else: ?>
                <div class="logs-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ação</th>
                                <th>Tabela</th>
                                <th>Registro</th>
                                <th>Detalhes</th>
                                <th>Usuário</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td>#<?= $log['id_log'] ?></td>
                                    <td><span class="badge-acao"><?= htmlspecialchars($log['acao']) ?></span></td>
                                    <td><?= htmlspecialchars($log['tabela_afetada'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($log['registro_id'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($log['detalhes'] ?? '-') ?></td>
                                    <td><strong><?= htmlspecialchars($log['usuario_nome'] ?? 'Sistema') ?></strong></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($log['data_criacao'])) ?></td>
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
                
                <div class="logs-info">
                    <i class="fas fa-info-circle"></i> 
                    Total de registros: <strong><?= $total ?? 0 ?></strong>
                    | Mostrando <strong><?= count($logs) ?></strong> registro(s)
                </div>
            <?php endif; ?>

            <!-- Voltar -->
            <div class="logs-voltar">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>