<!doctype html>
<?php session_start()?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="upload">
        <form action="process/upload.php" method="post" enctype="multipart/form-data">
            <input type="file" id="file" name="file">
            <input type="submit" id="btn" name="submit" value="submit">
        </form>
        <?php if(isset($_SESSION['Error'])):?>
             <span style="color:red;"><?php echo $_SESSION['Error'] ?></span>
        <?php elseif (isset($_SESSION['success'])):?>
            <span style="color:blue;"><?php echo $_SESSION['success'] ?></span>
            <?php session_destroy()?>
        <?php else:?>
               <span style="color:red;"><?php echo "" ?></span>
        <?php endif;?>
        <?php session_destroy()?>
    </div>
</body>
</html>
