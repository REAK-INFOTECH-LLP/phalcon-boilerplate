<?php include 'includes/header.php'?>

<div class="conatiner">
    <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <div class="card mt-5">

                <div class="card-body">
                    <h4 class=" card-header card-title text-center">Log In</h4>
                    <form action="" method="post" >
                        <div class="form-group">
                            <label for=""></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>

                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-outline-success" onsubmit="validateEmail()">Submit</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                            </div>
                            <a href="forget_password.php">Forgot Password ? </a>
                        </div>

                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>

        </div>
    </div>
</div>
<div class="col-md-4"></div>
</div>
</div>
<?php include 'includes/footer.php'?>


<!-- java script for eamil validation -->

<script type="text/javascript">
    function validateEmail() {
        var email = document.getElementById("email").value;
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; // regex is a combination of special character and formate used for email validation(An email address has a format of type : An @ sign , a dot between address and domian and At least six characters)
        if (reg.test(email.value) == false) 
        
        
}
</script>