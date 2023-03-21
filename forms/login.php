<?php include '../includes/navbar.php'; ?>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 my-3">
                <img src="../images/cover/cover.jpg" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 my-4">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <?php
                        if (isset($_GET['errmsg'])) {
                            echo "<div class='alert alert-danger'>" .
                                $_GET['errmsg'] . "</div>";
                        }
                        if (isset($_GET['sucmsg'])) {
                            echo "<div class='alert alert-success'>" .
                                $_GET['sucmsg'] . "</div>";
                        }
                        ?>
                    </div>
                </div>
                <form method="post" action="../processing/loginProcess.php">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="text" id="form3Example3" class="form-control form-control-lg" name="username" placeholder="Username" required />
                        <label class="form-label" for="form3Example3">Username</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input type="password" id="form3Example4" class="form-control form-control-lg" name="password" placeholder="Mot de Passe" required />
                        <label class="form-label" for="form3Example4">Mot de Passe</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                                Remember me
                            </label>
                        </div>
                        <a href="<?php echo "/beauty_store/processing/" ?>" class="text-body">Mot de Passe oublié?</a>

                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-warning" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>