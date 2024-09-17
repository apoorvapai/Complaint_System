<?php
session_start();
include('include/config.php');
error_reporting(0);
if(strlen($_SESSION['id'])==0)
{   
    header('location:index.php');
}
else
{
    date_default_timezone_set('Asia/Kolkata');// change according timezone
    $currentTime = date( 'd-m-Y h:i:s A', time () );

    if(isset($_POST['submit']))
    {
        $uid=$_SESSION['id'];
        $category=$_POST['category'];
        $staffno=$_POST['staffno'];
        $dept=$_POST['dept'];
        $iphno=$_POST['iphno'];
        $complaintdetials=$_POST['complaindetails'];

        $query=mysqli_query($con,"insert into tblcomplaints(userId,category,staffno,dept,iphno,complaintDetails) values('$uid','$category','$staffno','$dept','$iphno','$complaintdetials')");
        // code for show complaint number
        $sql=mysqli_query($con,"select complaintNumber from tblcomplaints  order by complaintNumber desc limit 1");
        while($row=mysqli_fetch_array($sql))
        {
            $cmpn=$row['complaintNumber'];
        }
        $complainno=$cmpn;
        echo '<script> alert("Your complain has been successfully filled and your complaintno is  "+"'.$complainno.'")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CMS||Register Complaint</title>
    <!-- vendor css -->
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <script>
        function getCat(val) {
            $.ajax({
                type: "POST",
                url: "getsubcat.php",
                data:'catid='+val,
                success: function(data){
                    $("#subcategory").html(data);
                }
            });
        }
    </script> 
</head>

<body class="">
    <?php include('include/sidebar.php');?>
    <?php include('include/header.php');?>

    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Register Complaint</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="register-complaint.php">Register Complaint</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Register Complaint</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <br />
                                    <form method="post" name="complaint">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Category Name</label>
                                            <select name="category" id="category" class="form-control" onChange="getCat(this.value);" required="">
                                                <option value="">Select Category</option>
                                                <?php 
                                                $sql=mysqli_query($con,"select id,categoryName from category ");
                                                while ($rw=mysqli_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo htmlentities($rw['id']);?>"><?php echo htmlentities($rw['categoryName']);?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="staffno">Staff Number</label>
                                            <input type="text" name="staffno" required="required" value="" required="" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="dept">Department</label>
                                            <input type="text" name="dept" required="required" value="" required="" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="iphno">Internal Phone Number</label>
                                            <input type="text" name="iphno" required="required" value="" required="" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Complaint Details (max 2000 words)</label>
                                            <textarea  name="complaindetails" required="required" cols="10" rows="10" class="form-control" maxlength="2000"></textarea>
                                        </div>
                                        <button type="submit" class="btn  btn-primary" name="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Required Js -->
    <script src="../admin/assets/js/vendor-all.min.js"></script>
    <script src="../admin/assets/js/plugins/bootstrap.min.js"></script>
</body>

</html>
