<?php 

    include('config/constants.php');

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
    <h1>TASK MANAGER</h1>
    <a href="<?php echo SITEURL;?>">Home</a>

    <h3>Add Task Page</h3>

    <p>
        <?php 
            if(isset($_SESSION['fail'])){
                echo $_SESSION['fail'];
                unset($_SESSION['fail']);
            }
        ?>
    </p>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Task Name</td>
                <td><input type="text" name="task_name" placeholder="Typr ypur Task Name" require="required"></td>
            </tr>

            <tr>
                <td>Task Description: </td>
                <td><textarea name="task_description" placeholder="Type Task Description"></textarea></td>
            </tr>

            <tr>
                <td>Select List: </td>
                <td>
                    <select name="list_id" >
                        <?php 
                            //connect database
                            $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD);

                            //Select database
                            $db_select = mysqli_select_db($conn, DB_NAME);

                            //sql query
                            $sql = "SELECT * FROM tbl_lists";

                            //Execute Query
                            $res = mysqli_query($conn,$sql);

                            //check execution
                            if($res == true){
                                //Creat var
                                $count_rows = mysqli_num_rows($res);

                                //display dropdown
                                if($count_rows > 0){
                                    
                                    while($row=mysqli_fetch_assoc($res)){
                                        $list_id = $row['list_id'];
                                        $list_name = $row['list_name'];
                                        ?>
                                         <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                                        <?php
                                    }            
                                }else{
                                    //Display none
                                    ?>
                                        <option value="0">None</option>
                                    <?php

                                }
                            }
                        ?>
                       
                    </select>
                </td>
            </tr>

            <tr>
                <td>Prority: </td>
                <td>
                      <select name="priority" id="">
                          <option value="High">High</option>
                          <option value="Medium">Medium</option>
                          <option value="Low">Low</option>
                      </select>  
                </td>
            </tr>

            <tr>
                <td>Deadline: </td>
                <td><input type="date" name="deadline"></td>
            </tr>

            <tr>
                <td><input type="submit" name="submit" value="Save"></td>
            </tr>
        </table>
    </form>
    
</body>
</html>

<?php 

    //check whether the save button is cliked
    if(isset($_POST['submit'])){
        //get all values from the form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        //Connect Databese
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
        
        //Select database
        $db_select2 = mysqli_select_db($conn2,DB_NAME);

        //SQL query
        $sql2 = "INSERT INTO tbl_tasks SET
        task_name = '$task_name',
        task_description = '$task_description',
        list_id = '$list_id',
        priority = '$priority',
        deadline = '$deadline'
        ";

        //Execute query
        $res2 = mysqli_query($conn2, $sql2) or die(mysqli_error($conn2));

        

        if($res2 == true){
            //Success
            $_SESSION['add'] = "Task Added Succesfully.";
            header('location:'.SITEURL);
        }else{
            //Fail
            $_SESSION['fail'] = "Failed to add Task.";
            header('location:'.SITEURL.'add-task.php');
        }


    }                            

?>