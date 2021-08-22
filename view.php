<?php
include "config/dbconfig.php";
header('content-type:application/json');
if(isset($connection))
{
    $id = $_GET['id'];
    $query = "select * from uploads.uploads where file_upload_id = ?";
    if($statement = $connection->prepare($query))
    {
        if($statement->bind_param('i',$id))
        {
            if($statement->execute())
            {
                $statement->bind_result($id,$filename,$filetype,$fileext,$filesize,$filedata);

                while ($statement->fetch())
                {
                    header("Content-Type:" .$filetype.";");
                    echo $filedata;
                }

            }
        }
    }
}
?>
