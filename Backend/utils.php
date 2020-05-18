<?php
function error($errorMsg)
{
    $error = array('Error' => $errorMsg);
    echo(json_encode($error));
}

function closeConnectionAndDie($conn)
{
    $conn->close();
    die();
}
?>