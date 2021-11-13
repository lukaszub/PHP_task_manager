<?php 
    include('config/constants.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task manager with PHP and MySql</title>
</head>
<body>
    <h1>TASK MANAGER</h1>

    <a href="<?php echo SITEURL;?>">Home</a>
    <a href="<?php echo SITEURL;?>manage-list.php">Manage Lists</a>

    <h3>Add list Page</h3>

    <p>
        <?php 
            //Check wheather the session is created or not
            if(isset($_SESSION['add_fail'])){
                echo $_SESSION['add_fail'];
                //Remove the message after dispalying once
                unset($_SESSION['add_fail']);
            }
        ?>
    </p>

    <form method="POST" action="">
        <table>
            <tr>
                <td>List name: </td>
                <td><input type="text" name="list_name" placeholder="Type list name here." require="requierd"></td>
            </tr>
            <tr>
                <td>List Description</td>
                <td><textarea name="list_description" id="" cols="30" rows="5" placeholder="Type List Description"></textarea></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Save"></td>
            </tr>
        </table>
    </form>

</body>
</html>

<?php 

    if(isset($_POST['submit'])){

        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

       $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

       if(!$conn){
            die("Database not connected.".mysqli_connect_error());
       }
      // echo "Connected";

       $db_select = mysqli_select_db($conn, DB_NAME);

       /*
       if($db_select){
           echo " Database selected";
       }
       */

       //Sql query to instert data into databese
        $sql = "INSERT INTO tbl_lists SET
            list_name = '$list_name',
            list_description = '$list_description' 
       ";

       //Execute Query and Insert into Database
       $res = mysqli_query($conn,$sql);

       //Check weather the query executed successfully ir not 
       if($res == true){
           //Data inserted succesfully
           //echo "Data Inserted.";

           //create s Sassion varaible to dispaly message
           $_SESSION['add'] = "List Added Successfully";
           //Redirect to Manage List Page
           header('location:'.SITEURL.'manage-list.php');



       } else {
            //echo "Faild to Insert Data.";

            //Creat Session to save message
            $_SESSION['add_fail'] =  "Fails to Add List"; 
            //Redirect to Same Page
            header('location:'.SITEURL.'add-list.php');

       }
        
    }

?>