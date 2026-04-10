<?php
$conn = new mysqli("localhost","root","","farmeta");

$sql = "SELECT * FROM buyer_posts ORDER BY id DESC";
$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    $post_id = $row['id'];

    $items = [];
    $res2 = $conn->query("SELECT * FROM buyer_post_items WHERE post_id=$post_id");

    while($r = $res2->fetch_assoc()){
        $items[] = $r;
    }

    $row['items'] = $items;
    $data[] = $row;
}

echo json_encode($data);
?>