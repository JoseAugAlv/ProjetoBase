<?php
// app/Views/crud/criar.php

$basePath = App::getBasePath();
?>

<section class="crud-section animate-in">
    <div class="container">
        <div class="crud-content">

            <!-- Hero -->
            <div class="crud-hero">
                <div>
                    <h1><i class="fas fa-plus-circle" style="color: var(--color-impact-green);"></i> Novo <?= $labelSingular ?></h1>
                    <p class="crud-subtitle">Preencha os dados para criar um novo <?= strtolower($labelSingular) ?></p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-file"></i> Novo registro
                </span>
            </div>

            <!-- Formulário -->
            <form action="<?= $basePath ?>/<?= $routePrefix ?>/salvar" method="POST" class="crud-form">
                <?= ViewHelper::csrfField() ?>

                <div class="form-grid">
                    <?php foreach ($fields as $field): ?>
                        <div class="form-group <?= isset($field['full']) && $field['full'] ? 'form-group-full' : '' ?>">
                            <label for="<?= $field['name'] ?>">
                                <?= htmlspecialchars($field['label']) ?>
                                <?php if ($field['required']): ?>
                                    <span class="required">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if ($field['type'] === 'textarea'): ?>
                                <textarea id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" class="form-control" <?= $field['required'] ? 'required' : '' ?>><?= htmlspecialchars($field['value']) ?></textarea>
                            
                            <?php elseif ($field['type'] === 'checkbox'): ?>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="<?= $field['name'] ?>" value="1" <?= $field['value'] ? 'checked' : '' ?>>
                                    <?= htmlspecialchars($field['label']) ?>
                                </label>
                            
                            <?php elseif ($field['type'] === 'select'): ?>
                                <select id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" class="form-control" <?= $field['required'] ? 'required' : '' ?>>
                                    <?php foreach ($field['options'] ?? [] as $optionValue => $optionLabel): ?>
                                        <option value="<?= htmlspecialchars($optionValue) ?>" <?= $field['value'] == $optionValue ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($optionLabel) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            
                            <?php else: ?>
                                <input type="<?= $field['type'] ?>" id="<?= $field['name'] ?>" name="<?= $field['name'] ?>" 
                                       class="form-control" value="<?= htmlspecialchars($field['value']) ?>"
                                       <?= $field['required'] ? 'required' : '' ?>
                                       <?= isset($field['placeholder']) ? 'placeholder="' . htmlspecialchars($field['placeholder']) . '"' : '' ?>
                                       <?= isset($field['minlength']) ? 'minlength="' . $field['minlength'] . '"' : '' ?>>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Botões -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-new">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                    <a href="<?= $basePath ?>/<?= $routePrefix ?>" class="btn">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>

            <!-- Voltar -->
            <div class="crud-voltar">
                <a href="<?= $basePath ?>/<?= $routePrefix ?>" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>