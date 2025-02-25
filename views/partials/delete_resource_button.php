
<button class="btn btn-danger delete-btn">Delete</button>
<script>
    $(document).on('click', '.delete-btn', function () {
        $.ajax({
                url: `./`,
                type: `DELETE`,
                success: function (response) {
                    console.log("DELETED", response)
                    window.location.href = ".."

                },
                error: function (xhr, status, error) {
                    console.log("DELETE Error:", xhr.error);
                }
            }
        );
    });
</script>
