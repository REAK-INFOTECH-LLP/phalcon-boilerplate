<?php include 'includes/header.php'?>

<div class="conatiner"></div>
<div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">
        <div class="card mt-5">
            <div class="card-body">
                <h4 class=" card-header card-title text-center">Log In</h4>
                <p class="card-text">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="email" class="form-control" name="Email" id="Email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" class="form-control" name="Password" id="Password"  placeholder="Password">

                    </div>
                </p>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="button" class="btn btn-outline-success" onclick="return Validate()">Submit</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            </div>
                            <a href="#">Forgot Password ? </a>
                          </div>
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
<script type="text/javascript">

    var password = document.getElementById("Email").value;
    var confirmPassword = document.getElementById("Password").value;
    if (Email != Password) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}
</script>