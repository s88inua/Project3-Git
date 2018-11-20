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
            echo $trTd . "Доставка Имя: " . $endTd . $td . $Address->Name . $tdTr;
            echo $trTd . "Доставка Улица: " . $endTd . $td . $Address->Street . $tdTr;
            echo $trTd . "Доставка Город: " . $endTd . $td . $Address->City . $tdTr;
            echo $trTd . "Доставка Регион: " . $endTd . $td . $Address->State . $tdTr;
            echo $trTd . "Доставка Индекс: " . $endTd . $td . $Address->Zip . $tdTr;
            echo $trTd . "Доставка Страна: " . $endTd . $td . $Address->Country . $tdTr;
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
        if (empty($item->Comment)) {
            echo $trTd . "Комментарий к товару : Отсутствуют " . $tdTr;
        } else {
            echo $trTd . "Комментарий к товару " . $endTd . $td . $item->Comment . $tdTr;
        }

    }


}

/** Задача №2  */
function task2()
{
    $json_data = [['Masha' => '88-99-55' , 'Nika' => '88-55-66' , 'Karina' => '768-12-12' , 'Dasha' => '897-55-66'] , ['Masha' => 1 , 'Nika' => 2 , 'Karina' => 3 , 'Dasha' => 4]];
    $fp = fopen('output1.json' , 'w');
    fwrite($fp , json_encode($json_data));
    fclose($fp);
    $answer = rand(1 , 2);
    if ($answer == 1) {
        $output2 = [['Violeta' => '86-99-55' , 'Sabina' => '11-53-66' , 'Karina' => '768-12-12' , 'Dasha' => '897-55-66'] , ['Violeta' => 2 , 'Sabina' => 5 , 'Karina' => 3 , 'Dasha' => 4]];
        $fp = fopen('output2.json' , 'w');
        fwrite($fp , json_encode($output2));
        fclose($fp);
        echo "файл изменился" . "</br>";

        $getOutOne = json_decode(file_get_contents('output1.json') , true);
        $getOutTwo = json_decode(file_get_contents('output2.json') , true);

        for ($i = 0; $i < 2; $i++) {
            $result1 = array_diff($getOutOne[$i] , $getOutTwo[$i]);
            $result2 = array_diff($getOutTwo[$i] , $getOutOne[$i]);
            echo "<table><tr><td><pre>";
            print_r($result1);
            echo "</pre></td><td><pre>";
            print_r($result2);
            echo "</pre></td></tr></table>";
        }
    } else {
        $fp = fopen('output2.json' , 'w');
        fwrite($fp , json_encode($json_data));
        fclose($fp);
        echo "Файд не изменился - два файла одинаковые";
        $getOutOne = json_decode(file_get_contents('output1.json') , true);
        $getOutTwo = json_decode(file_get_contents('output2.json') , true);
        echo "<table><tr><td><pre>";
        print_r($getOutOne);
        echo "</pre></td><td><pre>";
        print_r($getOutTwo);
        echo "</pre></td></tr></table>";

    }
}


/** Задача №3  */

function task3()
{
    /** Числа поставлены меньшы для того что-бы удобнее было проверять правильность решения **/
    for ($i = 0; $i < 10; $i++) {
        /**Здесь 10 меняем по условию задачи 50  **/
        $randNumber[$i] = rand(1 , 10);
        /**Здесь 10 меняем по условию задачи  100**/
    }
    $randNumberArray[] = $randNumber;
    $fp = fopen('task3.csv' , 'w');
    foreach ($randNumberArray as $fields) {
        fputcsv($fp , $fields);
    }
    fclose($fp);

    $row = 1;
    $result = 0;
    if (($handle = fopen("task3.csv" , "r")) !== FALSE) {

        while (($data = fgetcsv($handle , 1000 , ",")) !== FALSE) {
            $num = count($data);
            echo "<p> $num полей в строке $row: <br /></p>\n";
            $row++;
            for ($j = 0; $j < $num; $j++) {
                if ($data[$j] % 2 == 0) {
                    $result = $result + $data[$j];
                }

            }
            echo "Сумма четных чисел = " . $result . "</br>";
        }
        fclose($handle);
    }
}

/** Задача №4  */
function task4()
{
    $url = file_get_contents("https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json");
    $json_array = json_decode($url , true);
    $searchValue[] = $json_array['query']['pages']['15580374'];
    foreach ($searchValue as $item) {
        echo 'pageid - ' . $item['pageid'] . "</br>";
        echo 'title - ' . $item['title'] . "</br>";
    }
}