<html>
<form action="test2.php" enctype="multipart/form-data" method="post">
Select jpg or jpeg or png or pdf to upload:
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit1"><br/>
</form>
<?php
    if(isset($_POST['Submit1'])){
        $target_dir = "uploads/". $_FILES["file"]["name"];
    }
    $errors = array();
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
    $extensions = array("jpeg","jpg","png","pdf");
    if(in_array($file_ext,$extensions) === false){
        $errors = "Extension is not allowed, please choose a JPG or JPEG or PNG or PDF file<br><br><br><br>";
    }
    if(empty($errors) == true){
        move_uploaded_file($file_tmp,$target_dir);
    }
    if ($entries = scandir('uploads/',SCANDIR_SORT_NONE)){
        foreach ($entries as $entry) {
            //Code to auto delete after 300 seconds or 5 minutes
            if (filemtime('uploads/'.$entry) < (time()-300)){
                unlink('uploads/'.$entry);
                continue;
            }
            if ($entry != "." && $entry != ".."){
                $str = 'Creation Date:'.date("F-d-Y-H-i-s.", filemtime("uploads/$entry")).'<br> Modified Date:'.date("F-d-Y-H-i-s.", fileatime("uploads/$entry")).'<br> Size:'.filesize('uploads/'.$entry).' Bytes';
                echo'<a href="uploads/'.$entry.'">'.$entry.'</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                echo  '<a href="delete.php?v='.$entry.'">Delete</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                echo '<button type="button" onclick="hint(\''.$entry.'\')">Properties</button><br>';
                echo '<div id="prop-'.$entry.'" style="display: none;">'.$str.'</div>';
            }
        }
    }
    if ($entries = scandir('deleted/',SCANDIR_SORT_NONE)){
        foreach ($entries as $entry1) {
            //Auto delete after 5 minutes or 300 seconds
            if (filemtime('deleted/'.$entry1) < (time()-300)){
                unlink('deleted/'.$entry1);
                continue;
            }
            if ($entry1 != "." && $entry1 != ".."){
                echo'<a href="deleted/'.$entry1.'">'.$entry1.'</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
                echo  '<a href="restore.php?v='.$entry1.'">Restore</a><br>';
            }
        }
    }
    ?>

<style>
img {
border: 1px solid #ddd;
    border-radius: 4px;
padding: 5px;
width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<body>
<?php
    if ($entries = scandir('uploads/',SCANDIR_SORT_NONE)){
        foreach ($entries as $entry3) {
            if ($entry != "." && $entry3 != ".."){
                echo '<a target="_blank" href="uploads/".$entry3><img src="uploads/".$entry3 alt=></a>';
            }
        }
    }
    ?>
</body>

<script  type="text/javascript">
function hint(id) {
    var x = document.getElementById('prop-'+id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
</html>
