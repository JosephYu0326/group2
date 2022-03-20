<?php
require __DIR__. '/parts/connect_db.php';
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('zh_TW');
$faker->addProvider(new FakerChineseLorem\Provider\zh_CN\Lorem($faker));


$sql = "INSERT INTO `museum_museum`(`Museum_name`,`Museum_location_id`,`Museum_kind_id`,`Museum_features`,`Museum_introduce`,`Museum_booking_notice`,`Museum_more_information`) Values (?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
for($i=0; $i<100; $i++){
$stmt->execute([
    $faker->word(2).'美術館',
    rand(1,22),
    rand(1,5),
    $faker->text(50),
    $faker->text(250),
    $faker->text(250),
    $faker->text(250),

]);
}

echo 'ok';