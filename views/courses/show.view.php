<?php

use Core\Session;

load_partial('course_applicants_modal.php',
    [
        'modalActivateBtnId' => 'viewApplicantsBtn',
        'courseId' => $course['id']
    ]);
?>

<main class="m-5">
    <div class="card p-3">
        <div class='card p-3 mb-2'>
            <h3 class="">Description</h3>
            <p class=""><?= $course["description"] ?></p>
        </div>

        <div class='card shadow-sm'>
            <div class="card-header p-3">
                <h2 class="mb-0">Lesson List</h2>
            </div>

            <div class="card-body bg-secondary-subtle p-3">
                <table class="table table-striped table-bordered" id="course-lessons-table"
                       data-src="/api/courses/<?= $course['id'] ?>/lessons">
                    <thead class="table-secondary">
                    <tr>
                        <th class="w-50">Lesson Title</th>
                        <th class="w-25">Set Date</th>
                        <th class="w-25">Due Date</th>
                    </tr>
                    </thead>
                    <tbody id="course-lessons">

                    </tbody>
                </table>
            </div>
            <?php if (Session::getRole() > 1) : ?>
                <div class="card-footer text-end">
                    <a class="btn btn-success" href="/courses/<?= $course['id'] ?>/lessons/create">Add a Lesson</a>
                </div>
            <?php endif ?>
        </div>
        <?php if (Session::getRole() > 1) : ?>
            <div class="row row-cols-2 p-2">
                <a class="col-1 m-2 btn btn-secondary" href="/courses/<?= $course['id'] ?>/edit">Edit Course</a>
                <a class="col-2 m-2 btn btn-primary" href="/courses/<?= $course['id'] ?>/users">View Participants</a>
                <a id="viewApplicantsBtn" class="col-2 m-2 btn btn-success" data-bs-toggle="modal"
                   data-bs-target="#applicantsModal">View Applicants</a>
            </div>
        <?php endif ?>
</main>

<script>
    function renderLessons(lessons) {
        const lessonsContainer = $('#course-lessons');
        lessons.forEach(lesson => {
            const tableRow = $('<tr>');
            const lessonTitleCell = $('<td>')
                .append(
                    $('<div>')
                        .addClass('card text-center')
                        .append(
                            $('<h4>')
                                .addClass('m-1 card-title')
                                .text(lesson.title)
                        )
                        .append(
                            $('<a>')
                                .addClass('stretched-link')
                                .attr('href', `/lessons/${lesson.id}`)
                        )
                );
            tableRow.append(lessonTitleCell);
            tableRow.append($('<td>').append($('<p>').text(lesson.set_date)));
            tableRow.append($('<td>').append($('<p>').text(lesson.due_date)));
            lessonsContainer.append(tableRow);
        });
    }

    $(document).ready(function () {
        let table = $('#course-lessons-table');
        let apiUrl = table.attr('data-src');
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.lessons.sort((a, b) => new Date(a.set_date) - new Date(b.set_date));
                    renderLessons(data.lessons)
                } else {
                    console.log("Failed to retrieve lessons")
                }
            })
            .catch(error => {
                console.error("Error raised while fetching lessons: ", error)
            });
        // table.DataTable({
        //     ajax: apiUrl,
        //     columns: [
        //         {
        //             data: "title",
        //             render: (data, type, row) => `<div style="text-align: center; font-size:28px" class="card"><a class="mx-0 my-2 card-title" href="/lessons/${row.id}">${data}</a></div>`
        //         },
        //         {data: "set_date", render: (data) => `<p>${data}</p>`},
        //         {data: "due_date", render: (data) => `<p>${(data !== '0000-00-00') ? data : "N/A"}</p>`},
        //
        //     ],
        //     dom: '<"top"fi>rt<"bottom"lp><"clear">',
        //     autoWidth: true,
        //     processing: true,
        // });
        // table.on('draw.dt', function () {
        //     $('#course-lessons-table tbody tr td').removeClass('sorting_1 sorting_asc sorting_desc');
        // });
    });
</script>

