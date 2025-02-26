<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <form class="form-group card m-5 p-3" method="POST" action="/lessons" enctype="multipart/form-data">
            <?php if (isset($lesson)) : ?>
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="action" value="update">
            <?php endif ?>
            <div>
                <div class="mb-2">
                    <label for="courseId">Lesson Course</label>
                    <select class="form-select-sm" name="courseId" id="courseId">
                        <?php foreach ($courses as $course): ?>
                            <option value=<?= $course["id"] ?>
                                <?php echo ($course["id"] == ($_REQUEST['courseId'] ?? $lesson['courseId'])) ? 'selected' : '' ?>>
                                <?= $course["name"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errors['courseId'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['courseId'] ?></p>
                    <?php endif; ?>
                </div>
                <?php $default = $lesson ?? ['set_date'=> date('Y-m-d')] ?>
                <div class="form-group mb-3">
                    <?php load_partial('handled_input.php', [
                        'id' => 'title',
                        'name' => 'Title',
                        'type' => 'text',
                        'required' => true,
                        'hide_label' => true,
                        'default' => $default]) ?>
                    <?php load_partial('handled_input.php', [
                        'tag' => 'textarea',
                        'id' => 'description',
                        'name' => 'Description',
                        'type' => 'text',
                        'required' => true,
                        'hide_label' => true,
                        'default' => $default]) ?>
                </div>
                <div class="form-group row row-cols-2 mb-2">
                    <?php load_partial('handled_input.php', [
                        'id' => 'set_date',
                        'name' => 'Set Date:',
                        'type' => 'date',
                        'required' => true,
                        'default' => $default]) ?>

                    <?php load_partial('handled_input.php', [
                        'id' => 'due_date',
                        'name' => 'Due Date:',
                        'type' => 'date',
                        'required' => false,
                        'default' => $default
                    ]) ?>
                </div>
            </div>
            <div class="mx-auto mt-3">
                <?php if(isset($lesson)) :?>
                <a class="btn btn-secondary" href="/courses/<?=$lesson['courseId'] ?>">cancel</a>
                <?php endif ?>

                <button class="btn btn-success px-5" type="submit">
                    <?= isset($lesson) ? "Save Changes" : "Add Lesson" ?>
                </button>
            </div>
        </form>
    </div>
</main>

