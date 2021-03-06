<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

include_once "data.php";

$categoryArray = ['jewelery', 'men\'s clothing', 'women\'s clothing', 'electronics'];
$error_array = [];

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    if (!in_array($category, $categoryArray)) {
        array_push($error_array, array("Category" => 'Category not found'));
    } else {
        $returnArray = array_values(array_filter($returnArray, function ($product) {
            global $category;
            return $product['category'] == $category;
        }));
    }
}

if (isset($_GET['show'])) {
    $show = $_GET['show'];
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
