<?php
// session_start();
include('security.php');

if(isset($_POST['save_property']))
{
    $name = $_POST['property_name'];
    $fdtype = $_POST['property_type_name'];
    $description = $_POST['property_description'];
    $images = $_FILES["property_image"]['name'];

    if(file_exists("upload/".$_FILES["property_image"]["name"]))
    {
        $store = $_FILES["property_image"]["name"];
        $_SESSION['status']= "Image already exists. '.$store.'";
        header('Location: property.php');
    }

    else
    {

        $query = "INSERT INTO property (`name`,`property_type`,`description`,`images`) VALUES ('$name','$fdtype','$description','$images')";
        $query_run = mysqli_query($connection, $query);

        if($query_run)
        {
            move_uploaded_file($_FILES["property_image"]["tmp_name"], "upload/".$_FILES["property_image"]["name"]);
            $_SESSION['success'] = "property Added";
            header("Location: property.php");
        }
        else
        {
            $_SESSION['success'] = "property Not Added";
            header("Location: property.php");

        }

    }
    

}


//* Delete page*//
if(isset($_POST['delete_property_btn']))
{
    $id = $_POST['delete_property_id'];

    $query = "DELETE FROM property WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "property Data is Deleted";
       // $_SESSION['status_code'] = "success";
        header('Location: property.php'); 
    }
    else
    {
        $_SESSION['status'] = "property Data is NOT DELETED";       
        //$_SESSION['status_code'] = "error";
        header('Location: property.php'); 
    }    
}


//* property Update btn*//
if(isset($_POST['update_property_btn']))

{   
    print_r($_FILES);
    print_r($_POST);
    $edit_id = $_POST['edit_id'];
    $edit_name = $_POST['edit_name'];
    $edit_property_type = $_POST['edit_property_type'];
    $edit_description = $_POST['edit_description'];
    $edit_image = $_FILES["edit_image"]['name'];

    $property_quary = "SELECT * FROM property WHERE id='$edit_id'"; 
    $property_query_run = mysqli_query($connection, $property_quary);
    foreach($property_query_run as $fa_row)
    {
        // echo $fa_row['images'];
        if($edit_image == NULL)
        {
            //Update with existing Image
            $image_data = $fa_row['images'];
        }
        else
        {
            //Update with new image  and delete with old image
           $img_path = "upload/".$fa_row['images'];
           if(file_exists($img_path)){
            unlink($img_path);
            $image_data = $edit_image;
           }
            
        }
    }

    
    $query = "UPDATE property SET name='$edit_name', property_type='$edit_property_type', description='$edit_description',images='$edit_image' WHERE id='$edit_id '";
    $query_run = mysqli_query($connection, $query);
    print_r($_POST);
    print_r($query_run);

    if($query_run)
        {
            if($edit_image == NULL)
            {
                //Update with existing Image
                $_SESSION['success'] = "property  Updated existing Image";
                header("Location: property.php"); 
            }
            else
            {
                //Update with new image  and delete with old image
                move_uploaded_file($_FILES["edit_image"]["tmp_name"], "upload/".$_FILES["edit_image"]["name"]);
                $_SESSION['success'] = "property Data is Updated";
                header("Location: property.php"); 
            }
            }
           
        else
        {
            $_SESSION['status'] = "property Not Updated ";
            header("Location: property.php");   
        }
}






















if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    $email_query = "SELECT * FROM register WHERE email='$email' ";
    $email_query_run = mysqli_query($connection, $email_query);


    if(mysqli_num_rows($email_query_run) > 0)
    {
        $_SESSION['status'] = "Email Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header('Location: register.php');  
    }
    else
    {
        if($password === $cpassword)
        {
            $query = "INSERT INTO register (username,email,password) VALUES ('$username','$email','$password')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['success'] = "Admin Profile Added";
               // $_SESSION['status_code'] = "success";
                header('Location: register.php');
            }
            else 
            {
                $_SESSION['status'] = "Admin Profile Not Added";
                //$_SESSION['status_code'] = "error";
                header('Location: register.php');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
           // $_SESSION['status_code'] = "warning";
            header('Location: register.php');  
        }
    }

}




//* Update page*//
if(isset($_POST['update_btn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];

    $query = "UPDATE register SET username='$username', email='$email', password='$password' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your Data is Updated";
        //$_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        //$_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }
}



//* Delete page*//
if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM register WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['success'] = "Your Data is Deleted";
       // $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        //$_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }    
}



//*Login page*//
if(isset($_POST['login_btn']))
{
    $email_login = $_POST['email']; 
    $password_login = $_POST['password']; 

    $query = "SELECT * FROM register WHERE email='$email_login' AND password='$password_login' ";
    $query_run = mysqli_query($connection, $query);

   if(mysqli_fetch_array($query_run))
   {
        $_SESSION['username'] = $email_login;
        header('Location: index.php');
   } 
   else
   {
        $_SESSION['status'] = "Email / Password is Invalid";
        header('Location: login.php');
   }
    
}



?> 