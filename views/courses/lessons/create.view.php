
    <main>
        <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
            <form method="POST" action="/lessons" enctype="multipart/form-data">
                <div>
                    <label for="courseId">Lesson Course</label>
                    <select name="courseId" id="courseId">
                        <?php foreach ($courses as $course): ?>
                            <option value=<?= $course["Id"] ?> <?php echo ($course["Id"] == $_REQUEST["courseId"]) ? 'selected' : '' ?>>
                                <?= $course["Name"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errors['courseId'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['courseId'] ?></p>
                    <?php endif; ?>
                    <label for="lessonTitle">Lesson Title</label>
                    <textarea id="lessonTitle" name="title" placeholder="Title"
                              required><?= $_POST['title'] ?? '' ?></textarea>
                    <?php if (isset($errors['title'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['title'] ?></p>
                    <?php endif; ?>

                    <label for="lessonDesc">Lesson Description</label>
                    <textarea id="lessonDesc" name="description" placeholder="Description..."
                              required><?= $_POST['description'] ?? '' ?></textarea>
                    <?php if (isset($errors['description'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['desc'] ?></p>
                    <?php endif; ?>

                    <label for="set_date">Set Date:</label>
                    <input type="date" name="set_date" value="<?php echo $_POST['set_date'] ?? date('Y-m-d'); ?>" required>

                    <label for="due_date">Due Date:</label>
                    <input type="date" name="due_date" value="<?php echo $_POST['set_date'] ?? null; ?>">
<!--                     TODO: Add AJAX to allow sequential file uploads -->
                    <label for="fileUpload">Upload Files:</label>
                    <input type="file" name="files[]" id="fileUpload" multiple>
                </div>
                <p>
                    <!--send them smwhere after they click submit-->
                    <button type="submit">
                        Add Lesson
                    </button>
                </p>
            </form>
        </div>
    </main>

