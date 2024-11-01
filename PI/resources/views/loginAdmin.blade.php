<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Document</title>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('images/logoPi.jpg')}}" class="img-fluid" alt="Logo">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 border">
                    <form>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h1 class=" mb-3  mt-3 me-3">Inicia sesión como administrador</h1>

                        </div>

                        <div class="divider d-flex align-items-center my-4">
                        </div>


                        <!-- Correo -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="correoAdm">Correo Eléctronico</label>
                            <input type="email" name="correoAdm" class="form-control form-control-lg"
                                placeholder="Ingresa un correo" />
                        </div>

                        <!--Contraseña -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="pwdAdm">Contraseña</label>
                            <input type="password" name="pwdAdm" class="form-control form-control-lg"
                                placeholder="Ingresa tu contraseña" />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2 mb-3">
                            <button type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Continuar</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">¿No tienes una cuenta? <a href="#!"
                                    class="link-danger">Volver al inicio</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>