<div class="card m-2 p-0">
    <ul id="downloadFileList" class="list-group">
        <!-- Files will be populated here -->
    </ul>
</div>

<script>
    let fileListContainer;
    let files;
    let fileLinkHeight;

    $(document).ready(function () {
        fileListContainer = $('#downloadFileList');
        populateFiles().then(showFileLinks);
        $('.edit-files-btn').on('click', editFilesClicked);
    });

    $(document).on('file-uploaded', function (){
        populateFiles().then(showFileLinks);
        $('.edit-files-btn').off().on('click', editFilesClicked);
    })

    function showFileLinks() {
        fileListContainer.empty();
        files.forEach(file => {
            let listItem = $('<li>').addClass('list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative');
            let fileTitle = $('<span>').text(file.title);

            listItem.append(fileTitle);

            let downloadButton = $('<a>')
                .addClass('btn btn-primary btn-sm z-2')
                .attr('href', '/api/uploads/' + file.id)
                .attr('download', file.name)
                .text('Download');

            let viewLink = $('<a>')
                .addClass('stretched-link ')
                .attr('href', '/api/uploads/' + file.id + "?view=true")


            listItem.append(viewLink);
            listItem.append(downloadButton);

            fileListContainer.append(listItem);
        });
    }

    function changeFile(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch($(this).attr('action'), {
            method: 'POST', // Fake news _method will override
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('submitted successfully');
                } else {
                    console.log('form submission failed');
                }
            })
            .then(() => {
                return populateFiles();
            })
            .then(() => {
                $(this).find('.cancel-btn').click();
            })
            .catch(error => {
                console.error('Error raised during fetch:', error);
            });
        console.log(formData.get('_method'));
        if(formData.get('_method') == 'DELETE'){
            $(this).parent().remove();
        }
    }

    function editFileLinks() {
        fileLinkHeight = $('li').outerHeight();
        fileListContainer.empty();
        files.forEach(file => {
            let listItem = $('<li>').addClass('list-group-item list-group-item-action d-flex justify-content-between align-items-center position-relative').height(fileLinkHeight);
            let fileForm = $('<form>')
                .addClass('h-100 w-100 d-flex justify-content-between')
                .attr('action', `/api/uploads/${file.id}`)
                .attr('method', 'POST')
                .attr('id', file.id);
            // Set form method to DELETE
            fileForm.append($('<input>').attr('name', '_method').val('DELETE').attr('id', 'form-method').hide());
            fileForm.append($('<input>').attr('name', 'action').val('rename').hide());

            let fileTitleInput = $('<input>')
                .addClass('w-75 form-control file-title-input')
                .attr('type', 'text')
                .attr('value', file.title)
                .attr('name', 'title')
                .data('id', file.id);

            let formBtnContainer = $('<div>').attr('id', 'form-btn-container');
            formBtnContainer.append($('<button>')
                .addClass('btn h-100 mx-2 btn-danger form-btn')
                .attr('type', 'submit')
                .text('Delete File')
            );

            fileForm.append(fileTitleInput);
            fileForm.append(formBtnContainer);

            fileForm.on('submit', changeFile);

            listItem.append(fileForm);
            fileListContainer.append(listItem);
        });
        $('.file-title-input').on('input', function () {
            let thisForm = $(`#${$(this).data('id')}`);
            let formMethod = thisForm.children('#form-method');
            if (formMethod.val() == 'PATCH') {
                return;
            }
            formMethod.val('PATCH');
            let formBtnContainer = thisForm.children('#form-btn-container');
            formBtnContainer.children('.form-btn')
                .removeClass('btn-danger')
                .addClass('btn-success')
                .text('Save Changes');
            let cancelBtn = $('<button>')
                .addClass('btn h-100 btn-secondary cancel-btn')
                .data('id', $(this).data('id'))
                .text('Cancel');

            formBtnContainer.append(cancelBtn);

            $('.cancel-btn').on('click', cancelRenaming);
        });

    }

    function cancelRenaming() {
        let thisForm = $(`#${$(this).data('id')}`);
        thisForm.children('#form-method').val('DELETE');
        let fileTitle = files.find(file => file.id === $(this).data('id')).title;
        thisForm.children('.file-title-input').val(fileTitle);

        let formBtnContainer = thisForm.children('#form-btn-container');
        formBtnContainer.children('.form-btn')
            .removeClass('btn-success')
            .addClass('btn-danger')
            .text('Delete File');
        formBtnContainer.children('.cancel-btn').remove();
    }

    function editFilesClicked() {
        editFileLinks();
        $(this).removeClass('btn-secondary').addClass('btn-primary').text('Done');
        $(this).off().on('click', doneEditingClicked)
    }

    function doneEditingClicked() {
        populateFiles().then(showFileLinks);
        $(this).removeClass('btn-primary').addClass('btn-secondary').text('Edit Files');
        $(this).off().on('click', editFilesClicked)
    }

    function populateFiles() {
        return fetch("/api/uploads/<?= $data_src ?>")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    files = data.files;
                } else {
                    console.log("failed to retrieve files");
                }
            }).catch(error => {
                console.error("Raised:", error);
            });
    }
</script>
