<?php
session_start();


$title = "Items";

// cheak if found session name
if (isset($_SESSION['Admin'])) {

    include "init.php";


    // Cheak if found the action in the title

    $action = isset($_GET['action']) ? $_GET['action'] : 'items';

    if ($action == 'items') {

        $stam = $con->prepare("SELECT item.*,catagory.NameCatagory,admins.Username 
                                AS Admin_add 
                                FROM item
                                INNER JOIN catagory
                                ON catagory.ID = item.cat_id 
                                INNER JOIN admins
                                ON admins.ID=item.member_id;");
        $stam->execute();
        $rows = $stam->fetchAll();

        ?>
        <h1 class="text-center">Manage items</h1>

        <div class="container">
            <div class="table">
                <table class="main-table text-center table table-bordered table-items">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nameitem</td>
                            <td>Caption</td>
                            <td>Price</td>
                            <td>imgitem</td>
                            <td>CatagouryName</td>
                            <td>UserAdd</td>
                            <td>Date</td>
                            <td>Control</td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {


                            echo "<tr class='tr-item'>";

                            echo "<td> $row[ID] </td>";
                            echo "<td> $row[name_item] </td>";
                            echo "<td> $row[caption] </td>";
                            echo "<td> $row[price] </td>";
                            echo "<td> <img class='img_item' src='uploded/img-uploded/$row[cat_img]'></img>   </td>";
                            echo "<td> $row[NameCatagory] </td>";
                            echo "<td> $row[Admin_add] </td>";
                            echo "<td> $row[date] </td>";

                            echo "<td>";
                            echo "<a href='items.php?action=Edit&ID=$row[ID]' class='btn btn-success'><i class='fa-regular fa-pen-to-square'></i>Edit</a>";
                            echo "<a href='items.php?action=delet&ID=$row[ID]' class='btn btn-danger confirm'><i class='fa-solid fa-xmark'></i>Remove</a>";
                            echo "</td>";

                            echo "</tr>";

                        }
                        ?>
                    </tbody>
                </table>
                <a href="items.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i>New item</a>

            </div>
        </div>

    <?php } elseif ($action == 'add') {


        ?>

        <h1 class="text-center">Add item</h1>
        <div class="container">
            <form action="?action=insert" class="form-horizontal" method="POST" enctype="multipart/form-data">

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Nameitem</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Type Name The item" required />
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Caption</label>
                    <div class="col-sm-10 col-md-6">
                        <textarea name="caption" class="form-control" placeholder="Type The Script For item"
                            required></textarea>
                    </div>
                </div>
                <div class=" form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" placeholder="Type Price For item"
                            required="required">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">imgitem</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="file" name="img" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">UserAdd</label>
                    <div class="col-sm-10 col-md-6">
                        <details class="custom-select">
                            <summary class="radios">
                                <input type="radio" name="user" id="default" title="....." value="" checked>
                                <?php
                                $stam = $con->prepare("SELECT * FROM admins");
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
                    <label class="col-sm-2 control-label">CatagouryName</label>
                    <div class="col-sm-10 col-md-6">
                        <details class="custom-select">
                            <summary class="radios">
                                <input type="radio" name="cat" id="default" title="....." value="" checked>
                                <?php
                                $stam = $con->prepare("SELECT * FROM catagory");
                                $stam->execute();
                                $rows = $stam->fetchAll();

                                foreach ($rows as $row) {
                                    echo "<input type='radio' name='cat' id='$row[ID]+1' title='$row[NameCatagory]' value='$row[ID]' required>";
                                }
                                ?>
                            </summary>
                            <ul class="list">

                                <?php foreach ($rows as $row) {
                                    echo "<li>";
                                    echo "<label for='$row[ID]+1'>";
                                    echo $row['NameCatagory'];
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



    <?php } elseif ($action == "insert") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $imgName = $_FILES['img']['name'];
            $imgType = $_FILES['img']['type'];
            $imgTmp = $_FILES['img']['tmp_name'];
            $imgSize = $_FILES['img']['size'];

            $allwoed_type = array("jpg", "gif", "jpeg", "png");
            $get_type_img = explode(".", $imgName);
            $type_img = strtolower(end($get_type_img));

            $name = $_POST['name'];
            $caption = $_POST['caption'];
            $price = $_POST['price'];
            $userAdd = $_POST['user'];
            $catname = $_POST['cat'];



            $formErrors = array();
            if (empty($imgName)) {

                $formErrors[] = "No File Uploded";

            }

            if ($imgSize > 4194304) {

                $formErrors[] = "This Img Is Too Big";

            }

            if (!in_array($type_img, $allwoed_type)) {

                $formErrors[] = "This Type Is Not Allwoed";

            }

            if (empty($name)) {

                $formErrors[] = "Can't Be Nameitem Empty";
            }
            if (empty($caption)) {
                $formErrors[] = "Can't Be Caption Empty";
            }
            if (empty($price)) {
                $formErrors[] = "Can't Be Price Empty";
            }

            if (empty($userAdd)) {
                $formErrors[] = "Can't Levea The UserAdd Empty";

            }
            if (empty($catname)) {
                $formErrors[] = "Can't Levea The Catagory Empty";

            }

            // cheak if found any errors in array

            if (empty($formErrors)) {

                // cheak if no found uniqe name
                $rand_name = rand(0, 1000000000) . '_' . $imgName;

                move_uploaded_file($imgTmp, "uploded\img-uploded\\" . $rand_name);

                $cheak = cheakName("name_item", "item", $name);

                if ($cheak == 1) {

                    // generating new name to uploded the img to server 


                    $mes = "<div class='alert alert-danger'> Soory This Name Is Found</div>";
                    redrect($mes, "Add item", 2, "items.php?action=add");
                } else {
                    $stam = $con->prepare("INSERT INTO item (name_item, caption , price , cat_img ,cat_id,member_id ) 
                                                                VALUES (:n_item, :cap, :p, :img_item, :c_id, :mem_id)");
                    $stam->execute(
                        array(
                            ":n_item" => $name,
                            ":cap" => $caption,
                            ":p" => $price,
                            ":img_item" => $rand_name,
                            ":c_id" => $catname,
                            ":mem_id" => $userAdd

                        )
                    );
                    $count = $stam->rowCount();

                    if ($count > 0) {
                        $mes = "<div class='alert alert-success'> The Member Is Addes</div>";
                        redrect($mes, "Items", 2, "items.php");


                    }
                }

            } else {
                foreach ($formErrors as $error) {
                    echo "<div class='container'>";

                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                    header("refresh:2 ; url=items.php?action=add");
                    echo "</div>";


                }
            }


        } else {
            $mes = "<div class='alert alert-danger'> You Cant'n Acsses In this page</div>";
            redrect($mes, "Dashbord");
        }
    } elseif ($action == 'Edit') {

        // if found id and id is nummber get this

        $IDuser = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

        // Cheak If The User Found In The Database

        $stam = $con->prepare("SELECT * FROM item  WHERE ID=? LIMIT 1");
        $stam->execute(array($IDuser));

        $rowitem = $stam->fetch();
        $count = $stam->rowCount();


        if ($count > 0) {


            ?>

            <h1 class="text-center">Edit item</h1>

            <div class="container">
                <form action="?action=update" class="form-horizontal" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?php echo $IDuser ?>">

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Nameitem</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" value="<?php echo $rowitem["name_item"] ?>"
                                required />
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Caption</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea name="caption" class="form-control" required><?php echo $rowitem["caption"] ?></textarea>
                        </div>
                    </div>
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" class="form-control" value="<?php echo $rowitem["price"] ?>" required>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">imgitem</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="file" name="img" class="form-control">
                            <input type="hidden" name="old_img" value="<?php echo $rowitem["cat_img"] ?>">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">UserUpdate</label>
                        <div class="col-sm-10 col-md-6">
                            <details class="custom-select">
                                <summary class="radios">
                                    <input type="radio" name="user" id="default" title="....." value="" checked>
                                    <?php
                                    $stam = $con->prepare("SELECT * FROM admins");
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
                        <label class="col-sm-2 control-label">CatagouryName</label>
                        <div class="col-sm-10 col-md-6">
                            <details class="custom-select">
                                <summary class="radios">
                                    <input type="radio" name="cat" id="default" title="....." value="" checked>
                                    <?php
                                    $stam = $con->prepare("SELECT * FROM catagory");
                                    $stam->execute();
                                    $rows = $stam->fetchAll();

                                    foreach ($rows as $row) {
                                        echo "<input type='radio' name='cat' id='$row[ID]' title='$row[NameCatagory]' value='$row[ID]' required>";
                                    }
                                    ?>
                                </summary>
                                <ul class="list">

                                    <?php foreach ($rows as $row) {
                                        echo "<li>";
                                        echo "<label for='$row[ID]'>";
                                        echo $row['NameCatagory'];
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


            $imgName = $_FILES['img']['name'];
            $imgType = $_FILES['img']['type'];
            $imgTmp = $_FILES['img']['tmp_name'];
            $imgSize = $_FILES['img']['size'];

            $allwoed_type = array("jpg", "gif", "jpeg", "png");
            $get_type_img = explode(".", $imgName);
            $type_img = strtolower(end($get_type_img));


            $idname = $_POST['id'];
            $name = $_POST['name'];
            $caption = $_POST['caption'];
            $price = $_POST['price'];
            $userAdd = $_POST['user'];
            $catname = $_POST['cat'];


            $formErrors = array();

            if (!empty($imgName)) {

                if ($imgSize > 4194304) {

                    $formErrors[] = "This Img Is Too Big";

                }

                if (!in_array($type_img, $allwoed_type)) {

                    $formErrors[] = "This Type Is Not Allwoed";

                }

            }

            if (empty($name)) {

                $formErrors[] = "Can't Be Nameitem Empty";
            }
            if (empty($caption)) {
                $formErrors[] = "Can't Be Caption Empty";
            }
            if (empty($price)) {
                $formErrors[] = "Can't Be Price Empty";
            }

            if (empty($userAdd)) {
                $formErrors[] = "Can't Levea The UserAdd Empty";

            }
            if (empty($catname)) {
                $formErrors[] = "Can't Levea The Catagory Empty";

            }

            // cheak if found any errors in array

            if (empty($formErrors)) {

                // cheak if no found uniqe name
                if (empty($imgName)) {
                    $rand_name = $_POST["old_img"];
                } else {

                    $rand_name = rand(0, 1000000000) . '_' . $imgName;

                    move_uploaded_file($imgTmp, "uploded\img-uploded\\" . $rand_name);
                }

                // item (name_item, caption , price , cat_img ,cat_id,member_id 

                $stam = $con->prepare("UPDATE item SET name_item = ? ,caption = ? , price = ? , cat_img= ? ,cat_id=?,member_id=? WHERE ID = ?");
                $stam->execute(array($name, $caption, $price, $rand_name, $catname, $userAdd, $idname));
                $count = $stam->rowCount();

                if ($count > 0) {
                    $mes = "<div class='alert alert-success'> The Data Updates</div>";
                    redrect($mes, "Update item", 2, "items.php?action=Edit&ID=$idname");

                } else {
                    $mes = "<div class='alert alert-warning'>NoUpdate</div>";
                    redrect($mes, "Update item", 2, "items.php?action=Edit&ID=$idname");
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
        $IDitem = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;


        $stam = $con->prepare("SELECT * FROM item WHERE ID=? LIMIT 1");

        $stam->execute(array($IDitem));

        $row = $stam->rowCount();

        if ($row > 0) {
            $stam = $con->prepare("DELETE FROM item  WHERE ID = :did ");
            $stam->bindparam("did", $IDitem);
            $stam->execute();
            $mes = "<div class='alert alert-danger'> The item Is Deleted</div>";
            redrect($mes, "items", 2, "items.php");


        }




    }

} else {
    header('Location:index.php');
    exit();
}

include $ft . "footer.php";
?>