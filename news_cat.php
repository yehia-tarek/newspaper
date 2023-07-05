<?php
session_start();
$page_title = 'nwes cat';
if (isset($_SESSION['Username'])){
    include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

if($do == 'manage'){ 
    
    $categories = categories(); ?>
    <div class="text-center">
        <h1>categories</h1>
    </div>
    <div class="table-responsive">
    <table class="table-primary table   table table-striped table-hover table table-bordered table align-middle">
        <tr class="">
            <th scope="col">category</th>
            <th scope="col">action</th>
        </tr>
        <tr>
    <?php foreach($categories as $category){ ?>
            <tr>
            <ul class="category">
                <td ><?php echo $category['category_name'] ?> </td>
                    <td ><a class="btn btn-success btn-lg" role="button" href="news_cat.php?do=edit&id=<?php echo $category['id'] ?>">edit</a>
                        <a class="btn btn-danger btn-lg" role="button" href="news_cat.php?do=delete&id=<?php echo $category['id'] ?>">delete</a>
                    </td>
                
            <?php 
                if( ! empty($category['subcategory'])){
                    echo viewsubcat($category['subcategory']);
                } 
            ?>
            </ul>
            </tr>
            
        </tr>
    </table>
    </div>
    <?php } ?>
    <div class="d-grid gap-2 col-1 mx-auto">
        <a class="btn btn-primary btn-lg" href="news_cat.php?do=add" role="button">add cat</a>
    </div>
    
<?php  

}elseif($do == 'add'){ 
    $categories = categories();
    ?>
    <div class="text-center">
    <h1>add category</h1>
    </div>
        <div class="container">
            <form  action="?do=insert"  method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">category Name</label>
                <input type="email" name="categoryName" autocomplete="off" class="form-control" placeholder="category Name" required>               
            </div>
                <div class="mb-3">
                    <?php foreach($categories as $category){ ?>
                    <select class="parent_id form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="parent_id">
                        <option value="<?php echo $category['id']?>"><?php echo $category['category_name'] ?></option>
                    <?php 
                    if( ! empty($category['subcategory'])){
                        echo option_subcat($category['subcategory']);
                    } 
                    ?>
                    </select> 
                    <?php } ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </form>
        </div>  
<?php        
}elseif($do == 'insert'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1>inesrt membar</h1>";
        echo "<div class='container'>";
        //get variable from the form
        $categoryName   = $_POST['categoryName'];
        $parent_id = $_POST['parent_id'];
        

        $formError = array();
        if(strlen($categoryName) > 20 && strlen($categoryName) < 3){
            $formError[] = 'category Name cant be more than 20 and less than 3';
        }
        if(empty($categoryName)){
            $formError[] = 'category Name cant be empty';
        }
        foreach($formError as $error){
            echo '<div>'.$error.'</div>';
        }
        if (empty($formError)){

            //check if user exist in database
            $check = checkItem("category_name", "categories", $categoryName); 
            
            if ($check == 1) {
                
                $themsg = "<div>sorry this category is exist</div>";
                redirectHome($themsg, 'back');

            } else {
                //insert userinfo in the database 
                $sql = "INSERT INTO categories(category_name, parent_id) VALUES(?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $categoryName, $parent_id);
                $stmt->execute();
                $stmt->store_result();
                $themsg = "<div>Number of record inserted:\n".$stmt->affected_rows."</div>";
                redirectHome($themsg, 'back');
            }
        }
    }
}elseif($do == 'edit'){
    $conn = dbconnect();

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ; 
            
    $stmt = $conn->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc() ;
    $count = $result->num_rows;
    
    if ($count > 0){ ?>

        <div class="text-center">
            <h1>edit category</h1>
        </div>
        <div class="container">
        <form  action="?do=update"  method="post">
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <div >
                        <label>category name</label>
                        <div>
                            <input type="text" name="category_name"  value="<?php echo $row['category_name'] ?>" required>
                        </div>
                        <div >
                            <input class="btn btn-primary" type="submit" value="save">
                        </div>
                    </div>
        </div>
<?php  }          
}elseif($do == 'update'){
    $conn = dbconnect();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $category_name = $_POST['category_name'];
        $id = $_POST['id'];

        $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE id = ? ");
        $stmt->bind_param('si', $category_name, $id);
        $stmt->execute();
        
        $themsg = $stmt->affected_rows." record updated";
        redirectHome($themsg);
    }
}elseif($do == 'delete'){
    $conn = dbconnect();
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ;  

    $check = checkItem('id', 'categories', $id);
    
    if ($check > 0){
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $themsg = $stmt->affected_rows." record deleted";
        redirectHome($themsg);
    }else {
        $themsg = 'this id not found';
        redirectHome($themsg);
    }
}
include 'templets/footer.php';

}else {
    header('location:index.php');
    exit();
}
?>