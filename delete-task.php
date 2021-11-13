<?php 

    include('config/constants.php');

    //check task_id url
    if(isset($_GET['task_id'])){
        //Delete the task form database
        //Get the task ID
        $task_id = $_GET['task_id'];

        //connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));

        //select database
        $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn));

        //sql query
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id"; 

        //execute query
        $res = mysqli_query($conn,$sql);

        if($res){
            //query executed successfully
            $_SESSION['delete'] = "Task deleted Successfully.";
            header('location:'.SITEURL);

        }else{
            //faild to delete
            $_SESSION['delete_fail'] = "Failed to Delete Task";
            header('location:'.SITEURL);
        }



    }else{
        //Redirect to Home
        header('location:'.SITEURL);
    }

?>