<h3>Stored Files</h3>
<ul id="storedFileList" data-storage-location=""></ul>

<h3>Upload Files</h3>
<ul id="uploadFileList"></ul>

<h3>Upload Files</h3>
<input type="file" id="fileInput">
<button onclick="">Upload</button>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById("fileInput");
        const uploadFileList = document.getElementById("uploadFileList");
        const storedFileList = document.getElementById("storedFileList")
        const lessonForm = document.getElementById("lessonForm");

        let uploadedFiles = []; // Store uploaded file metadata

        // Function to upload a file
        function uploadFile() {
            if (!fileInput.files.length) {
                alert("Please select a file to upload.");
                return;
            }

            const file = fileInput.files[0];
            const customName = file.name;

            let formData = new FormData();
            formData.append("file", file);
            formData.append("custom_name", customName);

            fetch("/uploads", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        uploadedFiles.push(data.file); // Store file info for lesson creation
                        displayTempFiles();
                        fileInput.value = ""; // Clear input
                    } else {
                        alert("File upload failed.");
                    }
                })
                .catch(error => console.error("Error uploading file:", error));
        }

        function displayFilesTo(file_list, files){
            file_list.innerHTML = "";
            files.forEach((file, index) => {
                const li = document.createElement("li");

                // Custom name input
                let nameInput = document.createElement("input");
                nameInput.type = "text";
                // consider placeholder instead of value?
                nameInput.value = file.custom_name;
                nameInput.dataset.fileId = file.id;

                // Update button
                let updateBtn = document.createElement("button");
                updateBtn.textContent = "Update";
                updateBtn.onclick = () => updateFileName(file.id, nameInput.value);

                // Remove button
                let removeBtn = document.createElement("button");
                removeBtn.textContent = "Remove";
                removeBtn.onclick = () => removeFile(file.id);

                li.textContent = `(${file.filename})`;

                li.appendChild(nameInput);
                li.appendChild(updateBtn);
                li.appendChild(removeBtn);
                uploadFileList.appendChild(li);
            });
        }
        function displayFiles(){
            // Update the lesson files
            displayLessonFiles()
            // Update the temporary files
            displayTempFiles()
        }
        function displayLessonFiles(){
            fetch("/uploads?lesson_id=")
                .then(response => response.json())
                .then(data => {
                    displayFilesTo(storedFileList, data.files);
                });

        }
        // Function to display uploaded files
        function displayTempFiles() {
            displayFilesTo(uploadFileList, uploadedFiles)
        }

        // Function to update the file name
        function updateFileName(fileId, newName) {
            fetch("/uploads", {
                method: "PATCH",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({id: fileId, custom_name: newName})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("File name updated!");
                        fetchUploadedFiles(); // Refresh the file list
                    } else {
                        alert("Failed to update name.");
                    }
                });
        }

        // Function to remove a file
        function removeFile(fileId) {
            fetch(`/uploads?id=${fileId}`, {method: "DELETE"})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayFiles();
                    } else {
                        alert("Failed to delete file.");
                    }
                });
        }

        // Handle lesson form submission
        lessonForm.addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData(lessonForm);
            fetch("create_lesson.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Lesson created successfully!");
                        uploadedFiles = []; // Reset uploaded files
                        displayFiles();
                        lessonForm.reset();
                    } else {
                        alert("Failed to create lesson.");
                    }
                });
        });

        // Expose the function to global scope
        window.uploadFile = uploadFile;
    });
</script>