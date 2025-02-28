<div class="modal fade" id="applicantsModal" tabindex="-1" aria-labelledby="applicantsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Course Applicants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="applicantList" class="list-group mb-3">
                    <!-- Applicants -->
                </ul>
                <!-- Status Message -->
                <div id="statusMessage" class="text-muted"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let applicantContainer;
    $(document).ready(function () {
        applicantContainer = $('#applicantList');
        $('#<?= $modalActivateBtnId ?>').on('click', fetchApplicants)
    });

    function fetchApplicants() {
        return fetch("/api/courses/<?=$courseId?>/users?filter=applicants")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateApplicantModal(data.accounts);
                } else {
                    console.log("Failed to get accounts")
                }
            })
            .catch(error => {
                console.error("Error fetching applicants: ", error)
                }
            )
    }

    function updateApplicantModal(accounts) {
        applicantContainer.empty();
        accounts.forEach(account => {
            let listItem = $('<li>').addClass('list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative');
            let userEmail = $('<span>').text(account.email);

            let approveBtn = $('<button>')
                .addClass('w-50 mx-1 btn btn-success approve-btn')
                .data('id', account.id)
                .text('Approve');

            let rejectBtn = $('<button>')
                .addClass('w-50 mx-1 btn btn-danger reject-btn')
                .data('id', account.id)
                .text('Reject');

            let btnContainer = $('<div>')
                .addClass('w-50 d-flex justify-content-between');

            btnContainer.append(approveBtn);
            btnContainer.append(rejectBtn);

            listItem.append(userEmail);
            listItem.append(btnContainer);

            applicantContainer.append(listItem);
        });
        $('.approve-btn').on('click', approveAccount);
        $('.reject-btn').on('click', rejectAccount);
    }

    function approveAccount(){
        fetch(`/api/courses/<?=$courseId ?>/users/${$(this).data('id')}`, {
            method: 'PATCH'})
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    console.log("approved");
                    fetchApplicants();
                }else{
                    console.log("Did not approve account");
                }
            })
            .catch(error => {
                console.error("Error while approving account: ", error);
            })
    }
    // TODO: Maybe?? refactor approve and reject into 1 function?
    function rejectAccount(){
        fetch(`/api/courses/<?=$courseId ?>/users/${$(this).data('id')}`, {
            method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    console.log("rejected");
                    fetchApplicants();
                }else{
                    console.log("Did not reject account");
                }
            })
            .catch(error => {
                console.error("Error while rejecting account: ", error);
            })
    }

</script>