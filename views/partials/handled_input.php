<div>
    <label for="<?= $id ?>" class="text-body-emphasis form-label"><?= $name ?></label><br>
    <<?= $tag ?? "input type=\"$type\"" ?>
        id="<?= $id ?>"
        name="<?= $id ?>"
        class="form-control"
        placeholder="<?= $name ?>"
    <?= $required ? 'required' : '' ?>
    <?php $default_value = $_POST[$id] ?? $default[$id] ?? '' ?>
    <?= isset($tag) ? ">$default_value</$tag>" : "value=\"$default_value\">" ?>
    <?php if (isset($errors[$id])) : ?>
        <p class="text-red-500 text-xs mt-2"><?= $errors[$id] ?></p>
    <?php endif; ?>

</div>