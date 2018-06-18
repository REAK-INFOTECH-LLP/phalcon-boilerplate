<?php include 'includes/header.php'?>

<div class="conatiner"></div>
<div class="row">
    <div class="col-md-4"></div>

    <div class="col-md-4">
        <div class="card mt-5">
        <div class="alert alert-dismissible alert-success" style="display:none" id="error">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Well done!</strong> You successfully read <a href="#" class="alert-link">this important alert message</a>.
        </div>
            <div class="card-body">
                <h4 class=" card-header card-title text-center">Log In</h4>
                <p class="card-text">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" onkeyup="validateEmail()" >
                    </div>
                    <div class="form-group">
                        <label for=""></label>
                        <input type="password" class="form-control" name="password" id="password"  placeholder="Password" required>

                    </div>
                </p>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="button" class="btn btn-outline-success">Submit</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            </div>
                            <a href="forget_password.php">Forgot Password ? </a>
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



//  function validate(){
//     var password = document.getElementById("email").value;
//     var confirmPassword = document.getElementById("password").value;
//     if (email != password) {
//         document.getElementById('error').style.display = 'block'
//         document.getElementById('error').innerHTML = 'Email and Password are not matched'

//     }else{
//         document.getElementById('error')innerHTMl =  'Email and Password are matched'
//     }
//     return ;
// }


function validateEmail() {
    var email = document.getElementById("email").value;
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (reg.test(email.value) == false) 
        
        
}
</script>