<?php
// app/Views/crud/_campos.php — campos do formulário (usado por criar.php e editar.php)
?>
<div class="form-grid">
    <?php foreach ($fields as $field): ?>
        <?php $nome = e($field['name']); ?>
        <div class="form-group <?= $field['type'] === 'textarea' ? 'form-group-full' : '' ?>">
            <?php if ($field['type'] !== 'checkbox'): ?>
                <label for="<?= $nome ?>">
                    <?= e($field['label']) ?>
                    <?php if ($field['required']): ?><span class="required">*</span><?php endif; ?>
                </label>
            <?php endif; ?>

            <?php if ($field['type'] === 'textarea'): ?>
                <textarea id="<?= $nome ?>" name="<?= $nome ?>" class="form-control" rows="4" <?= $field['required'] ? 'required' : '' ?>><?= e($field['value']) ?></textarea>

            <?php elseif ($field['type'] === 'checkbox'): ?>
                <label class="checkbox-label">
                    <input type="checkbox" name="<?= $nome ?>" value="1" <?= $field['value'] ? 'checked' : '' ?>>
                    <?= e($field['label']) ?>
                </label>

            <?php elseif ($field['type'] === 'select'): ?>
                <select id="<?= $nome ?>" name="<?= $nome ?>" class="form-control" <?= $field['required'] ? 'required' : '' ?>>
                    <?php foreach ($field['options'] as $valor => $rotulo): ?>
                        <option value="<?= e($valor) ?>" <?= (string) $field['value'] === (string) $valor ? 'selected' : '' ?>><?= e($rotulo) ?></option>
                    <?php endforeach; ?>
                </select>

            <?php else: ?>
                <input type="<?= e($field['type']) ?>" id="<?= $nome ?>" name="<?= $nome ?>" class="form-control"
                       value="<?= e($field['type'] === 'date' && $field['value'] ? substr($field['value'], 0, 10) : $field['value']) ?>"
                       <?= $field['type'] === 'number' ? 'step="any"' : '' ?>
                       <?= $field['required'] ? 'required' : '' ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
