<?php

use Core\Session;

load_partial('file_upload_modal.php', ['action' => ['location' => 'lessons', 'id' => $lesson['id']]]);
?>
<main class="m-5">
    <div class="card">
        <h2 class="card-header"><?= $lesson['title'] ?></h2>
        <div class="card-body">
            <div>
                <p class="card-subtitle">Set Date:<?= $lesson['set_date'] ?></p>
                <?php if ($lesson['due_date'] != '0000-00-00') : ?>
                    <p class="card-subtitle">Due Date:<?= $lesson['due_date'] ?></p>
                <?php endif ?>
            </div>
            <p class="card-text"><?= $lesson['description'] ?></p>
            <div class="card">
                <h3 class="card-header">Lesson Files</h3>
                <?php load_partial('file_download_card.php', ['data_src' => 'lessons/' . $lesson['id']]); ?>
                <?php if (Session::getRole() > 1) : ?>
                    <div class="text-end m-2">
                        <a class="btn btn-secondary edit-files-btn">Edit Files</a>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload Files</a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="card m-2">
        <?php if (Session::getRole() > 1) : ?>
            <a class="m-2 btn btn-secondary" href="/lessons/<?= $lesson['id'] ?>/edit"> Edit Lesson</a>
        <?php endif ?>
        <a class="m-2 btn btn-primary" href="/courses/<?= $course['id'] ?>"> Back to Course</a>
    </div>
</main>


