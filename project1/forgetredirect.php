<?php include 'includes/header.php'?>
<div class="conatiner"></div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card mt-5">
            <div class="alert alert-dismissible alert-success" style="display:none" id="error">
            </div>
            <div class="card-body">
                <h4 class="card-header text-center">Make New Password</h4>
                <p class="card-text">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="password" class="form-control" name="" id="new_password" aria-describedby="emailHelpId" placeholder="New Password">

                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="password" class="form-control" name="" id="confirm_password" placeholder="Confirm Password">
                        </div>
                </p>
                <div class="col-md-4"></div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="submit" name="submit" class="btn btn-outline-success" onsubmit="validate()">Submit</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


<?php include 'includes/footer.php'?>


<script type="text/javascript">
    function Validate() {
        var password = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password != confirmPassword) {
            document.getElementById('error').style.display = 'block'
            document.getElementById('error').innerHTML = "Password Not matched"
        } else {
            document.getElementById('error').innerHTML = "matched"
        }
        return;
    }
</script>