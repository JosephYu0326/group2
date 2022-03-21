<?php

use LDAP\Result;

require_once 'parts/connect_db.php';
$sql = "select museum_direction,Museum_city
from museum_location
join museum_direction on museum_direction.museum_direction_id = museum_location.museum_direction_id
join museum_city on museum_city.museum_city_id = museum_location.museum_city_id";
try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results=$stmt->fetchAll();
}
catch(Exception $ex){
 echo($ex->getMessage());
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <select name="" id="">
        <option value="">-- select Location --</option>
        <?php foreach ($results as $output){?>
        <option value=""><?php echo $output["Museum_city"]; ?></option>
        <?php } ?>
    </select>
</body>

</html>