<div class="conatiner"></div>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card mt-5">
            <div class="alert alert-dismissible alert-danger" style="display:none" id="error">
            </div>
            <div class="card-body">
                <h4 class="card-header text-center">Make New Password</h4>
                <p class="card-text">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="password" class="form-control" name="password" id="new_password" aria-describedby="emailHelpId" placeholder="New Password">

                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="password" class="form-control" name="confirm-password" id="confirm_password" onkeyup="validate()" placeholder="Confirm Password">
                        </div>
                </p>
                <div class="col-md-4"></div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="submit" name="submit" id="submit-btn" class="btn btn-outline-success" disabled>Submit</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function validate() {
        var password = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password != confirmPassword) {
            document.getElementById('error').style.display = 'block';
            document.getElementById('error').innerHTML = "Passwords do not match";
        } else {
            document.getElementById('error').style.display = 'none';
            document.getElementById('submit-btn').disabled = false;
        }
    }
</script>