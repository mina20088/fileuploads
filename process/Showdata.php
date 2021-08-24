<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json; charset: UTF-8");
header('Access-Control-Allow-Method: GET');
require "../config/dbconfig.php";



if($_SERVER['REQUEST_METHOD'] === 'GET')
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
            $query = 'select * from uploads';
            if($statement = $connection->prepare($query))
            {
                if($statement->execute())
                {
                    if($Result = $statement->get_result())
                    {
                        $uploads['record'] = [];
                        if($Result->num_rows > 0)
                        {
                            while ($rows = $Result->fetch_assoc())
                            {
                                array_push($uploads['record'],[
                                    'id'=> $rows['file_upload_id'],
                                    'fileName'=> $rows['file_filename'],
                                    'fileType'=> $rows['file_type'],
                                    'fileExtension'=> $rows['file_Extension'],
                                    'fileSize'=> $rows['file_size'],
                                ]);

                            }
                            echo json_encode([
                                "status"=> 1,
                                "message" => "",
                                'connectionError'=> [],
                                'data'=> $uploads['record']
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
        "message" => "Access denied"
    ]);
}
