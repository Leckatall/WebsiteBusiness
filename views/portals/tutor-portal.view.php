<!--TODO: Approve course enrollments-->
<!--TODO: View Students in a course and their score-->


<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <!--TODO: Maybe use AJAX or better way of implementing this-->
        <!--        <details>-->
        <!--            <summary>Enrollable Students</summary>-->
        <!--TODO: Make this work-->
        <!--            <ul>-->
        <!--                --><?php //foreach ($enrollable_students as $student): ?>
        <!--                    <li>-->
        <!--                        <p>--><?php //= $student['Email'] ?><!--</p>-->
        <!--                        <a href="/accounts/enroll" class="m-5">Enroll Student</a>-->
        <!--                        <a href="/accounts">Delete</a>-->
        <!--                    </li>-->
        <!--                --><?php //endforeach ?>
        <!--            </ul>-->
        <!--        </details>-->
        <a href="/accounts">View Student Accounts</a>
        <br>
        <a href="/my-courses">Your Courses</a>
        <br>
        <a href="/courses">All courses</a>
        <br>

        <p class="mt-6">
            <a href="/courses/create" class="text-blue-500 hover:underline">Add Course</a>
        </p>
    </div>
</main>




