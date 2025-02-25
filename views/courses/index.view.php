<main class="m-5">
<div class='mx-auto  py-6 list-group'>
    <?php foreach ($courses as $course): ?>
         <a href="/courses/<?= htmlspecialchars($course['id']) ?>"
            class="px-6 list-group-item list-group-item-action">
            <?= $course['name'] ?>
         </a>
    <?php endforeach ?>
    <p class="mt-6">
        <a href="/courses/create" class="text-blue-500 hover:underline">Add Course</a>
    </p>
</div>
</main>




