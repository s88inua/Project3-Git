<?php
/**
 * Created by PhpStorm.
 * User: Me
 * Date: 18/11/18
 * Time: 22:17
 */

/** Задача №1  */
function task1()
{
    $trTd = "<tr><td style='background-color: aliceblue;'>";
    $tdTr = "</td></tr>";
    $td = "<td>";
    $endTd = "</td>";

    $xml = simplexml_load_file("data.xml") or die("Error: Cannot create object");
    echo $trTd . "Номер заказа : " . "</td>" . "<td>" . $xml->attributes()->PurchaseOrderNumber . "</td>";
    echo $td . " Дата заказа : " . "</td>" . "<td>" . $xml->attributes()->OrderDate . $tdTr;

    foreach ($xml as $Address) {
        echo "<table>";
        if (!empty($Address->attributes())) {
            echo "<br>" . "---------------" . "</br>";

            echo $trTd . "Тип доставки: " . $endTd . $td . '<b>' . $Address->attributes() . '</b>' . $tdTr;
            echo $trTd . "Имя: " . $endTd . $td . $Address->Name . $tdTr;
            echo $trTd . "Улица: " . $endTd . $td . $Address->Street . $tdTr;
            echo $trTd . "Город: " . $endTd . $td . $Address->City . $tdTr;
            echo $trTd . "Регион: " . $endTd . $td . $Address->State . $tdTr;
            echo $trTd . "Индекс: " . $endTd . $td . $Address->Zip . $tdTr;
            echo $trTd . "Страна: " . $endTd . $td . $Address->Country . $tdTr;
        }

    }
    echo $trTd . "Примичание к отправке: " . $xml->DeliveryNotes . $tdTr;
    echo $trTd . "<b> Заказанные товары </b>" . $tdTr;
    foreach ($xml->Items->Item as $item) {
        echo $trTd . "<b> Товар №1 </b>" . $tdTr;
        echo $trTd . "Номер продукта: " . $endTd . $td . $item->attributes()->PartNumber . $tdTr;
        echo $trTd . "Продукт: " . $endTd . $td . $item->ProductName . $tdTr;
        echo $trTd . "Кол-во в заказе: " . $endTd . $td . $item->Quantity . $tdTr;
        echo $trTd . "Цена: " . $endTd . $td . $item->USPrice . $tdTr;
        $comment = "Комментарий к товару: ";
        if (empty($item->Comment)) {
            echo $trTd . $comment. "Отсутствуют " . $tdTr ;
        } else {
            echo $trTd . $comment . $endTd . $td . $item->Comment . $tdTr ;
        }

    }
    echo "</table>";

}

/** Задача №2  */
function jsonWrite($file,$array_convert) {
    $fp = fopen($file , 'w');
    fwrite($fp , json_encode($array_convert));
    fclose($fp);
}
function task2()
{

    $array_data = [['Masha' => '88-99-55' , 'Nika' => '88-55-66' , 'Karina' => '768-12-12' , 'Dasha' => '897-55-66'] , ['Masha' => 1 , 'Nika' => 2 , 'Karina' => 3 , 'Dasha' => 4]];
    $change_array_data = [['Violeta' => '86-99-55' , 'Sabina' => '11-53-66' , 'Karina' => '768-12-12' , 'Dasha' => '897-55-66'] , ['Violeta' => 2 , 'Sabina' => 5 , 'Karina' => 3 , 'Dasha' => 4]];

    jsonWrite('output1.json',$array_data);


    $json_decode_one = json_decode(file_get_contents('output1.json') , true);

    $change= rand(1 , 2);
    if ($change == 1) {

        jsonWrite('output2.json',$change_array_data);
        $json_decode_two = json_decode(file_get_contents('output2.json') , true);
        echo "файл изменился" . "</br>";
        for ($i = 0; $i < 2; $i++) {
            $result1 = array_diff($json_decode_one[$i] , $json_decode_two[$i]);
            $result2 = array_diff($json_decode_two[$i] , $json_decode_one[$i]);
            echo "<table><tr><td><pre>";
            print_r($result1);
            echo "</pre></td><td><pre>";
            print_r($result2);
            echo "</pre></td></tr></table>";
        }
    } else {
        jsonWrite('output2.json',$array_data);
        $json_decode_two = json_decode(file_get_contents('output2.json') , true);
        echo "Файд не изменился - два файла одинаковые";
        echo "<table><tr><td><pre>";
        print_r($json_decode_one);
        echo "</pre></td><td><pre>";
        print_r($json_decode_two);
        echo "</pre></td></tr></table>";

    }
}

/** Задача №3  */

function task3()
{
    /** Числа поставлены меньшы для того что-бы удобнее было проверять правильность решения **/
    for ($i = 0; $i < 50; $i++) {
        /**Здесь 10 меняем по условию задачи 50  **/
        $randNumber[$i] = rand(1 , 100);
        /**Здесь 10 меняем по условию задачи  100**/
    }
    $fp = fopen('task3.csv' , 'w');
    fputcsv($fp , $randNumber);
    $handle = fopen("task3.csv" , "r");
    $data = fgetcsv($handle , 1000 , ",");
    $num = count($data);
    for ($j = 0; $j < $num; $j++) {
        if ($data[$j] % 2 == 0) {
            $result = $result + $data[$j];
        }
    }
    echo "Сумма четных чисел = " . $result . "</br>";
    fclose($fp);
}


/** Задача №4  */
function task4()
{
    $data = file_get_contents("https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json");
    $decoded_data = json_decode($data , true);
    $searchValue[] = $decoded_data['query']['pages']['15580374'];
    foreach( $decoded_data['query']['pages'] as $page) {
        echo 'pageid - ' . $page['pageid'] . "</br>";
        echo 'title - ' . $page['title'] . "</br>";
    }
}