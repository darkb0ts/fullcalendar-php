<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the file was uploaded without errors
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {

        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];
        $fileSize = $_FILES['csvFile']['size'];
        $fileType = $_FILES['csvFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check if the file has a csv extension
        if ($fileExtension == 'csv') {
            if (($open = fopen($fileTmpPath, "r")) !== false) {
                $array = [];
                while (($data = fgetcsv($open, 1000, ",")) !== false) {
                    $array[] = $data;
                }
                fclose($open);

                echo "<pre>";
                // To display array data
                var_dump($array);
                echo "</pre>";
            } else {
                echo "Error opening the file.";
            }
        } else {
            echo "Uploaded file is not a CSV file.";
        }
    } else {
        echo "Error uploading the file.";
    }
} else {
    echo "Invalid request method.";
}

?>
