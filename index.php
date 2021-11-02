<?php
require_once ('config.php');

$salt = '6asd5f476ds54f7dsf6g5';
$header = getallheaders();
$auth = $header['Authorization'] ?? false;
$tokeT = ($auth || ! substr($auth, 0, 7) == 'Bearer ') ? trim(substr($auth, 7)) : false;
// echo md5('abracadabra'.$salt);

if ('83c4d28a172a2090cb6fcc51c8c7ee0e' != md5($tokeT . $salt)) {
    die('Forbidden!');
}

if ($id = $_GET['id'] ?? null) {
    $cyr = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM currency WHERE id = '$id'"));
    echo json_encode($cyr, JSON_PRETTY_PRINT);
} else {
    $limit = 5;
    $sql = 'SELECT * FROM currency LIMIT ' . $limit;
    if ($page = ($_GET['page'] ?? null)) {
        $offset = $page * $limit;
        $sql .= " OFFSET $offset";
    }
    $query = mysqli_query($link, $sql) or die(mysqli_error());

    $currencies = [];
    while ($row = mysqli_fetch_array($query)) {
        $currencies[] = $row;
    }

    // -------------Get the Total number of rows in the table------------------

    $query2 = "SELECT COUNT(*) FROM currency";

    $all_rows = mysqli_query($link, $query2);

    $rows = mysqli_fetch_row($all_rows);

    // echo $rows[0]; //prints in array

    $total = isset($rows[0]) ? $rows[0] : 0;
    // ----------------------end of my edit to count rows in the table------------------

    $pagesTotal = ceil($total / $limit);
    $data = [
        '_links' => [
            'self' => $page ? '/page=' . $page : '/',
            'first' => '/',
            'prev' => $page > 1 ? '/page=' . ($page - 1) : '',
            'next' => $page > 0 && $page < $pagesTotal ? '/page=' . ($page + 1) : '',
            'last' => $pagesTotal > 1 ? '/page=' . $pagesTotal : '/'
        ],

        'count' => $pagesTotal,
        'total' => $total,
        '_embedded' => [
            'currencies' => []
        ]
    ];
    $data['_embedded']['currencies'] = $currencies;

    echo json_encode($data, JSON_PRETTY_PRINT);

    // $link->close();
}