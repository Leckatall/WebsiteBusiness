
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="uploadFileList" class="list-group mb-3"></ul>
                <!-- File Input -->
                <div id="fileInputContainer">
                    <input type="file" id="fileInput" class="form-control file-input mb-3" multiple>
                </div>
                <!-- Status Message -->
                <div id="statusMessage" class="text-muted"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-upload">Upload</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selected_files = [];

    $(document).ready(function () {
        $("#fileInputContainer").on("change", ".file-input", function () {
            handleFileSelection(this.files);
            $(this).hide();
            createNewFileInput();
        });

        $(".btn-upload").on("click", function () {
            uploadModalFiles();
        });
    });

    function createNewFileInput() {
        let newInput = $('<input type="file" class="form-control file-input mt-2" multiple>');
        $("#fileInputContainer").append(newInput);
    }

    function handleFileSelection(files) {
        $.each(files, function (index, file) {
            let fileId = "file-" + index;
            selected_files.push({file, id: fileId, name: file.name, title: file.name});

            let indx = selected_files.length - 1;
            let listItem = `
                    <li class="list-group-item d-flex justify-content-between align-items-end" id="${fileId}">
                        <div class="form-group title-input w-50 p-2">
                            <label for="${file.name}" class="form-label" >"${file.name}" Title</label>
                            <input type="text" id="${file.name}" class="form-control me-2 file-title" value="${file.name}"
                                data-index="${indx}">
                        </div>
                        <button class="w-25 h-100 p-2 m-2 btn btn-danger btn-sm btn-remove-file" data-index="${indx}">Remove File</button>
                        <span class="w-25 h-100 p-2 mx-2 my-auto mb-3 badge bg-secondary status">Pending...</span>
                    </li>
                `;
            $("#uploadFileList").append(listItem);
        });

        $(".file-title").on("input", function() {
                let index = $(this).data("index");
                selected_files[index].title = $(this).val();
            });

        $(".btn-remove-file").on("click", function () {
            let index = $(this).data("index");
            selected_files.splice(index, 1);
            $(this).closest("li").remove();
        });
    }

    function uploadModalFiles() {
        if (selected_files.length === 0) {
            alert("Please select files first.");
            return;
        }
        $.each(selected_files, function(index, fileData){
            let formData = new FormData();
            formData.append("file", fileData.file, fileData.name);
            formData.append("title", fileData.title);
            formData.append("for", "<?= $action['location'] ?>");
            formData.append("forId", <?= $action['id'] ?>);

            $("#" + fileData.id + " .btn-remove-file").remove();
            $("#" + fileData.id + " .title-input").replaceWith(`<div class="card w-50 p-2 justify-content-between align-content-center"><h3 class="m-auto">${fileData.title}</h3></div>`);

            let fileStatusEl = $("#" + fileData.id + " .status");
            fileStatusEl.text("Uploading...").removeClass("bg-secondary").addClass("bg-warning");
            uploadFile(formData).then(result => {
                if(result){
                    fileStatusEl.text("Uploaded").removeClass("bg-warning").addClass("bg-success");
                    return;
                }
                fileStatusEl.text("Failed").removeClass("bg-warning").addClass("bg-danger");
            })
        });
    }
</script>