<?php

require '../classes/autoload.php';
require_once('../classes/vendor/autoload.php');

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Util;
use izv\tools\Session;
use izv\app\App;

// Cargamos las plantillas
// Cargamos el Cargador
$loader = new \Twig_Loader_Filesystem('../plantillas');
$twig = new \Twig_Environment($loader);

// Sesion
$sesion = new Session(App::SESSION_NAME);
if(!$sesion->isLogged()) {
    $url = Util::url() . '../index.php?op=login&resultado=' . $resultado;
    header('Location: ' . $url);
    exit();
}

$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

if ($sesion->getLogin()->getActivo() == 0) {
    header('Location: ' . 'dologout.php?op=' . $op . '&resultado=' . $resultado);
    exit();
}
$usuario = $sesion->getLogin();


// Sacar usuarios
$db = new Database();
$manager = new ManageUsuario($db);

$listaUsuarios = $manager->getAll();

$data = array ('title' => 'Users',
                'logged' => $sesion->isLogged(),
                'usuarios' => $listaUsuarios,
                'alert' => $alert,
                'usuario' => $usuario
                );

// - Renderizado
if ($usuario->getAdmin()) {
    echo $twig->render('tablaRoot.twig', $data);
} else {
    echo $twig->render('tablaBasic.twig', $data);
}

/*
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
                        <a class="nav-link" href="../producto/">Producto</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./">Usuario</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../cliente/">Registrarse</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Usuario</h4>
                    <?= $alert ?>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <h3>Listado de usuario</h3>
                </div>
                <table class="table table-striped table-hover" id="tablaProducto">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Id</th>
                            <th>Correo</th>
                            <th>Alias</th>
                            <th>Nombre</th>
                            <th>Activo</th>
                            <th>Fecha Alta</th>
                            <th>Borrar</th>
                            <th>Borrar 2</th>
                            <th>Editar</th>
                            <th>Editar 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($usuarios as $usuario) {
                                $nombre = urlencode($usuario->getNombre());
                                $correo = urlencode($usuario->getCorreo());
                                ?>
                                <tr >
                                    <td><input type="checkbox" name="ids[]"  value="<?= $usuario->getId() ?>" form="fBorrar" /></td>
                                    <td><?php echo $usuario->getId(); ?></td>
                                    <td><?= $usuario->getCorreo() ?></td>
                                    <td><?= $usuario->getAlias() ?></td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?php
                                            if ($usuario->getActivo()){
                                                echo 'Si';
                                                } else {
                                                    echo 'No';
                                                }
                                        ?>
                                    </td>
                                    <td><?= $usuario->getFechaalta() ?></td>
                                    <td><a href="dodelete.php?id=<?= $usuario->getId() ?>" class = "borrar">Borrar</a></td>
                                    <td><a href="dodelete.php?id=<?= $usuario->getId() ?>&correo=<?= $correo ?>" class = "borrar">Borrar</a></td>
                                    <td><a href="edit.php?id=<?= $usuario->getId() ?>">Editar</a></td>
                                    <td><a href="#" class = "editar" data-id="<?= $usuario->getId() ?>">Editar</a></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <div class="row">
                    <input class="btn btn-danger" type="submit" value="borrar" form="fBorrar"/>
                    &nbsp;
                    <input class="btn btn-danger" type="button" value="borrar" data-toggle="modal" data-target="#confirm" />
                    &nbsp;
                    <a href="insert.php" class="btn btn-success">Agregar usuario</a>
                </div>
                <form action="dodelete.php" method="post" name="fBorrar" id="fBorrar"></form>
                <form action="edit.php" method="post" name="fEditar" id="fEditar">
                    <input type="hidden" name="id" id="id" value="" />
                </form>
                <hr>
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
*/