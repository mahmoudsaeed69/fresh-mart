<?php
session_start();


$title = "Videos";

// cheak if found session name
if (isset($_SESSION['Admin'])) {

    include "init.php";


    // Cheak if found the action in the title

    $action = isset($_GET['action']) ? $_GET['action'] : 'video';

    if ($action == 'video') {

        $stam = $con->prepare("SELECT tbl_video.*,itemcourse.name_item,users.Username 
                    AS Admin_add 
                    FROM tbl_video 
                    INNER JOIN itemcourse
                    ON itemcourse.ID = tbl_video.course_id 
                    INNER JOIN users
                    ON users.ID=tbl_video.member_add;");
        $stam->execute();
        $rows = $stam->fetchAll();

        ?>
        <h1 class="text-center">Manage video</h1>

        <div class="container">
            <div class="table">
                <table class="main-table text-center table table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>NameVideo</td>
                            <td>Caption</td>
                            <td>CourseName</td>
                            <td>UserAdd</td>
                            <td>Date</td>
                            <td>Control</td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {


                            echo "<tr>";

                            echo "<td> $row[ID] </td>";
                            echo "<td> $row[Video_name] </td>";
                            echo "<td> $row[caption] </td>";
                            echo "<td> $row[name_item] </td>";
                            echo "<td> $row[Admin_add] </td>";
                            echo "<td> $row[date] </td>";

                            echo "<td>";
                            echo "<a href='video.php?action=Edit&ID=$row[ID]' class='btn btn-success'><i class='fa-regular fa-pen-to-square'></i>Edit</a>";
                            echo "<a href='video.php?action=delet&ID=$row[ID]' class='btn btn-danger confirm'><i class='fa-solid fa-xmark'></i>Remove</a>";
                            echo "</td>";

                            echo "</tr>";

                        }
                        ?>
                    </tbody>
                </table>

                <a href="video.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i>New Video</a>

            </div>
        </div>




    <?php } elseif ($action == 'add') {


        ?>

        <h1 class="text-center">Add Video</h1>

        <div class="container">
            <form action="?action=insert" class="form-horizontal" method="POST" enctype="multipart/form-data">

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">NameVideo</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Type Name The Course" required />
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Caption</label>
                    <div class="col-sm-10 col-md-6">
                        <textarea name="caption" class="form-control" placeholder="Type The Script For Course"
                            required></textarea>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">VideoCourse</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="file" name="video" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">UserAdd</label>
                    <div class="col-sm-10 col-md-6">
                        <details class="custom-select">
                            <summary class="radios">
                                <input type="radio" name="user" id="default" title="....." value="" checked>
                                <?php
                                $stam = $con->prepare("SELECT * FROM users");
                                $stam->execute();
                                $rows = $stam->fetchAll();

                                foreach ($rows as $row) {
                                    echo "<input type='radio' name='user' id='$row[ID]' title='$row[Username]' value='$row[ID]' required>";
                                }
                                ?>
                            </summary>
                            <ul class="list">

                                <?php foreach ($rows as $row) {
                                    echo "<li>";
                                    echo "<label for='$row[ID]'>";
                                    echo $row['Username'];
                                    echo "</label>";
                                    echo "</li>";
                                } ?>
                            </ul>
                        </details>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">CourseName</label>
                    <div class="col-sm-10 col-md-6">
                        <details class="custom-select">
                            <summary class="radios">
                                <input type="radio" name="cat" id="default" title="....." value="" checked>
                                <?php
                                $stam = $con->prepare("SELECT * FROM itemcourse");
                                $stam->execute();
                                $rows = $stam->fetchAll();

                                foreach ($rows as $row) {
                                    echo "<input type='radio' name='cat' id='$row[ID]' title='$row[name_item]' value='$row[ID]' required>";
                                }
                                ?>
                            </summary>
                            <ul class="list">

                                <?php foreach ($rows as $row) {
                                    echo "<li>";
                                    echo "<label for='$row[ID]'>";
                                    echo $row['name_item'];
                                    echo "</label>";
                                    echo "</li>";
                                } ?>
                            </ul>
                        </details>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                        <input type="submit" name="submit" value="Add" class="btn btn-primary btn-lg">
                    </div>
                </div>

            </form>
        </div>



    <?php } elseif ($action == "insert") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $videoName = $_FILES['video']['name'];
            $videoType = $_FILES['video']['type'];
            $videoTmp = $_FILES['video']['tmp_name'];
            $videoSize = $_FILES['video']['size'];

            $allwoed_type = array("mp4", "mov", "avi", "flv", "wmv");
            $get_type_video = explode(".", $videoName);
            $type_video = strtolower(end($get_type_video));

            $name = $_POST['name'];
            $caption = $_POST['caption'];
            $userAdd = $_POST['user'];
            $catname = $_POST['cat'];



            $formErrors = array();
            if (empty($videoName)) {

                $formErrors[] = "No File Uploded";

            }

            // if ($imgSize > 4194304) {

            //     $formErrors[] = "This Img Is Too Big";

            // }

            if (!in_array($type_video, $allwoed_type)) {

                $formErrors[] = "This Type Is Not Allwoed";

            }

            if (empty($name)) {

                $formErrors[] = "Can't Be NameCourse Empty";
            }
            if (empty($caption)) {
                $formErrors[] = "Can't Be Caption Empty";
            }

            if (empty($userAdd)) {
                $formErrors[] = "Can't Levea The UserAdd Empty";

            }
            if (empty($catname)) {
                $formErrors[] = "Can't Levea The Catagory Empty";

            }

            // cheak if found any errors in array

            if (empty($formErrors)) {



                $cheak = cheakName("Video_name", "tbl_video", $name);
                $rand_name = rand(0, 1000000000) . '_' . $videoName;


                if ($cheak == 1) {

                    // generating new name to uploded the img to server 
                    // cheak if no found uniqe name


                    $mes = "<div class='alert alert-danger'> Soory This Name Is Found</div>";
                    redrect($mes, "Add Course", 2, "video.php?action=add");
                } else {

                    move_uploaded_file($videoTmp, "uploded\\video-uploded\\" . $rand_name);

                    $stam = $con->prepare("INSERT INTO tbl_video (Video_name, caption , Video_src , course_id  ,member_add ) 
                                                        VALUES (:n_video, :cap, :v_course, :c_id, :mem_id)");
                    $stam->execute(
                        array(
                            ":n_video" => $name,
                            ":cap" => $caption,
                            ":v_course" => $rand_name,
                            ":c_id" => $catname,
                            ":mem_id" => $userAdd

                        )
                    );
                    $count = $stam->rowCount();

                    if ($count > 0) {
                        $mes = "<div class='alert alert-success'> The Videos Is Addes</div>";
                        redrect($mes, "Video", 2, "video.php");


                    }
                }

            } else {
                foreach ($formErrors as $error) {
                    echo "<div class='container'>";

                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                    header("refresh:2 ; url=video.php?action=add");
                    echo "</div>";


                }
            }


        } else {
            $mes = "<div class='alert alert-danger'> You Cant'n Acsses In this page</div>";
            redrect($mes, "Dashbord");
        }
    } elseif ($action == 'Edit') {

        // if found id and id is nummber get this

        $IDvideo = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

        // Cheak If The User Found In The Database

        $stam = $con->prepare("SELECT * FROM tbl_video  WHERE ID=? LIMIT 1");
        $stam->execute(array($IDvideo));

        $rowvideo = $stam->fetch();
        $count = $stam->rowCount();


        if ($count > 0) {


            ?>

            <h1 class="text-center">Edit Video</h1>

            <div class="container">
                <form action="?action=update" class="form-horizontal" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?php echo $IDvideo ?>">

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">NameVideo</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $rowvideo["Video_name"] ?>"
                                required />
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Caption</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea name="caption" class="form-control" required><?php echo $rowvideo["caption"] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">VideoCourse</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="file" name="img" class="form-control">
                            <input type="hidden" name="old_img" value="<?php echo $rowitem["Video_src"] ?>">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">UserAdd</label>
                        <div class="col-sm-10 col-md-6">
                            <details class="custom-select">
                                <summary class="radios">
                                    <input type="radio" name="user" id="default" title="....." value="" checked>
                                    <?php
                                    $stam = $con->prepare("SELECT * FROM users");
                                    $stam->execute();
                                    $rows = $stam->fetchAll();

                                    foreach ($rows as $row) {
                                        echo "<input type='radio' name='user' id='$row[ID]' title='$row[Username]' value='$row[ID]' required >";
                                    }
                                    ?>
                                </summary>
                                <ul class="list">

                                    <?php foreach ($rows as $row) {
                                        echo "<li>";
                                        echo "<label for='$row[ID]'>";
                                        echo $row['Username'];
                                        echo "</label>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </details>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">itemcourse</label>
                        <div class="col-sm-10 col-md-6">
                            <details class="custom-select">
                                <summary class="radios">
                                    <input type="radio" name="cat" id="default" title="....." value="" checked>
                                    <?php
                                    $stam = $con->prepare("SELECT * FROM itemcourse");
                                    $stam->execute();
                                    $rows = $stam->fetchAll();

                                    foreach ($rows as $row) {

                                        echo "<input type='radio' name='cat' id='$row[ID]' title='$row[name_item]' value='$row[ID]'  checked required >";
                                    }
                                    ?>
                                </summary>
                                <ul class="list">

                                    <?php foreach ($rows as $row) {
                                        echo "<li>";
                                        echo "<label for='$row[ID]'>";
                                        echo $row['name_item'];
                                        echo "</label>";
                                        echo "</li>";
                                    } ?>
                                </ul>
                            </details>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10 col-md-6">
                            <input type="submit" name="submit" value="Sign" class="btn btn-primary btn-lg">
                        </div>
                    </div>

                </form>
            </div>


            <?php
            // if not fouud this id
        } else {
            $mes = "<div class='alert alert-warning'> Can't Found This ID</div>";
            redrect($mes, "Dashbord");
        }
    } elseif ($action == 'update') { // if get user from update click



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $videoName = $_FILES['img']['name'];
            $videoType = $_FILES['img']['type'];
            $videoTmp = $_FILES['img']['tmp_name'];
            $videoSize = $_FILES['img']['size'];

            $allwoed_type = array("mp4", "mov", "avi", "flv", "wmv");
            $get_type_video = explode(".", $videoName);
            $type_video = strtolower(end($get_type_video));


            $idname = $_POST['id'];
            $name = $_POST['name'];
            $caption = $_POST['caption'];
            $userAdd = $_POST['user'];
            $coursename = $_POST['cat'];


            $formErrors = array();

            if (!empty($videoName)) {

                // if ($imgSize > 4194304) {

                //     $formErrors[] = "This Img Is Too Big";

                // }

                if (!in_array($type_img, $allwoed_type)) {

                    $formErrors[] = "This Type Is Not Allwoed";

                }

            }

            if (empty($name)) {

                $formErrors[] = "Can't Be NameCourse Empty";
            }
            if (empty($caption)) {
                $formErrors[] = "Can't Be Caption Empty";
            }

            if (empty($userAdd)) {
                $formErrors[] = "Can't Levea The UserAdd Empty";

            }
            if (empty($coursename)) {
                $formErrors[] = "Can't Levea The Catagory Empty";

            }

            // cheak if found any errors in array

            if (empty($formErrors)) {

                // cheak if no found uniqe name
                if (empty($videoName)) {
                    $rand_name = $_POST["old_img"];
                } else {

                    $rand_name = rand(0, 1000000000) . '_' . $videoName;

                    move_uploaded_file($videoTmp, "uploded\\video-uploded\\" . $rand_name);
                }


                $stam = $con->prepare("UPDATE tbl_video SET Video_name = ? ,caption = ? , Video_src= ? ,course_id =?,member_add =? WHERE ID = ?");
                $stam->execute(array($name, $caption, $rand_name, $coursename, $userAdd, $idname));
                $count = $stam->rowCount();

                if ($count > 0) {
                    $mes = "<div class='alert alert-success'> The Data Updates</div>";
                    redrect($mes, "Update Course", 2, "video.php?action=Edit&ID=$idname");

                } else {
                    $mes = "<div class='alert alert-warning'>NoUpdate</div>";
                    redrect($mes, "Update Course", 2, "video.php?action=Edit&ID=$idname");
                }


            } else {

                foreach ($formErrors as $error) {
                    echo "<div class='container'>";

                    echo "<div class='alert alert-warning'>$error</div>";
                    echo "</div>";

                    header("refresh:2;url=items.php?action=Edit&ID=$idname");
                }

            }


        } else {
            $mes = "<div class='alert alert-danger'>You Can't Acsees In This Page</div>";
            redrect($mes, "Dashbord");

        }

    } elseif ($action == 'delet') {
        $IDcourse = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;


        $stam = $con->prepare("SELECT * FROM tbl_video WHERE ID=? LIMIT 1");

        $stam->execute(array($IDcourse));
        $row_del = $stam->fetch();


        $row = $stam->rowCount();

        if ($row > 0) {

            $filePath = "$_SERVER[DOCUMENT_ROOT]\work\admin\uploded\\video-uploded\\$row_del[Video_src]";

            if (file_exists($filePath)) {
                // Proceed with deletion if file exists
                unlink($filePath);
            } else {
                // Handle the scenario where the file doesn't exist
                echo "Error: File not found at " . $filePath;
            }

            $stam = $con->prepare("DELETE FROM tbl_video  WHERE ID = :did ");
            $stam->bindparam("did", $IDcourse);
            $stam->execute();
            $mes = "<div class='alert alert-danger'> The Video Is Deleted</div>";
            redrect($mes, "courses", 2, "video.php");


        }




    }
} else {
    header('Location:index.php');
    exit();
}
include $ft . "footer.php";
?>