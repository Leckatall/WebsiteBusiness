<?php

use Core\Session;

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
                <?php if ($user_registered) : ?>
                    <p class="card-subtitle"> Your Score: <?= $lesson_user['score'] ?></p>
                <?php endif ?>
            </div>
            <p class="card-text"><?= $lesson['description'] ?></p>
            <div class="card">
                <h3 class="card-header">Lesson Files</h3>
                <?php load_partial('file_download_card.php', [
                    'data_src' => 'lessons/' . $lesson['id'],
                    'editable' => (Session::getRole() > 1)
                ]); ?>
                <?php if (Session::getRole() > 1) {
                    load_partial('file_upload_modal.php',
                        ['action' => [
                            'location' => 'lessons',
                            'id' => $lesson['id']
                        ]]);
                } ?>
            </div>
            <?php if (Session::getRole() == 1) : ?>
                <div class="card mt-2">
                    <h3 class="card-header">Submitted Files</h3>
                    <?php load_partial('file_download_card.php', [
                        'data_src' => 'lessons/' . $lesson['id'] .'?student=me',
                        'editable' => true
                    ]); ?>
                    <?php load_partial('file_upload_modal.php', [
                        'action' => [
                            'location' => 'lessons',
                            'id' => $lesson['id']
                        ]]); ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="card m-2">
        <?php if (Session::getRole() > 1) : ?>
            <a class="m-2 btn btn-secondary" href="/lessons/<?= $lesson['id'] ?>/edit"> Edit Lesson</a>
        <?php elseif (!$user_registered) : ?>
            <button id="register-btn" class="m-2 btn btn-success">Register</button>
        <?php else : ?>
            <button id="" class="m-2 btn btn-secondary" disabled>Registered</button>
        <?php endif ?>
        <a class="m-2 btn btn-primary" href="/courses/<?= $course['id'] ?>"> Back to Course</a>
    </div>
</main>
<script>
    function registerUser() {
        return fetch("/api/lessons/<?=$lesson['id']?>/users", {
            method: 'POST',
            headers:
                {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                account_id: '<?= Session::getId() ?>'
            })
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Successfully registered");
                    return true;
                } else {
                    console.log("Failed to register user");
                    return false;
                }
            })
            .catch(error => {
                console.error("Error raised while registering user: ", error);
                return false;
            });
    }

    function registerBtn() {
        registerUser().then(isDone => {
            if (isDone) {
                $(this).removeClass('btn-success')
                    .addClass('btn-secondary')
                    .attr('disabled', true)
                    .text("Registered");
            } else {
                console.log("Button unable to register user");
            }
        });
    }

    $(document).ready(
        $('#register-btn').on('click', registerBtn)
    )

</script>

