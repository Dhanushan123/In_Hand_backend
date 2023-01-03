<?php
include('security.php');

include('includes/header.php'); 
include('includes/navbar.php'); 
?>
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary"> EDIT Property Details </h6>
    </div>
    <div class="card-body">

    <?php
    $connection = mysqli_connect("localhost", "root" , "", "adminpanel");

    if (isset($_POST['edit_btn']))
    {
        $id = $_POST['edit_id'];
    
        $query = "SELECT *FROM property WHERE id= '$id' ";
         $query_run = mysqli_query($connection, $query);
    
               foreach($query_run as $row)
    
    {
        
         ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
                    <div class="form-group">
                            <label>property_name </label>
                            <input type="text" name="edit_name" value="<?php echo $row['name']?>" class="form-control" placeholder="Enter property name">
                        </div>
                        <div class="form-group">
                            <label>property_type</label>
                            <input type="text" name="edit_property_type" value="<?php echo $row['property_type']?>" class="form-control" placeholder="Enter property type">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="edit_description" value="<?php echo $row['description']?>" class="form-control" placeholder="Enter Description">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="edit_image" value="<?php echo $row['images']?>" class="form-control" placeholder="Upload Image">
                        </div>
                        
                            <a href="property.php" class="btn btn-danger"> CANCEL </a>
                            <button type="submit" name="update_property_btn" class="btn btn-primary"> Update </button>

             </form>
        <?php
       }
       
    }

    ?>

    
    </div>
</div>
</div>

</div>
<!-- /.container-fluid -->







<?php
include('includes/scripts.php');
include('includes/footer.php');
?>