<?php 
    include('config/constants.php');
    //GET LIST ID FROM URL
    $list_id_url = $_GET['list_id'];

?>

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

                <a href="<?php echo SITEURL;?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

                <?php
            }
        }


    ?>


    <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
</div>

<div class="all-task">

        <a href="<?php echo SITEURL;?>add-task.php">Add Task</a>

        <table>

            <tr>
                <th>S.N</th>
                <th>Task Name</th>
                <th> Priority</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>

            <?php 
            
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

            $db_select = mysqli_select_db($conn, DB_NAME);

            //sql query to dispaly task
            $sql = "SELECT * FROM tbl_tasks WHERE list_id = $list_id_url";

            //execute query
            $res = mysqli_query($conn, $sql);

            if($res){

                $count_rows = mysqli_num_rows($res);
                
                if($count_rows>0){
                    //we have task on this list
                    while($row=mysqli_fetch_assoc($res)){
                        $task_id = $row['task_id'];
                        $task_name = $row['task_name'];
                        $priority = $row['priority'];
                        $deadline = $row['deadline'];

                        ?>

                        <tr>
                            <td></td>
                            <td><?php echo $task_name; ?></td>
                            <td> <?php echo $priority; ?></td>
                            <td><?php echo $deadline;  ?></td>
                             <td>
                                <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id;?>">Update</a>   
                                <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                             </td>
                        </tr>


                        <?php
                    }    


                }else{
                    ?>
                        <tr>
                            <td colspan="5">No task added on this list</td>
                        </tr>
                    <?php

                
                }

            }

            
            ?>


  
        </table>

</div>


</body>
</html>