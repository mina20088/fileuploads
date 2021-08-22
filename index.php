<?php session_start() ?>
<?php include "config/dbconfig.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload-Page</title>
</head>
<body>
<div class="upload">
    <form action="process/upload-using-blob.php" method="post" enctype="multipart/form-data">
        <input type="file" id="file" name="file">
        <input type="submit" id="btn" name="submit" value="submit">
    </form>
    <?php if (isset($_SESSION['response'])): ?>
        <span style="color:red;"><?php echo $_SESSION['response'] ?></span>
    <?php elseif (isset($_SESSION['response'])): ?>
        <span style="color:blue;"><?php echo $_SESSION['response'] ?></span>
        <?php session_destroy() ?>
    <?php else: ?>
        <span style="color:red;"><?php echo "" ?></span>
    <?php endif; ?>
    <?php session_destroy() ?>
</div>
<div>
    <h2>uploaded file</h2>
    <ol>
        <?php if (isset($connection)): ?>
            <?php if ($statement = $connection->prepare('select * from uploads')): ?>
                <?php if ($statement->execute()): ?>
                    <?php $row = $statement->get_result() ?>
                    <?php while ($Result = $row->fetch_assoc()): ?>
                       <li><a target="_blank" href="view.php?id=<?php echo $Result['file_upload_id']?>"><?php echo
                               $Result['file_filename']?></a></li>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </ol>
</div>
<div>
</div>
</body>
</html>
