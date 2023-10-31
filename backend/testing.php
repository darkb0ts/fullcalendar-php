<?php
$uniqueID = time() . bin2hex(random_bytes(1)); // Combines timestamp and 16-character random string
echo $uniqueID;

?>