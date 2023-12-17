<?php
require_once 'templates/header.php';

$db = new PDO("mysql:host=localhost;dbname=Practice_security", "root", "");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT username, credit_card_number FROM userdata WHERE username = ? AND password = ?";
    error_log("executed query: " . $query);
    $statement = $db->prepare($query);
    $statement->bindParam(1, $username);
    $statement->bindParam(2, $password);
    $statement->execute();

    $list_of_users = $statement->fetchAll();

    if (count($list_of_users) == 0) {
        echo '<div class="text-danger">Wrong username or password!</div>';
    } else {
        foreach ($list_of_users as $user) {
            echo '
            <div class="card m-3">
                <div class="card-header">
                    <span>' . $user['username'] . '</span>
                </div>
                <div class="card-body">
                    <p class="card-text">Your credit card number: ' . $user['credit_card_number'] . '</p>
                </div>
            </div>
            <hr>
            ';
        }
    }
}
?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>