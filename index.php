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

$data = [
    '_links' => [
        'self' => '...',
        'first' => '...',
        'prev' => '...',
        'next' => '...',
        'last' => '...',
    ],

    'count' => 3,
    'total' => 498,
    '_embedded'
];
$data['_embedded'] = $currencies;

echo json_encode($data);

