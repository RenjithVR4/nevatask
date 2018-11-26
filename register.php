<?php require_once("common/header.php"); ?>


<div class="main-content">
    <!-- Top navbar -->
    <?php require_once("common/nav.php"); ?>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-4 pt-4 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->

            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <div class="row mt-8">
            <div class="col-xl-12 mb-8 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Register User</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-4 justify-content-center">
                    <!-- <p id="message"></p> -->
                        <form id="createuserForm">
                            <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userEmail">Email</label>        
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">                                        
                                        <input type="text" class="form-control form-control-alternative" id="userEmail"
                                            placeholder="Enter email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userPassword">Password</label>        
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">                                        
                                        <input type="password" class="form-control form-control-alternative" id="userPassword"
                                            placeholder="Enter password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm Password</label>        
                                        </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">                                        
                                        <input type="password" class="form-control form-control-alternative" id="confirmPassword"
                                            placeholder="Enter password again">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                        <input type="submit" id="createUser" class="btn btn-primary my-4" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>


        <script src="assets/js/createuser.js"></script>
        <?php require_once("common/footer.php"); ?>