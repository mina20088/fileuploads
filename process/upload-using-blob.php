<?php
session_start();
require_once '../config/dbconfig.php';
require_once '../process/helper.php';
//error_reporting(0);

if(isset($_POST['submit']))
{
    $acceptableFiles = ['pdf'];
    if(!empty($_FILES['file']['name']))
    {
        if(in_array(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION),$acceptableFiles))
        {
            if($_FILES['file']['size'] <= 6291456)
            {
                if(!$_FILES['file']['error'])
                {
                    if(isset($connection))
                    {
                        $filename = $_FILES['file']['name'];
                        $filetype = $_FILES['file']['type'];
                        $filesize = intval($_FILES['file']['size']);
                        $filedata = file_get_contents(addslashes($_FILES['file']['tmp_name']));
                        $fileEXTENSION = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
                        $query = "insert into uploads(file_filename, file_type, file_Extension, file_size, file_data) values (?,?,?,?,?)";
                        if($statement = $connection->prepare($query))
                        {
                            if($statement->bind_param('sssis',$filename,$filetype,$fileEXTENSION,$filesize,$filedata))
                            {
                                if($statement->execute())
                                {
                                    $_SESSION['response'] = "file uploaded successfully";
                                }
                                else
                                {
                                    $_SESSION['response'] = $connection->error;
                                }
                            }
                            else
                            {
                                $_SESSION['response'] = "there is an error uploading the file";
                            }
                        }
                        else
                        {
                            $_SESSION['response'] = "there is a statement Error" . $connection->error;
                        }
                    }
                    else
                    {
                        $_SESSION['response'] = "cant connect to database";
                    }
                }
                else
                {
                    $_SESSION['response'] = $_FILES['file']['error'];
                }
                header("location:../index.php");

            }
            else
            {
                $_SESSION['response'] = "file size need to be 6MB or less";
                header("location:../index.php");
            }
        }
        else
        {
            $_SESSION['response'] = "only pdf allowed";
            header("location:../index.php");
        }
    }
    else
    {
        $_SESSION['response'] = "please select a file";
        header("location:../index.php");
    }
}
