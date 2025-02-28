<?php

use Core\Session;

?>
<main class="m-5">
    <div class="card">
        <h2 class="card-header"><?= $lesson['title'] ?></h2>
        <div class="card-body">
            <div class="card mb-2 p-2">
                <h4 class="card-subtitle">Set Date: <?= $lesson['set_date'] ?></h4>
                <?php if ($lesson['due_date'] != '0000-00-00') : ?>
                    <h4 class="card-subtitle">Due Date: <?= $lesson['due_date'] ?></h4>
                <?php endif ?>
                <?php if ($user_registered) : ?>
                    <p class="card-subtitle"> Your Score: <?= $lesson_user['score'] ?></p>
                <?php endif ?>
                <p class="card-text"><?= $lesson['description'] ?></p>
            </div>
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
                <div id="studentUploadCard" class="card mt-2" <?= $user_registered ? '' : 'hidden' ?>>
                    <h3 class="card-header">Submitted Files</h3>
                    <?php load_partial('file_download_card.php', [
                        'data_src' => 'lessons/' . $lesson['id'] . '?student=me',
                        'editable' => true
                    ]); ?>
                    <?php load_partial('file_upload_modal.php', [
                        'action' => [
                            'location' => 'lessons',
                            'id' => $lesson['id']
                        ]]); ?>
                </div>
            <?php else : ?>
                <div class="card mt-2">
                    <div id="studentSubmissionsHeader"
                         class="card-header dropdown-toggle d-flex align-items-center list-group-item-action position-relative">
                        <h3 class="m-2">Student Submissions</h3>
                        <a data-bs-toggle="collapse" class="stretched-link" href="#submissionCollapse"
                           aria-expanded="false" aria-controls="submissionCollapse"></a>
                    </div>
                    <div id="submissionCollapse" class="collapse">
                        <ul id="lessonStudentsList" class="list-group">
                            <li class="list-group-item text-center">No users registered</li>
                            <!-- <li>placeholder item</li> -->
                        </ul>
                    </div>
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
                $('#studentUploadCard').removeAttr('hidden');
            } else {
                console.log("Button unable to register user");
            }
        });
    }

    function fetchRegisteredStudents() {
        return fetch("/api/lessons/<?=$lesson['id']?>/users")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Successfully got lesson users")
                    return data.users;
                } else {
                    console.log("Failed to get lesson users")
                    return [];
                }
            })
            .catch(error => {
                console.error("Error raised while fetching lesson users", error);
            });
    }

    function displayRegisteredStudents(students) {
        const lessonStudentsList = $('#lessonStudentsList');
        if(students.length > 0){
            lessonStudentsList.empty();
        }

        students.forEach(student => {
            const studentItem = $('<li>')
                .addClass('list-group-item card p-0 m-2')
            const studentContainer = $('<div>').addClass('card-header dropdown-toggle d-flex align-items-center list-group-item-action position-relative');
            const studentEmail = $('<span>').text(student.email);
            const expandStudent = $('<a>')
                .addClass('stretched-link')
                .attr('data-bs-toggle', "collapse")
                .attr('href', `#student${student.id}Collapse`)
                .attr('aria-expanded', "false")
                .attr('aria-controls', `student${student.id}Collapse`);

            studentContainer.append(studentEmail);
            studentContainer.append(expandStudent);

            const studentCollapse = $('<div>')
                .addClass('collapse student-collapse')
                .attr('id', `student${student.id}Collapse`)
                .data('id', student.id);

            const studentFilesContainer = $('<div>')
                .addClass('card');

            const studentFilesList = $('<ul>')
                .addClass('list-group')
                .attr('id', `studentFileList`);

            const studentNoFilesItem = $('<li>')
                .addClass('list-group-item  text-center')
                .text('No files uploaded');

            studentFilesList.append(studentNoFilesItem);

            studentFilesContainer.append(studentFilesList);

            const studentScoreContainer = $('<div>')
                .addClass('p-2 justify-content-end d-flex');
            const studentScoreInput = $('<input>')
                .addClass('form-control-sm mx-2 student-score-input')
                .attr('type', 'number')
                .val(student.score)
                .attr('id', `${student.id}scoreInput`);
            const studentScoreSubmit = $('<button>')
                .addClass('btn btn-success student-score-submit')
                .text('Update Student Score')
                .attr('disabled', true)
                .attr('id', `${student.id}scoreSubmit`)
                .data('id', student.id);

            studentScoreContainer.append(studentScoreInput);
            studentScoreContainer.append(studentScoreSubmit);

            studentCollapse.append(studentFilesContainer);
            studentCollapse.append(studentScoreContainer);


            studentItem.append(studentContainer);
            studentItem.append(studentCollapse);

            lessonStudentsList.append(studentItem)
        });
        $('.student-collapse').on('show.bs.collapse', function () {
            console.log("knows expanded")
            populateFiles($(this).data('id')).then(files => showFileLinks(files, $(this).find('#studentFileList')));
        });
        $('.student-score-input').on('input', function () {
            $(this).parent().children(".student-score-submit").removeAttr("disabled");
        })
        $('.student-score-submit').on('click', function(){
            let studentScore = $(this).parent().children(".student-score-input").val();
            updateStudentScore($(this).data('id'), studentScore).then(data => {
                if (data.success){
                    console.log("Updated student score");
                    $(this).attr('disabled', true);
                } else{
                    console.log("Failed to update student score");
                }
            })
        })
            .catch(error => {
                console.error("Error updating student score: ", error);
            })
    }

    function populateFiles(userId) {
        return fetch(`/api/uploads/lessons/<?=$lesson['id']?>/users/${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return data.files;
                } else {
                    console.log("failed to retrieve files");
                    return [];
                }
            }).catch(error => {
                console.error("Raised:", error);
                return [];
            });
    }

    function showFileLinks(files, fileListContainer) {
        if(files.length > 0){
            fileListContainer.empty();
        }
        files.forEach(file => {
            let listItem = $('<li>').addClass('list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative');
            let fileTitle = $('<span>').text(file.title);

            listItem.append(fileTitle);

            let fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
            let fileButton;
            if (fileExtension === "quiz") {
                listItem.css('border', '2px solid purple');
                fileButton = $('<a>')
                    .addClass('btn z-2')
                    .css('background-color', 'purple')
                    .text('Take Quiz');
            } else {
                fileButton = $('<a>')
                    .addClass('btn btn-primary btn-sm z-2')
                    .attr('href', '/api/uploads/' + file.id)
                    .attr('download', file.name)
                    .text('Download');
            }


            let viewLink = $('<a>')
                .addClass('stretched-link ')
                .attr('href', '/api/uploads/' + file.id + "?view=true")


            listItem.append(viewLink);
            listItem.append(fileButton);

            fileListContainer.append(listItem);
        });
    }

    function updateStudentScore(studentId, score){
        let formData = new FormData();
        formData.append('score', score)
        formData.append('_method', "PATCH")
        return fetch(`/api/lessons/<?=$lesson['id']?>/users/${studentId}`, {
            method: "POST",
            body: formData

        }).then(response => response.json());
    }

    $(document).ready(function () {
            $('#register-btn').on('click', registerBtn);
            fetchRegisteredStudents().then(students => displayRegisteredStudents(students));
            $('#studentSubmissionsHeader').on('click', function () {
                fetchRegisteredStudents().then(students => displayRegisteredStudents(students));
            })
        }
    )

</script>

