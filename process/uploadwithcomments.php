<?php


error_reporting(E_ERROR | E_NOTICE);
session_start();
// include the database file
require_once '../config/dbconfig.php';

//defining the js directory
$uploadDir = "../uploads/";

//getting the js file name from $_FIle global
$file_name = $_FILES['file']['name'];

//define the target path where we want to js the file
$target_file_path = $uploadDir . $file_name;

/*use pathinfo() to get data related to the file path
 * pathinfo() will use the flags to get file extension,
 * dirname,filename,basename and if the flag is nt used
 * will get full information as associative array
 * */
$filetype = pathinfo($target_file_path, PATHINFO_EXTENSION);

if (isset($_POST) && !empty($_FILES['file']['name'])) {
    //defined an array that contains the extensions that are
    // allowed to be uploaded
    $Allowed_Types = ['png', 'jpg'];

    //check if the filetype is in the array
    if (in_array($filetype, $Allowed_Types)) {
        //move the file to js from the temp directory to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file_path)) {
            if (isset($connection)) {
                if (!$connection->connect_error) {
                    $query = "select file_name from images where file_name = ?";
                    if ($statement = $connection->prepare($query)) {
                        if ($statement->bind_param('s', $file_name)) {
                            if ($statement->execute()) {
                                if ($statement->bind_result($file)) {
                                    while ($statement->fetch()) {
                                        if ($file_name === $file) {
                                            $_SESSION['Error'] = "file Already Exists on the database";
                                            header("location:../index.php");
                                        } else {
                                            //write the query to add the file name to the database
                                            $query = "insert into images(file_name) values(?)";

                                            //use the connection to connect to database and insert the files name
                                            if ($statement = $connection->prepare($query)) {
                                                if ($statement->bind_param('s', $file_name)) {
                                                    if ($statement->execute()) {
                                                        $_SESSION['success'] = "file uploaded successfully";
                                                        header("location:../index.php");
                                                    } else {
                                                        $_SESSION['Error'] = "File Is Not Uploaded Please Try Again";
                                                        header("location:../index.php");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $_SESSION['Error'] = "$connection->connect_error";
                    header("location:../index.php");
                }
            }
        } else {
            $_SESSION['Error'] = "sorry there was an error uploading the file";
            header("location:../index.php");
        }
    } else {
        $_SESSION['Error'] = "please select a valid file extension";
        header("location:../index.php");
    }
} else {
    $_SESSION['Error'] = "please choose a file";
    header("location:../index.php");
}

