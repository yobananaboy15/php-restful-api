<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

$data = file_get_contents('./data.json', FILE_USE_INCLUDE_PATH);
$returnArray = json_decode($data, true);
$categoryArray = ['jewelery', 'men\'s clothing', 'women\'s clothing', 'electronics'];
$error_array = [];

$show = $_GET['show'] ?? null;
$category = $_GET['category'] ?? null;

if ($category) {
    if (!in_array($category, $categoryArray)) {
        array_push($error_array, array("Category" => 'Category not found'));
    } else {
        $returnArray = array_values(array_filter($returnArray, function ($product) {
            global $category;
            return $product['category'] == $category;
        }));
    }
}

if ($show) {
    if ($show >= 1 && $show <= 20) {
        shuffle($returnArray);
        $returnArray = array_slice($returnArray, 0, $show);
    } else {
        array_push($error_array, array("Show" => 'Show must be between 1 and 20'));
    }
}

if (count($error_array)) {
    echo json_encode($error_array);
} else {
    echo json_encode($returnArray);
}
