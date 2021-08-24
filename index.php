<?php session_start() ?>
<?php include "config/dbconfig.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/Normalize.css">
    <title>Upload-Page</title>

</head>
<body>
<h1 class="text-center">Upload A File Project Using PHP</h1>
<div class="container mt-5">
    <div class="upload">
        <form action="process/upload-using-blob.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <input type="file" id="file" name="file" class="form-control">
                <input type="submit" id="btn" class="btn btn btn-primary" name="submit" value="submit">
            </div>
        </form>
        <?php if (isset($_SESSION['response'])): ?>
            <span style="color:red;"><?php echo $_SESSION['response'] ?></span>
        <?php endif; ?>
        <?php session_destroy() ?>
    </div>
</div>
<div class="container mt-5">
    <h2 class="text-center">uploaded file</h2>
    <table class="table">
        <thead>
           <tr>
               <td>id</td>
               <td>filename</td>
               <td>Extension</td>
               <td>size</td>
               <td>file</td>
           </tr>
        </thead>
        <tbody>
        <?php if(isset($connection)):?>
            <?php if($statement = $connection->prepare('select * from uploads')):?>
                <?php if($statement->bind_result($id,$filename,$filetype,$extension,$filesize,$filedata)):?>
                    <?php if($statement->execute()):?>
                        <?php while ($row = $statement->fetch()):?>
                            <tr>
                                <td><?php echo $id?></td>
                                <td><?php echo $filename?></td>
                                <td><?php echo $extension?></td>
                                <td><?php echo ceil($filesize /1024)?></td>
                                <td><a target="-_blank" href="view.php?id=<?php echo $id?>"><?php echo $filename?></a></td>
                            </tr>
                        <?php endwhile;?>
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div>
</div>
</body>
</html>
