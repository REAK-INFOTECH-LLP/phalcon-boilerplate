<style>
    .card {
        width: 80%;
        height: 90%;

    }
</style>


<div class="conatiner">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center"> </h2>
            <div class="card mt-5 ml-5">
                <h4 class="card-header text-center">Registration Form<h4>
                <div class="card-body">
                    <div class="form-group ">
                        <input type="text" class="form-control" name="email" id="usr" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="pwd" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <select name="type" class="form-control" id="">
                            <option value="guest">Guest</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                            <button type="button" class="btn btn-outline-success">Submit</button>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

</div>