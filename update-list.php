<?php 
    include("config/constants.php");

    //Get current values of seleted list
    if(isset($_GET['list_id'])){
        $list_id = $_GET['list_id'];

        //connet to the database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

        $db_select = mysqli_select_db($conn, DB_NAME);

        //query to het the values 
        $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

        //Execute Query
        $res = mysqli_query($conn, $sql);

        //Check query executed
        if($res == true){
            //Value is in array
            $row = mysqli_fetch_assoc($res);
           // print_r($row);

           //Create invidual var to save th data
           $list_name = $row['list_name'];
           $list_description = $row['list_description'];

            
        }else{
            header('location:'.SITEURL.'manage-list.php');
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task manager</title>
</head>
<body>
    
    <h1>TASK MANAGER</h1>

    <div class="menu">
        <a href="<?php echo SITEURL;?>">Home</a>
        <a href="<?php echo SITEURL;?>manage-list.php">Manage Lists</a>
    </div>

    <h3>Update list page</h3>

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
                <td>List name: </td>
                <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" require="required"></td>
            </tr>

            <tr>
                <td>List Description</td>
                <td><textarea name="list_description">
                <?php echo $list_description; ?>
                </textarea>
            </td>
            </tr>

            <tr>
                <td><input type="submit" name="submit" value="UPDATE"></td>
            </tr>

        </table>

    </form>

</body>
</html>


<?php 

//Check if the update is cliked
    if(isset($_POST['submit'])){
        //Get the updated values form Form
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD);

        $db_select2 = mysqli_select_db($conn2, DB_NAME);

        //sql query
       echo $sql2 = "UPDATE tbl_lists SET
        list_name = '$list_name',
        list_description = '$list_description'
        WHERE list_id=$list_id
        ";

        //execute query

        $res2 = mysqli_query($conn2, $sql2);

        if($res2 =  true){
            $_SESSION['update'] = "List Updated Successfully";
            header('location:'.SITEURL.'manage-list.php');
        }else{
            //Fail msg
            $_SESSION['update_fail'] = "Fail to Update List";
            header('location:'.SITEURL.'update-list.php?list_id='.$list_id);
        }
    }

?>