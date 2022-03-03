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
    <form action="index.php?controller=employees&action=alta" method="post" class="col-lg-5">
        <h3>Add user</h3>
        <hr />
        Name: <input type="text" name="Name" class="form-control" />
        Surname: <input type="text" name="Surname" class="form-control" />
        Email: <input type="text" name="email" class="form-control" />
        phone: <input type="text" name="phone" class="form-control" />
        <input type="submit" value="Send" class="btn btn-success" />
    </form>
    <div class="col-lg-7">
        <h3>Users</h3>
        <hr />
    </div>
    <section class="col-lg-7 usuario" style="height:400px;overflow-y:scroll;">
        <?php foreach ($datos["employees"] as $employee) { ?>
            <?php echo $employee["id"]; ?> -
            <?php echo $employee["Name"]; ?> -
            <?php echo $employee["email"]; ?> -
            <?php echo $employee["phone"]; ?>
            <div class="right">
                <a href="index.php?controller=employees&action=detalle&id=<?php echo $employee['id']; ?>" class="btn btn-info">Detalles</a>
            </div>
            <hr />
        <?php } ?>
    </section>
</body>

</html>