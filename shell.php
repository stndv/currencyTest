<?php
require_once('config.php');

$filename = 'http://www.cbr.ru/scripts/XML_daily.asp';

$data = simplexml_load_file($filename);//load data into a variable

    $length = count($data);//length of objects in xml
    
    var_dump($length);

   $index = 0;
  
    while($index < $length)
    {
      
        $value = $data->Valute[$index];
        
        $values_array=(array)$value;
        //ID
        $id = $values_array["@attributes"]['ID'];
        // AMD RUB USD BRL BGN
        $name = $values_array['CharCode'];
        // ammount of money
        $rate=$values_array['Value'];
    
        $frate = str_replace(',','.',$rate);
        var_dump($name);
        var_dump($frate);
        var_dump($id);

        $sql = "INSERT INTO currency (`id`, `name`, `rate`) VALUES ( '$id', '$name', '$frate')";

        if (mysqli_query($link, $sql)) {
            echo "Успешно создана новая запись";
        } else {
            echo "Ошибка: " . $sql . "<br>" . mysqli_error($link);
        }

        $index++;

    }
    
    
    /*
    // sql to delete a record
    $sql = "DELETE FROM currency WHERE id=123";

    if ($link->query($sql) === TRUE) {
    echo "Record deleted successfully";
    } else {
    echo "Error deleting record: " . $conn->error;
    }


    //$value = $data->Valute[0];//choose a specific object to show
*/