
    <main>
        <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
            <form method="POST" action="/courses/lessons" enctype="multipart/form-data">
                <label for="lessonTitle">Lesson Title</label>
                <div>
                    <textarea id="lessonTitle" name="name" placeholder="Title" required><?= $_POST['name'] ?? '' ?></textarea>
                    <?php if (isset($errors['title'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                    <label for="lessonDesc">Lesson Description</label>
                    <textarea id="lessonDesc" name="name" placeholder="Description..." required><?= $_POST['name'] ?? '' ?></textarea>
                    <?php if (isset($errors['desc'])) : ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                    <form action="courses/resources" method="POST" enctype="multipart/form-data">
                        <label for="fileUpload">Include a file:</label>
                        <input type="file" name="fileUpload" id="fileUpload">
                        <input type="submit" value="Upload File" name="submit">
                    </form>
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
