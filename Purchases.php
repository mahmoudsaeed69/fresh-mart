<?php
session_start();


$title = "Purchases";

// cheak if found session name
if (isset($_SESSION['Admin'])) {

    include "init.php";


    // Cheak if found the action in the title

    $action = isset($_GET['action']) ? $_GET['action'] : 'Purchases';

    if ($action == 'Purchases') {

        $stam = $con->prepare("SELECT users.*,item.name_item
                                            AS item
                                    
                                    FROM users
                                    INNER JOIN item
                                    on item.ID=users.item_sub");
        $stam->execute();
        $rows = $stam->fetchAll();

        ?>
        <h1 class="text-center">Purchases</h1>

        <div class="container">
            <div class="table">
                <table class="main-table text-center table table-bordered">
                    <thead>
                        <tr>
                            <td>NamePurchases</td>
                            <td>Username Buy</td>
                            <td>Email</td>
                            <td>Phone</td>
                            <td>data</td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows as $row) {


                            echo "<tr>";

                            echo "<td> $row[item] </td>";
                            echo "<td> $row[st_fullname] </td>";
                            echo "<td> $row[st_email] </td>";
                            echo "<td> $row[st_phone] </td>";
                            echo "<td> $row[st_date] </td>";
                        

                            echo "</tr>";

                        }
                        ?>
                    </tbody>
                </table>


            </div>
        </div>




   <?php } } else {
    header('Location:index.php');
    exit();
}
include $ft . "footer.php";
?>