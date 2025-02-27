let numButtonClicks = 0;

function buttonClicked() {
    numButtonClicks = numButtonClicks + 1;
    document.getElementById("mainDiv").textContent =
        "Button Clicked times: " + numButtonClicks;
}

function downloadFile(fileId) {
    fetch('/api/uploads?file_id=' + fileId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.file_url;
            } else {
                alert('Error downloading file');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('File download raised an error');
        });
}

function uploadFile(formData) {
    return fetch('/api/uploads', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log("checking data:");
            console.log(data);
            if (data.success) {
                $(document).trigger('file-uploaded');
                return true;
            } else {
                alert("Error uploading file");
                return false;
            }
        })
        .catch(error => {
            console.error("Error:", error.message)
            return false;
        });
}

console.log("loaded script.js")
