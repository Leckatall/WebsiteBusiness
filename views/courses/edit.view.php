<?php

use Core\Session;

?>

<main>
    <div class='card mx-auto m-5 p-3 w-50'>
        <form method="POST" action="/courses/<?= $course['id']; ?>">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="action" value="update">
            <?php load_partial('handled_input.php', [
                'id' => 'name',
                'name' => 'Course Name',
                'type' => 'text',
                'required' => true,
                'default' => $course,
                'errors' => $errors]) ?>

            <?php load_partial('handled_input.php', [
                'id' => 'description',
                'name' => 'Course Description',
                'tag' => 'textarea',
                'required' => true,
                'default' => $course,
                'errors' => $errors]) ?>

            <div class="m-2 d-flex justify-content-between">
                <div>
                    <a class="btn btn-secondary" href=".">Back</a>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Update Course</button>
                    <?php load_partial('delete_resource_button.php') ?>
                </div>
            </div>
        </form>
        <!--        <form method="POST" action="/course">-->
        <!--        <input type="hidden" name="_method" value="DELETE">-->
        <!--        <input type="hidden" name="course_id" value="--><?php //= $course['id'] ?><!--">-->
        <!--        <button class="btn btn-danger">Delete Course</button>-->
        </form>
    </div>
</main>
