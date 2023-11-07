<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $uploadDirectory = 'temp_uploads/';  // Change this to the directory where you want to save the uploaded files
    $uploadedFile = $uploadDirectory . basename($_FILES['pdf_file']['name']);

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadedFile)) {
        // File was successfully uploaded
        $pythonScript = 'main.py';  // Path to your Python script
        $command = "python3 $pythonScript $uploadedFile";

        // Execute the Python script with the uploaded file as an argument
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            // Successfully executed the Python script
            $uploadMessage = "Successfully Uploaded!";
        } else {
            // Failed to execute the Python script
            $uploadMessage = "Something went wrong.";
        }

        // Clean up the temp_uploads folder
        $files = glob($uploadDirectory . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);  // Delete each file
            }
        }
    } else {
        // File upload failed
        $uploadMessage = "File upload failed.";
    }
} else {
    // Invalid request or file not provided
    $uploadMessage = "Invalid request or file not provided.";
}

// Return the message as a response
echo $uploadMessage;
?>
