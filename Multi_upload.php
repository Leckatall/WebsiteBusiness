<?php
// Handle the file upload on the backend
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    // Directory to store uploaded files
    $uploadDir = 'uploads/';

    // Loop through all uploaded files
    foreach ($_FILES['files']['name'] as $key => $fileName) {
        // Generate a unique filename (timestamp + original file name)
        $uniqueFileName = time() . '_' . $fileName;

        // Define the target path for each file
        $targetPath = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetPath)) {
            $message = "File $fileName uploaded successfully as $uniqueFileName.<br>";
        } else {
            $message = "Error uploading $fileName.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple File Upload with PHP</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #progress {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Upload Multiple Files</h2>

    <!-- PHP message for success or failure -->
    <?php if (isset($message)) echo $message; ?>

    <!-- File upload form -->
    <form id="uploadForm" enctype="multipart/form-data" method="POST">
        <input type="file" name="files[]" multiple>
        <button type="submit">Upload Files</button>
    </form>

    <!-- Show upload progress -->
    <div id="progress"></div>

    <script>
        $(document).ready(function() {
            $("#uploadForm").on("submit", function(e) {
                e.preventDefault(); // Prevent normal form submission
                
                var formData = new FormData(this); // Create FormData with the files

                $.ajax({
                    url: '', // This will send the request to the current page (index.php)
                    type: 'POST',
                    data: formData,
                    contentType: false, // Don't set content type manually (FormData will handle this)
                    processData: false, // Prevent jQuery from processing the data
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                var percent = (e.loaded / e.total) * 100;
                                $('#progress').html('Uploading: ' + Math.round(percent) + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        $('#progress').html('Upload Complete'); // Show complete message
                    },
                    error: function() {
                        $('#progress').html('Error during upload.');
                    }
                });
            });
        });
    </script>
</body>
</html>
