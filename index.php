<?php

require_once 'config/global.php';
if (isset($_GET["controller"])) {
    $controllerObj = cargarControlador($_GET["controller"]);
    launchAction($controllerObj);
} else {
    $controllerObj = cargarControlador(DEFAULT_CONTROLLER);
    launchAction($controllerObj);
}
function cargarControlador($controller) {
    $controlador = ucwords($controller) . 'Controller';
    $strFileController = 'controller/' . $controlador . '.php';
    if (!is_file($strFileController)) {
        $strFileController = 'controller/' . ucwords(DEFAULT_CONTROLLER) . 'Controller.php';
    }
    require_once $strFileController;
    $controllerObj = new $controlador();
    return $controllerObj;
}
function launchAction($controllerObj)
{
    if (isset($_GET["action"])) {
        $controllerObj->run($_GET["action"]);
    } else {
        $controllerObj->run(DEFAULT_ACTION);
    }
}

/* function cargarControlador($controller){
switch ($controller) {
        case 'employees':
            $strFileController = 'controller/employeesController.php';
            require_once $strFileController;
            $controllerObj = new employeesController();
            break;
        default:
            $strFileController = 'controller/employeesController.php';
            require_once $strFileController;
            $controllerObj = new EmployeesController();
            break;
    }
    return $controllerObj;
} */
