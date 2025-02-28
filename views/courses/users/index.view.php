<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <a href=".">Back to course</a>
        <table id="courseUsers">
            <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Score</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <!-- fill -->
            </tbody>
        </table>


    </div>
</main>

<script>
    $(document).ready(function () {

    });

    function getCourseUsers() {
        return fetch("/api/courses/")
    }
</script>