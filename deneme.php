<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <form id="jsform" action="" method="POST">
        <input id=checkbox type="checkbox" name="test" value="1" onChange="this.form.submit()">
        <input id=checkbox type="checkbox" name="test" value="1" onChange="this.form.submit()" checked>


    </form>


    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['test'] == '1') {
            echo "dolu";
        } elseif ($_POST['test'] == '') {
            echo "bos";
        }
    }
    ?>











</body>

</html>