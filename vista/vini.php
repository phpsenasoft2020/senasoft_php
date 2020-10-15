<?php include ('controlador/cini.php') ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">

                <br>
                <div class="p-5">
                  <div class="text-center">
                    <div class="row">

                      <div class="col-md-12 img-margin">
                        <h1 class="h4 text-gray-900 mb-4 centri">Hola, ¡Bienvenido!</h1>
                        <img src="image/logo.png" class="img-responsive" width="33%">
                      </div>
                    </div>
                    <br>
                  </div>
                  <form method="POST" action="modelo/valida.php" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="Introduce tu correo electrónico..." required="">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Introduce tu contraseña..." required="">
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Iniciar sesión">
                    </a>
                  </form>
                  <hr>
                  <span  style="
                visibility:<?php if(!$errorusuario=="si") echo "hidden"; ?> ">
                <hr>
                  <center class="alert alert-danger">¡ERROR! Confirme sus Credenciales</center>
                </span>
                <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>