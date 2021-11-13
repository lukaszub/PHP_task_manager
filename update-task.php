<?php 
    include('config/constants.php');

    //check task_id
    if(isset($_GET['task_id'])){
        $task_id = $_GET['task_id'];

        //connet databas
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD);

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME);

        //sql query
        $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

        //execute query
        $res = mysqli_query($conn,$sql);


        if($res){
            //check succesfully
            $row = mysqli_fetch_assoc($res);
            $task_name = $row['task_name'];
            $task_description = $row['task_description'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];

        }else{
          //  header('location:'.SITEURL);
        }
    }else{
        //redirect to home
        header('location:'.SITEURL);
    }

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
    <h1>Task Manager</h1>

    <p>
        <a href="<?php echo SITEURL ?>">Home</a>
    </p>

    <h3>Update Task Page</h3>

    <p>
        <?php 
        
            if(isset($_SESSION['update_fail'])){
                echo $_SESSION['update_fail'];
                unset($_SESSION['update_fail']);

            }


        ?>
    </p>

    <form action="" method="POST">
        <table>
            <tr>
                <td>Task Name</td>
                <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required"></td>
            </tr>

            <tr>
                <td>Task Description: </td>
                <td>
                <textarea name="task_description">
                    <?php echo $task_description; ?>
                </textarea>
                </td>
            </tr>

            <tr>
                <td>Select List: </td>
                <td>
                    <select name="list_id">
                        <?php 
                            //connect database
                            $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);        
                            //select database
                            $db_select2 = mysqli_select_db($conn2, DB_NAME);

                            //SQL query
                            $sql2 = "SELECT * FROM tbl_lists";

                            //execute
                            $res2 = mysqli_query($conn2, $sql2);

                            if($res2){
                                //display the list 
                                //count rows
                                $count_rows2 = mysqli_num_rows($res2);

                                //check if the list is added or not
                                if($count_rows2>0){

                                    //list are added
                                    while($row2 = mysqli_fetch_assoc($res2)){
                                        //get indvidual value
                                        $list_id_db = $row2['list_id'];
                                        $list_name = $row2['list_name'];
                                        ?>
                                         <option <?php if($list_id_db == $list_id) echo "selected='selected'";?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>
                                        <?php

                                    }

                                }else{
                                    // no list added
                                     //Display none
                                     ?>
                                     <option <?php if($list_id=0) echo "selected='selected'"?> value="0">None</option>
                                    <?php
                                }
                            }

                        ?>
                        <option value="1">Doing</option>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Priority:</td>
                <td>
                <select name="priority" id="">
                          <option <?php if($priority == "High") {echo "selected=selected'";} ?> value="High">High</option>
                          <option <?php if($priority == "Medium") {echo "selected=selected'";} ?> value="Medium">Medium</option>
                          <option <?php if($priority == "Low") {echo "selected=selected'";} ?> value="Low">Low</option>
                </select>                      
                </td>
            </tr>

            <tr>
                <td>Deadline:</td>
                <td><input type="date" name="deadline" value="<?php echo $deadline;?>"></td>
            </tr>

            <tr>
                <td><input type="submit" name="submit" value="UPDATE"></td>
            </tr>
        </table>

    </form>


</body>
</html>

<?php 

    //check if button is cliked
    if(isset($_POST['submit'])){
       // echo "Cliked";

       //get values from form
       $task_name = $_POST['task_name'];
       $task_description = $_POST['task_description'];
       $list_id = $_POST['list_id'];
       $priority = $_POST['priority'];
       $deadline = $_POST['deadline'];

       //connect databes
       $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

       //select databes
       $db_select3 = mysqli_select_db($conn3, DB_NAME) or die();

       //sql query
        echo $sql3 = "UPDATE tbl_tasks SET
       task_name = '$task_name',
       task_description = '$task_description',
       list_id = '$list_id',
       priority = '$priority',
       deadline = '$deadline'
       WHERE
       task_id = $task_id";

       //execute query
       $res3 = mysqli_query($conn3, $sql3);

       if($res3){
           //query executed
           $_SESSION['update'] = "Task Updated. ";
           header('location:'.SITEURL);

       } else {
           $_SESSION['update_fail'] = "Failed to update Task. ";
           header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
       }
    
    }                            


?>