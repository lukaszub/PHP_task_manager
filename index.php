<?php 
    include('config/constants.php');
?>
// TASK MANAGER part 6 04:14
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>

<div class="menu">
    <h1>Task Manager</h1>
    <a href="<?php echo SITEURL; ?>">Home</a>

    <?php
        //dispalying list from database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

        //select database
        $db_select = mysqli_select_db($conn2, DB_NAME);

        //sql query
        $sqli2 = "SELECT * FROM tbl_lists";

        //execute query
        $res2 = mysqli_query($conn2, $sqli2);

        //check whether the query executed
        if($res2){
            while($row2= mysqli_fetch_assoc($res2)){
                $list_id = $row2['list_id'];
                $list_name = $row2['list_name'];
                ?>

                <a href="<?php echo SITEURL;?>list-task.php?list_id=<?php echo $list_name;?>"></a>

                <?php
            }
        }


    ?>


    <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
</div>

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

<div class="all-tasks">

<a href="<?php SITEURL ;?>add-task.php">Add task</a>
    <table>
        <tr>
            <th>S.N</th>
            <th>Task Name</th>
            <th>Priority</th>
            <th>Dedline</th>
            <th>Actions</th>
        </tr>

        <?php 

            //connet database
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or dir(mysqli_error($conn));

            //select database
            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
            
            //sql query
            $sql = "SELECT * FROM tbl_tasks";

            //execute query
            $res = mysqli_query($conn, $sql);

            //check query executed
            if($res){
                $count_rows = mysqli_num_rows($res);

                //creat serail number
                $sn = 1;
                //check if there is task on database
                if($count_rows>0){
                    //data in teh database
                    while($row=mysqli_fetch_assoc($res)){
                        $task_name = $row['task_name'];
                        $task_id = $row['task_id'];
                        $priority = $row['priority'];
                        $deadline = $row['deadline'];
                        ?>

                        <tr>
                            <td><?php echo $sn++?></td>
                            <td><?php echo $task_name ?></td>
                            <td><?php echo $priority ?></td>
                            <td><?php echo $deadline ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id;?>">Update</a>   
                                <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                            </td>
                        </tr>


                        <?php

                    }
                }else{
                    //no data in databse
                    ?>
                        <tr>
                            <td colspan="5">No Tasks Added Yet.</td>
                        </tr>
                    <?php

                }

            }




        
        ?>


    </table>
</div>


    
</body>
</html>

