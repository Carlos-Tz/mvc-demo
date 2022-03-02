<?php
/* require_once "controller/mainController.php";

    $index = new MainController();
    $index->indexMain(); */

//Global setting
require_once 'config/global.php';
//We load the controller and execute the action
if (isset($_GET["controller"])) {
    // We load the instance of the corresponding controller
    $controllerObj = cargarControlador($_GET["controller"]);
    //We launch the action
    launchAction($controllerObj);
} else {
    // We load the default controller instance
    $controllerObj = cargarControlador(CONTROLLER_DEFECTO);
    // We launch the action
    launchAction($controllerObj);
}
function cargarControlador($controller)
{
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
}
function launchAction($controllerObj)
{
    if (isset($_GET["action"])) {
        $controllerObj->run($_GET["action"]);
    } else {
        $controllerObj->run(DEFECT_ACTION);
    }
}
/*
function cargarControlador($controller){
// We create the Name of the controller: e.j. userController
$controlador=ucwords($controller).'Controller';
// We create the Name of the controller file: e.j. controller / userController.php
$strFileController='controller/'.$controlador.'.php';
//If there is no controller with that, we load the one defined by default.
if(!is_file($strFileController)){
$strFileController='controller/'.ucwords(CONTROLLER_DEFECTO).'Controller.php';
}
//We load the file where the controller is defined:
require_once $strFileController;
//We create the object
$controllerObj=new $controlador();
return $controllerObj;
}
*/
