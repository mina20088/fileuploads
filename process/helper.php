<?php
require_once "../config/dbconfig.php";
function checkFileExistence(string $filename): bool
{
    $file = "";
    $is_Exists = false;
    global $connection;
    if(isset($connection))
    {
        if ($statement = $connection->prepare("select file_name from images where file_name = ?"))
        {
            if ($statement->bind_param('s', $filename))
            {
                if ($statement->execute())
                {
                    if ($statement->bind_result($file))
                    {
                        while ($statement->fetch())
                        {
                            $is_Exists = true;
                        }
                    }
                }
            }
        }
    }
    return $is_Exists;
}
