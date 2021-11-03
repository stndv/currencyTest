<?php
require_once('config.php');

$limit = 5;
$sql = 'SELECT * FROM currency LIMIT ' . $limit;
if ($page = ($_GET['page'] ?? null)) {
    $offset = $page * $limit;
    $sql .= " OFFSET $offset";
}
$query = mysqli_query($sql) or die(mysqli_error());

$currencies = [];
while ($row = mysqli_fetch_array($query)) {
    $currencies[] = $row;
}
$total = 35;
$pagesTotal = $total / $limit;
$data = [
    '_links' => [
        'self' => $page ? '/page=' . $page : '/',
        'first' => '/',
        'prev' => $page > 1 ? '/page=' . ($page - 1) : '',
        'next' => $page > 0 && $page < $pagesTotal ? '/page=' . ($page + 1) : '',
        'last' => $pagesTotal > 1  ? '/page=' . $pagesTotal : '/',
    ],

    'count' => 3,
    'total' => 498,
    '_embedded' => [
        'currencies' => []
    ]
];
$data['_embedded']['currencies'] = $currencies;

echo json_encode($data, JSON_PRETTY_PRINT);

