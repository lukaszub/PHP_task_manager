<?php 
include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task manager with PHP and MySQL</title>
</head>
<body>
    <h1>Task Manager</h1>

    <a href="<?php echo SITEURL; ?>">Home</a>
    <h3>Manage Lists Page</h3>

    <p>
        <?php 
        
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['delete_fail'])){
                echo $_SESSION['delete_fail'];
                unset($_SESSION['delete_fail']);
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        
        ?>
    </p>

    <div class="all-list">

    <a href="<?php echo SITEURL; ?>add-list.php">Add List</a>
        <table>
            <tr>
                <th>S.N</th>
                <th>List Name</th>
                <th>Actions</th>
            </tr>

            <?php 
            
                //Connet the database
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

                if(!$conn){
                    die("Database not connected.".mysqli_connect_error());
                }

                $db_select = mysqli_select_db($conn, DB_NAME);

                //Sql query
                $sql = "SELECT * FROM tbl_lists";

                //Execute query
                $res = mysqli_query($conn, $sql);

                // check execution
                if($res == true){
                   //echo "Executed";
                   $count_rows = mysqli_num_rows($res);

                   //Creat serai number ver
                   $sn = 1;

                   
                   //Check weather there is data in database or not
                   if($count_rows > 0){
                       //Displaying data from data base
                       while($row = mysqli_fetch_assoc($res)){
                            $list_id = $row['list_id'];
                            $list_name = $row['list_name'];
                            ?>
                            <tr>
                                <td> <?php echo $sn++."."?></td>
                                <td><?php echo $list_name ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id ?>">Update</a>
                                    <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                                </td>
                            </tr>
                            <tr>                            

                            <?php

                       } 
                   } else {
                       //No data in Database
                    ?>

                    <tr>
                        <td colspan="3">No list Added Yet.</td>
                    </tr>

                    <?php
                   }
                   
                }

            ?>  
        </table> 
    </div>
   
</body>
</html>