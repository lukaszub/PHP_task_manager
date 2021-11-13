<?php 
    include('config/constants.php');
    //Check wheather th list_id assinged or not
    if(isset($_GET['list_id'])){

        //get value 
        $list_id = $_GET['list_id'];

        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
        if(!$conn){
            die("Database not connected.".mysqli_connect_error());
        }

          //Select database
         $db_select = mysqli_select_db($conn,DB_NAME);

        //write the query to DELETE LIST form database
         $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check exexuted query
        if($res == true){
            //Successe
            $_SESSION['delete'] = "List deleted Successfully.";
            header('location:'.SITEURL.'manage-list.php');


        } else {
            //Failer
            $_SESSION['delete_fail'] = "Failed to Delete List.";
            header('location:'.SITEURL.'manage-list.php');
        }

    }else{
        //Redaricet to Mange list page
        header('location:'.SITEURL.'manage-list.php');
    }

    



  



    
?>