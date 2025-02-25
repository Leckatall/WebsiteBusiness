
<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <form method="POST" action="/course">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
            <?php load_partial('handled_input.php', [
                    'id' => 'name',
                    'name' => 'Course Name',
                    'type' => 'text',
                    'required' => true,
                    'default' => $course]) ?>

            <?php load_partial('handled_input.php', [
                    'id' => 'description',
                    'name' => 'Course Description',
                    'tag' => 'textarea',
                    'required' => true,
                    'default' => $course]) ?>
            <p>
                <a href=".">Back</a>
                <button type="reset" class="btn btn-check">Reset</button>
                <button type="submit" class="btn btn-primary">Update Course</button>
            </p>
        </form>
<!--        <form method="POST" action="/course">-->
<!--        <input type="hidden" name="_method" value="DELETE">-->
<!--        <input type="hidden" name="course_id" value="--><?php //= $course['id'] ?><!--">-->
<!--        <button class="btn btn-danger">Delete Course</button>-->
        <?php load_partial('delete_resource_button.php') ?>
    </form>
    </div>
</main>
