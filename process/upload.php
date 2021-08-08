<?php

session_start();
require_once '../config/dbconfig.php';
require_once '../process/helper.php';

if (isset($_POST['submit']) && !empty($_FILES['file']['name']))
{
    $uploadDir = "../uploads/";
    $filename = $_FILES['file']['name'];
    $fileTarget = $uploadDir . $filename;
    $fileType = pathinfo($fileTarget, PATHINFO_EXTENSION);
    $allowedTypes = ['png', 'jpg'];
    $stat = !checkFileExistence($filename);
    if(!checkFileExistence($filename))
    {
        if(in_array($fileType,$allowedTypes))
        {
            if(move_uploaded_file($_FILES['file']['tmp_name'],$fileTarget))
            {
                if(isset($connection))
                {
                    if($statement = $connection->prepare('insert into images (file_name) values (?)'))
                    {
                        if($statement->bind_param('s',$filename))
                        {
                            if($statement->execute())
                            {
                                $_SESSION['success'] = "file uploaded successfully";
                                header('location:../index.php');
                            }
                            else
                            {
                                $_SESSION['Error'] = "cant upload the file";
                                header('location:../index.php');
                            }
                        }
                    }
                }
            }
            else
            {
                $_SESSION['Error'] = "sorry error uploading the file please try again";
                header('location:../index.php');
            }
        }
        else
        {
            $_SESSION['Error'] = "please upload valid extensions";
            header('location:../index.php');
        }
    }
    else
    {
        $_SESSION['Error'] = "file already exists on the database";
        header('location:../index.php');
    }
}else
{
    $_SESSION['Error'] = "please choose a file";
    header('location:../index.php');
}