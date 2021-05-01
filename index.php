<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

//Bättre att använda include?

$data = file_get_contents('./data.json', FILE_USE_INCLUDE_PATH);
$category_array = ['jewelery', 'men clothing', 'women clothing', 'electronics'];
$array_data = json_decode($data, true);

//Skapa en array med erros: Category doesn't exist, Show must be between 1-20.
$error_array = [];

$show = $_GET['show'] ?? -1;
$category = $_GET['category'];

//Kolla om array category isset.
if ($category) {
    if (!in_array($category, $category_array)) {
        array_push($error_array, array("Category" => 'Category not found'));
    } else {
        $returnArray = array_filter($array_data, function ($product) {
            global $category;
            return $product['category'] == $category;
        });
    }
}

//Den borde inte göra det här om om det finns ett fel ovan.
if (!$show >= 1 && $show <= 20) {
    $array = json_decode($data);
    shuffle($array);
    $returnData = json_encode(array_slice($array, 0, $_GET['show']));
    echo $returnData;
}

// echo "<pre>";
echo json_encode($error_array);
// echo "</pre>";
