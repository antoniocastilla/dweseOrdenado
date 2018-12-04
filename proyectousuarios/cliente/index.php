<?php

require '../classes/autoload.php';

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Util;

$db = new Database();
$manager = new ManageUsuario($db);
$usuarios = $manager->getAll();
$db->close();

$alert = Alert::getMessage(Reader::get('op'), Reader::get('resultado'));

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>dwes</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css" >
    </head>
    <body>
        <!-- modal -->
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmación de borrado de usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quiere borrar el usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btConfirmDelete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="..">dwes</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="..">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../usuario/">Usuario</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./">Registrarse</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Registro de usuario</h4>
                    <?= $alert ?>
                </div>
            </div>
            <div class="container">
                <form action="doinsert.php" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre del usuario</label>
                        <input required type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduce el nombre del usuario">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electrónico</label>
                        <input required type="email" class="form-control" id="correo" name="correo" placeholder="Introduce el correo del usuario">
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias</label>
                        <input type="text" class="form-control" id="alias" name="alias" placeholder="Introduce el alias del usuario">
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input required type="password" class="form-control" id="clave" name="clave" placeholder="Introduce la clave del usuario">
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input required type="password" class="form-control" id="clave2" name="clave2" placeholder="Repite la clave del usuario">
                    </div>
                    <button type="submit" class="btn btn-primary">Alta</button>
                </form>
            </div>
        </main>
        <footer class="container">
            <p>&copy; IZV 2018</p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../js/script.js"></script>
    </body>
</html>