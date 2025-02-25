
<main>
<div class='mx-5 p-3 card'>
    <form method="POST" action="/courses" class="form-group">
        <?php load_partial('handled_input.php', [
                    'id' => 'name',
                    'name' => 'Course Name',
                    'type' => 'text',
                    'required' => true]) ?>

            <?php load_partial('handled_input.php', [
                    'id' => 'description',
                    'name' => 'Course Description',
                    'tag' => 'textarea',
                    'required' => true]) ?>
        <br>
        <button type="submit" class="px-4 btn btn-primary form-control">
            Add Course
        </button>
    </form>
</div>
</main>

