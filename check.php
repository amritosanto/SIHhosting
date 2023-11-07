<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $uploadDirectory = 'temp_uploads/';  // Change this to the directory where you want to save the uploaded files
    $uploadedFile = $uploadDirectory . basename($_FILES['pdf_file']['name']);

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $uploadedFile)) {
        // File was successfully uploaded
        $pythonScript = 'main2.py';  // Path to your Python script
        $command = "python3 $pythonScript $uploadedFile";

        // Execute the Python script with the uploaded file as an argument
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            // Successfully executed the Python script
            $outputMessage = implode("<br>", $output); // Convert the array to a string
        } else {
            // Failed to execute the Python script
            $outputMessage = "Error executing the Python script: " . implode("<br>", $output);
        }

        // Clean up the temp_uploads folder
        $files = glob($uploadDirectory . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);  // Delete each file
            }
        }

        if (isset($outputMessage)) {
            echo "<p>$outputMessage</p>";
        }
    } else {
        // File upload failed
        echo "File upload failed.";
    }
} else {
    // Invalid request or file not provided
    echo "Invalid request or file not provided.";
}
?>
