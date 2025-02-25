<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <form method="POST" action="/lessons" enctype="multipart/form-data">
            <?php if (isset($lesson)) : ?>
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="action" value="update">
            <?php endif ?>
            <div>
                <label for="courseId">Lesson Course</label>
                <select name="courseId" id="courseId">
                    <?php foreach ($courses as $course): ?>
                        <option value=<?= $course["id"] ?>
                            <?php echo ($course["id"] == ($_REQUEST["courseId"] ?? $lesson['courseId'])) ? 'selected' : '' ?>>
                            <?= $course["name"] ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?php if (isset($errors['courseId'])) : ?>
                    <p class="text-red-500 text-xs mt-2"><?= $errors['courseId'] ?></p>
                <?php endif; ?>
                <?php $default = $lesson ?? [] ?>
                <?php load_partial('handled_input.php', [
                    'id' => 'title',
                    'name' => 'Title',
                    'type' => 'text',
                    'required' => true,
                    'default' => $default]) ?>

                <?php load_partial('handled_input.php', [
                    'tag' => 'textarea',
                    'id' => 'description',
                    'name' => 'Description',
                    'type' => 'text',
                    'required' => true,
                    'default' => $default]) ?>

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

                <!--TODO: Add AJAX to allow sequential file uploads -->
                <label for="fileUpload">Upload Files:</label>
                <input type="file" name="files[]" id="fileUpload" multiple>
            </div>
            <p>
                <!--send them smwhere after they click submit-->
                <button type="submit">
                    <?= isset($lesson) ? "Save Changes" : "Add Lesson" ?>
                </button>
            </p>
        </form>
    </div>
</main>

