<?php
session_start();


$title = "Categories";

// cheak if found session name
if (isset($_SESSION['Admin'])) {

    include "init.php";


    // Cheak if found the action in the title

    $action = isset($_GET['action']) ? $_GET['action'] : 'Categories';

    if ($action == 'Categories') {

        $sort = "ASC";

        $orderBy = array("ASC", "DESC");

        if (isset($_GET['sort']) && in_array($sort, $orderBy)) {

            $sort = $_GET['sort'];
        }

        $stam = $con->prepare("SELECT * FROM catagory ORDER BY NameCatagory $sort");
        $stam->execute();
        $rows = $stam->fetchAll();

        ?>
        <h1 class="text-center">Manage Categories</h1>

        <div class="container cat">
            <div class="panel panel-default">
                <div class="panel-heading head-cat">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Manage Categories
                    <div class="sort pull-right">
                        <i class="fa-solid fa-sort"></i>
                        Ordered By
                        <a href="?sort=ASC" <?php if ($sort == "ASC") {
                            echo "class='active'";
                        } ?>>Asc</a> |
                        <a href="?sort=DESC" <?php if ($sort == "DESC") {
                            echo "class='active'";
                        } ?>>Desc</a>
                        <i class="fa-solid fa-eye"></i>
                        View:
                        <span class="active" data-view="Full">Full</span>
                        <span>Classic</span>


                    </div>
                </div>

                <div>
                    <?php
                    foreach ($rows as $row) {

                        echo "<div class='body-cat'>";
                        echo "<div class='hideen-btn'>";
                        echo "<a href='Categories.php?action=Edit&ID=$row[ID]' class='btn'><i class='glyphicon glyphicon-edit'></i>Edit</a>";
                        echo "<a href='Categories.php?action=delet&ID=$row[ID]' class='btn confirm'><i class='glyphicon glyphicon-remove'></i>Delet</a>";
                        echo "</div>";
                        echo "<h3> $row[NameCatagory] </h3>";
                        echo "<div class='viwe-classic'>";
                        echo "<p> $row[caption] </p>";
                        if ($row['vesplite'] == 1) {
                            echo "<span class='categories-status'>Catagories is Hidden</span>";
                        }
                        if ($row['Ads'] == 1) {
                            echo "<span class='Ads-status'>Ads is  Hidden</span>";
                        }
                        echo "<span class=date> $row[date] </span>";
                        echo "</div>";
                        echo "</div>";
                        echo "<hr>";


                    }

                    ?>
                </div>
            </div>
            <a href="Categories.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i>New Categories</a>

        </div>




    <?php } elseif ($action == 'add') { ?>

        <h1 class="text-center">Add Categories</h1>

        <div class="container">
            <form action="?action=insert" class="form-horizontal" method="POST">

                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" autocomplete="off"
                            placeholder="Type Name The Categories" required />
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label for="thecaption" class="col-sm-2 control-label">Caption</label>
                    <div class="col-sm-10 col-md-6">
                        <textarea id="thecaption" name="Caption" class="form-control" placeholder="Type Caption For The Course"
                            required></textarea>
                    </div>
                </div>
                <div class=" form-group form-group-lg">
                    <label class="col-sm-2 control-label">Order</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="number" name="order" class="form-control" placeholder="Type The Order catagory">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Hide or Show</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input type="radio" id="yes" name="vesplite" value="1">
                            <label for="yes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" id="no" name="vesplite" value="0" checked />
                            <label for="no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input type="radio" id="yes" name="Ads" value="1">
                            <label for="yes">Yes</label>
                        </div>
                        <div>
                            <input type="radio" id="no" name="Ads" value="0" checked />
                            <label for="no">No</label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                        <input type="submit" name="submit" value="Add Catagory" class="btn btn-primary btn-lg">
                    </div>
                </div>

            </form>
        </div>



    <?php } elseif ($action == "insert") {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $name = $_POST['name'];
            $Caption = $_POST['Caption'];
            $order = $_POST['order'];
            $vesplite = $_POST['vesplite'];
            $Ads = $_POST['Ads'];





            // cheak if no found uniqe name

            $cheak = cheakName("NameCatagory", "catagory", $name);

            if ($cheak == 1) {
                $mes = "<div class='alert alert-danger'>Sorry This Name Is Found</div>";
                redrect($mes, "Add Categories", 3, "Categories.php?action=add");

            } else {

                $stam = $con->prepare("INSERT INTO catagory (NameCatagory , caption  , orderCatagoury , vesplite ,Ads) 
                VALUES (:u,:p,:e,:f,:g)");
                $stam->execute(
                    array(
                        ":u" => $name,
                        ":p" => $Caption,
                        ":e" => $order,
                        ":f" => $vesplite,
                        ":g" => $Ads

                    )
                );
                $count = $stam->rowCount();

                if ($count > 0) {

                    $mes = "<div class='alert alert-success'> The Catrgories Addes</div>";
                    redrect($mes, "Dashbord");



                }
            }

        } else {
            $mes = "<div class='alert alert-danger'> Can't you Acse This Page</div>";
            redrect($mes, "Dashbord");

        }

    } elseif ($action == 'delet') {


        $IDuser = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;


        $stam = $con->prepare("SELECT * FROM catagory WHERE ID=? LIMIT 1");

        $stam->execute(array($IDuser));

        $row = $stam->rowCount();

        if ($row > 0) {
            $stam = $con->prepare("DELETE FROM catagory  WHERE ID = :did ");
            $stam->bindparam("did", $IDuser);
            $stam->execute();

            $mes = "<h1 class='text-center alert alert-danger'>This Categories Is Deleted</h1>";

            redrect($mes, "Categouries", 2, "categories.php");

        }




    } elseif ($action == 'Edit') {

        // if found id and id is nummber get this

        $IDuser = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

        // Cheak If The User Found In The Database

        $stam = $con->prepare("SELECT * FROM catagory WHERE ID=? LIMIT 1");
        $stam->execute(array($IDuser));

        $rowmember = $stam->fetch();
        $count = $stam->rowCount();


        if ($count > 0) {


            ?>

            <h1 class="text-center">Edit Categories</h1>

            <div class="container">
                <form action="?action=update" class="form-horizontal" method="POST">

                    <input type="hidden" name="id" value="<?php echo $IDuser ?>">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" autocomplete="off"
                                value="<?php echo $rowmember['NameCatagory'] ?>" />
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="thecaption" class="col-sm-2 control-label">Caption</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea id="thecaption" name="Caption"
                                class="form-control"><?php echo $rowmember['caption'] ?></textarea>
                        </div>
                    </div>
                    <div class=" form-group form-group-lg">
                        <label class="col-sm-2 control-label">Order</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="number" name="order" class="form-control"
                                value="<?php echo $rowmember['orderCatagoury'] ?>" />

                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Hide or Show</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yes" name="vesplite" value="1" <?php if ($rowmember['vesplite'] == 1) {
                                    echo "";
                                } ?>>
                                <label for="yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="no" name="vesplite" value="0" <?php if ($rowmember['vesplite'] == 0) {
                                    echo "checked";
                                } ?> />
                                <label for="no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" id="yes" name="Ads" value="1" <?php if ($rowmember['vesplite'] == 0) {
                                    echo "";
                                } ?>>
                                <label for="yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" id="no" name="Ads" value="0" <?php if ($rowmember['vesplite'] == 0) {
                                    echo "checked";
                                } ?> />
                                <label for="no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10 col-md-6">
                            <input type="submit" name="submit" value="Add Catagory" class="btn btn-primary btn-lg">
                        </div>
                    </div>

                </form>
            </div>


            <?php
            // if not fouud this id
        } else {
            echo "Cant fonnd this ID";
        }
    } elseif ($action == 'update') { // if get user from update click



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idname = $_POST['id'];
            $name = $_POST['name'];
            $Caption = $_POST['Caption'];
            $order = $_POST['order'];
            $vesplite = $_POST['vesplite'];
            $Ads = $_POST['Ads'];





            $stam = $con->prepare("UPDATE catagory SET NameCatagory = ? ,caption = ? , orderCatagoury = ? , vesplite= ? , Ads= ? WHERE ID = ?");
            $stam->execute(array($name, $Caption, $order, $vesplite, $Ads, $idname));
            $count = $stam->rowCount();

            if ($count > 0) {

                $mes = "<div class='alert alert-success'>Your Data Update</div>";
                echo redrect($mes, "Edit", 2, "Categories.php?action=Edit&ID=$idname");

            } else {
                $mes = "<div class='alert alert-warning'> NoUpdate in the page</div>";
                echo redrect($mes, "Edit", 2, "Categories.php?action=Edit&ID=$idname");
            }


        } else {
            $mes = "<div class='alert alert-danger'> Can't you Acse This Page</div>";
            redrect($mes, "Dashbord");

        }


    }

} else {
    header('Location:index.php');
    exit();
}
include $ft . "footer.php";

