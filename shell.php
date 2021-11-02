<?php
require_once ('config.php');

// get data from source and keep data in a variable
$filename = 'http://www.cbr.ru/scripts/XML_daily.asp';

$data = simplexml_load_file($filename); // load data into a variable

$length = count($data); // length of objects in xml to track a sizea

$index = 0; // incrementing variable for loops

// current loop inserts DATA into DB
while ($index < $length) {
    $value = $data->Valute[$index];

    $values_array = (array) $value;
    // ID
    $id = $values_array["@attributes"]['ID'];
    // AMD RUB USD BRL BGN
    $name = $values_array['CharCode'];
    // ammount of money
    $rate = $values_array['Value'];

    $frate = str_replace(',', '.', $rate);

    if ($currency = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM currency WHERE id = '$id'"))) {
        continue;
    }

    // this part of the code inserts data into DB
    $sql = "INSERT INTO currency (`id`, `name`, `rate`) VALUES ( '$id', '$name', '$frate')";

    if (mysqli_query($link, $sql)) {
        echo "currency successfuly added into DB";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }

    $index ++;
}

  