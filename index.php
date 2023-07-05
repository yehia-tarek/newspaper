<?php 
session_start();
$nonavbar ='';
$page_title ='login';
if (isset($_SESSION['Username'])){
    header('location: startbootstrap-sb-admin-2-gh-pages\index.php'); //redirect to dashboard
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hasedpass = sha1($password);

    //check if the user exist in database
    $stmt = $conn->prepare('SELECT userID, userName, password FROM users WHERE userName = ? AND password = ? AND groupID = 1 LIMIT 1');
    $stmt->bind_param("ss", $username, $hasedpass);
    $stmt->execute();
    //$result = $stmt->store_result();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc() ;
    $count = $result->num_rows;
    
    if($count > 0){
        $_SESSION['Username'] = $username; 
        $_SESSION['id'] = $row['userID']; 
        header('location:startbootstrap-sb-admin-2-gh-pages\index.php'); 
        exit();    
    }
} ?>
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off">
            <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
            <input class="btn btn-primary btn-block" type="submit" value="login">
        </form>
<?php
include 'templets/footer.php';
?>