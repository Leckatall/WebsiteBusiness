
<main>
    <div class='mx-5 py-2 sm:px-6 px-4 bg-secondary-subtle'>
        <table id="user-courses-table" class="display table table-striped table-bordered">
            <thead>
            <tr>
                <th>Course Name</th>
                <th>Score</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>

<script>
    $(document).ready(function () {
        $('#user-courses-table').DataTable({
            ajax: "http://localhost/api/users/<?= $user_id ?>/courses", // Calls the userCourses() method
            columns: [
                {data: "name", render: (data, type, row) => `<a href="/courses/${row.id}">${data}</a>`},
                {data: "score", render: (data) => `<p>${data}</p>`}
            ],
            dom: '<"top"fi>rt<"bottom"lp><"clear">',
        });
    });
</script>


