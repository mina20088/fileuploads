<?php

header("Access-Control-Allow-Origin: *");
header("Content-type:application/json; charset: UTF-8");
header('Access-Control-Allow-Method: POST');

require_once '../config/dbconfig.php';
require_once "../process/helper.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $allowedExtensions = ['pdf'];
    if(!empty($_FILES['file']['name']))
    {
        if(in_array(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION),$allowedExtensions))
        {
            if(($_FILES['file']['size']) <= 6291456)
            {

                if(isset($connection))
                {
                    if($connection->connect_errno)
                    {
                        echo json_encode([
                            "status"=> 0,
                            "message" => "",
                            'connectionError'=> $connection->connect_error
                        ]);
                    }
                    else
                    {
                        $fileName = $_FILES['file']['name'];
                        $fileSize = intval($_FILES['file']['size']);
                        $fileData = file_get_contents(addslashes($_FILES['file']['tmp_name']));
                        $fileType = $_FILES['file']['type'];
                        $fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);
                        if(checkFileExistence($fileName))
                        {
                            echo json_encode([
                                "status"=> 0,
                                "message" => "",
                                'connectionError'=> [],
                                'error'=> 'file already uploaded'
                            ]);
                        }
                        else
                        {
                            $query = "insert into uploads(file_filename, file_type, file_Extension, file_size, file_data) value (?,?,?,?,?)";
                            if($Statement = $connection->prepare($query))
                            {
                                if($Statement->bind_param("sssis",$fileName,$fileType,$fileExtension,$fileSize,$fileData))
                                {
                                    if($Statement->execute())
                                    {
                                        echo json_encode([
                                            "status"=> 1,
                                            "message" => "Data Inserted"
                                        ]);
                                    }
                                }
                            }
                        }

                    }
                }
            }
            else
            {
                echo json_encode([
                    "status"=> 0,
                    "message" => "file size need to be 6 MB and less"
                ]);
            }
        }
        else
        {
            echo json_encode([
                "status"=> 0,
                "message" => "only pdf extensions are allowed"
            ]);
        }
    }
    else
    {
        echo json_encode([
            "status"=> 0,
            "message" => "please choose a file"
        ]);

    }

}
else
{
    echo json_encode([
        "status"=> 0,
        "message" => "access denied"
    ]);
}





