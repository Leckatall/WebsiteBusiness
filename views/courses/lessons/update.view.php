<?php

use Core\Session;

$default = $defaults ?? $lesson ?? ['set_date' => date('Y-m-d')];
?>
<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <form class="form-group card m-5 p-3" method="POST"
              action="/lessons<?= (isset($lesson)) ? "/{$lesson['id']}" : '' ?>" enctype="multipart/form-data">
            <?php if (isset($lesson)) : ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="action" value="update">
            <?php endif ?>
            <div>
                <div class="mb-2 container">
                    <div class="row g-2 justify-content-between">
                        <div class="col-md-4 align-items-start">
                            <div class="mb-3 w-75">
                                <label for="courseId" class="form-label d-block text-center">Lesson Course</label>
                                <select class="form-select-sm w-100" name="courseId" id="courseId">
                                    <?php foreach ($courses as $course): ?>
                                        <option value=<?= $course["id"] ?>
                                            <?= ($course["id"] == ($default['courseId'] ?? $lesson['courseId'] ?? $defaultCourseId ?? null)) ? 'selected' : '' ?>>
                                            <?= $course["name"] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <?php if (isset($errors['courseId'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['courseId'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column align-items-end">
                            <div class="mb-3 w-75">
                                <label for="studentAction" class="form-label d-block text-center">Lesson Type</label>
                                <select class="form-select-sm w-100" name="student_action" id="studentAction">
                                    <option value="0">Normal</option>
                                    <option value="1">Upload</option>
                                    <option value="2">No Retakes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <?php load_partial('handled_input.php', [
                        'id' => 'title',
                        'name' => 'Title',
                        'type' => 'text',
                        'required' => true,
                        'hide_label' => true,
                        'default' => $default,
                        'errors' => $errors]) ?>
                    <?php load_partial('handled_input.php', [
                        'tag' => 'textarea',
                        'id' => 'description',
                        'name' => 'Description',
                        'type' => 'text',
                        'required' => true,
                        'hide_label' => true,
                        'default' => $default,
                        'errors' => $errors]) ?>
                </div>
                <div class="form-group row row-cols-2 mb-2">
                    <?php load_partial('handled_input.php', [
                        'id' => 'set_date',
                        'name' => 'Set Date:',
                        'type' => 'date',
                        'required' => true,
                        'default' => $default,
                        'errors' => $errors]) ?>

                    <?php load_partial('handled_input.php', [
                        'id' => 'due_date',
                        'name' => 'Due Date:',
                        'type' => 'date',
                        'required' => false,
                        'default' => $default,
                        'errors' => $errors
                    ]) ?>

                </div>
            </div>
            <div class="mx-auto mt-3">
                <?php if (isset($lesson)) : ?>
                    <a class="btn btn-secondary" href=".">Cancel</a>
                    <a class="btn btn-danger delete-btn">Delete Lesson</a>
                <?php endif ?>

                <button class="btn btn-success px-5" type="submit">
                    <?= isset($lesson) ? "Save Changes" : "Add Lesson" ?>
                </button>
            </div>
        </form>
    </div>
</main>
<script>
    $(document).ready(function () {
        $('.delete-btn').on('click', function () {
            fetch(".", {
                headers: {"Content-Type": "application/json"},
                method: "DELETE"
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("delete success")
                        window.location.href = "/courses/<?=$lesson['courseId'] ?>";
                    } else {
                        console.log("delete failed")
                    }
                })
                .catch(error => {
                    console.error("Error raised during delete: ", error)
                })
        })
    })
</script>
