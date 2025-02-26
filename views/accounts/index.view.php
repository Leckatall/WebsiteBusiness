<main>
    <div class='mx-5 py-2 sm:px-6 px-4 bg-body-tertiary'>
        <?php const ROLES = ['NONE/ERR', 'Student', 'Tutor', 'Admin'] ?>
        <table id="users-table" class="display table table-striped table-bordered">
            <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</main>
<script>
    function getBtn(id, type){
        switch(type){
            case 'approve':
                return `<button class="btn btn-success btn-sm approve-btn" data-id="${id}">Approve</button>`;
            case 'delete':
                return `<button class="btn btn-danger btn-sm delete-btn" data-id="${id}">Delete</button>`;
            case 'view':
                return `<a class="btn btn-primary btn-sm" href="/accounts/${id}">View Account</button>`;
        }
    }
    function update_table() {
        $('#users-table').DataTable({
            ajax: "http://localhost/api/accounts", // Calls the userCourses() method
            columns: [
                {data: "email", render: (data, type, row) => `<a href="/accounts/${row.id}">${data}</a>`},
                {
                    data: "privilege_level",
                    render: (data) => `<p>${['NONE/ERR', 'Student', 'Tutor', 'Admin'][data]}</p>`
                },
                {data: "approved", render: (data) => `<p>${!!data}</p>`},
                {
                    data: null,
                    render: (data, type, row) => row.approved
                        ? getBtn(row.id, 'view')
                        : getBtn(row.id, 'approve') + getBtn(row.id, 'delete')
                },
            ],
            dom: '<"top"fi>rt<"bottom"lp><"clear">',
        });
    }

    $(document).ready(function () {
        update_table();
    });

    $(document).on('click', '.approve-btn', function () {
        $.ajax({
                url: `/accounts/${$(this).data('id')}`,
                type: `PATCH`,
                contentType: 'application/json',
                data: JSON.stringify({action: 'approve'}),
                success: function (response) {
                    $('#users-table').DataTable().ajax.reload();
                    console.log("approved student", response)
                },
                error: function (xhr, status, error) {
                    console.log("Error:", xhr.error);
                }
            }
        );
    });
</script>

