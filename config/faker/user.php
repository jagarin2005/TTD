<?php 
  require_once '../../config/conn.php';
  require_once '../../vendor/fzaninotto/faker/src/autoload.php';

  $faker = Faker\Factory::create();
  for ($i=1; $i<=10; $i++){
    echo $faker->name, " ";
    echo $faker->email, " ";
    echo $faker->password, "<br>";
  }
?>