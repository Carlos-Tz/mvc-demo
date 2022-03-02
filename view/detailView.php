<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Example PHP+PDO+POO+MVC</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
        input {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .right {
            float: right;
        }
    </style>
</head>

<body>
    <div class="col-lg-5 mr-auto">
        <form action="index.php?controller=employees&action=actualizar" method="post">
            <h3>User detail</h3>
            <hr />
            <input type="hidden" name="id" value="<?php echo $datos["employee"]->id ?>" />
            Name: <input type="text" name="Name" value="<?php echo $datos["employee"]->Name ?>" class="form-control" />
            Surname: <input type="text" name="Surname" value="<?php echo $datos['employee']->Surname ?>" class="form-control" />
            Email: <input type="text" name="email" value="<?php echo $datos['employee']->email ?>" class="form-control" />
            phone: <input type="text" name="phone" value="<?php echo $datos['employee']->phone ?>" class="form-control" />
            <input type="submit" value="Send" class="btn btn-success" />
        </form>
        <a href="index.php" class="btn btn-info">Return</a>
    </div>
</body>

</html>