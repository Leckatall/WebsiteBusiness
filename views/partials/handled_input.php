<?php $default_value = $_POST[$id] ?? $default[$id] ?? '' ?>

<div>
    <label for="<?= $id ?>" class="text-body-emphasis form-label" <?=($hide_label ?? false) ? 'hidden': '' ?>><?= $name ?></label><br>
    <<?= $tag ?? "input type=\"$type\"" ?>
        id="<?= $id ?>"
        name="<?= $id ?>"
        class="form-control <?= $class ?? ''?>"
        placeholder="<?= $name ?>"
    <?= $required ? 'required' : '' ?>
    <?= isset($tag) ? ">$default_value</$tag>" : "value=\"$default_value\">" ?>
    <?php if (isset($errors[$id])) : ?>
        <p class="text-danger small"><?= $errors[$id] ?></p>
    <?php endif; ?>
</div>