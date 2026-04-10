<?php
$conn = new mysqli("localhost","root","","farmeta");

$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$location = $_POST['location'];

$crop = explode(",", $_POST['crop']);
$quantity = explode(",", $_POST['quantity']);
$price = explode(",", $_POST['price']);

$conn->begin_transaction();

try {

    $stmt = $conn->prepare("INSERT INTO buyer_posts(name,email,contact,location) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$contact,$location);
    $stmt->execute();

    $post_id = $conn->insert_id;

    for($i=0;$i<count($crop);$i++){

        $stmt2 = $conn->prepare("
            INSERT INTO buyer_post_items(post_id,crop,quantity,price)
            VALUES (?,?,?,?)
        ");

        $stmt2->bind_param("isss",$post_id,$crop[$i],$quantity[$i],$price[$i]);
        $stmt2->execute();
    }

    $conn->commit();
    echo "SUCCESS";

} catch(Exception $e){
    $conn->rollback();
    echo "ERROR";
}
?>