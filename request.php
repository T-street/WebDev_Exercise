<?php

require('search.php');

$search = new search();
$search_query = $_REQUEST['search'];
$result = $search->get_result($search_query);
$response = array();

if ($result->count > 0) {
    $response['status'] = "OK";
    $response['results'] = $search->format_result($result);
} else {

    $response['status'] = "result_empty";
}

echo json_encode($response);
?>
