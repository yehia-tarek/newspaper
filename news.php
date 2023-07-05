<?php
session_start();
$page_title = 'nwes';
if (isset($_SESSION['Username'])){
    include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

if($do == 'manage'){ 

    $stmt = $conn->prepare("SELECT * FROM news");
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
    <div class="text-center">
        <h1>NEWS</h1>
    </div>
    <table class="table-primary table   table table-striped table-hover table table-bordered table align-middle">
        <tr>
            <th scope="col">title</th>
            <th scope="col">content</th>
            <th scope="col">date</th>
            <th scope="col">category</th>
            <th scope="col">action</th>
        </tr>
        
        <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['content'] ?></td>
            <td><?php echo $row['news_date'] ?></td>
            <td><?php 
                        $stmt2 = $conn->prepare('SELECT  category_name 
                        FROM categories as t1
                        LEFT JOIN news_cat as t2 
                        ON t1.id = t2.cat_id
                        WHERE t2.news_id = (?)');
                        $stmt2->bind_param("i",$row['newsID']);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        
                        while($row2 = $result2->fetch_assoc()){ 
                            echo $row2['category_name']."<br>";
                        }
                ?></td>
            <td>
                <a class="btn btn-success btn-lg" role="button"  href="news.php?do=edit&newsID=<?php echo $row['newsID'] ?>">edit</a>
                <a class="btn btn-danger btn-lg" role="button"  href="news.php?do=delete&newsID=<?php echo $row['newsID'] ?>">delete</a>
            </td>
        </tr>
        <?php } ?>
        
    </table>
    <br><a class="btn btn-primary btn-lg" role="button" href='news.php?do=add'>add news</a>

<?php 
}elseif($do == 'add'){
    $categories = categories();
    ?>
    <div class="text-center">
        <h1>add news</h1>
    </div> 
        <div class="container">
            <form  action="?do=insert"  method="post">               
                <label>news title</label>
                <div >
                    <input type="text" name="title" placeholder="title" required>
                </div>
                <div>
                    <input type="text" name="content" placeholder="content" required>
                </div>
                <div>
                    <label for="">choose category :-</label>
                </div>
                <div>
                    <?php foreach($categories as $category){ ?>

                            <input type='checkbox' name='category[]' value='<?php echo $category['id']?>' id="level-0"  />
                            <label for='category'><?php echo $category['category_name'] ?></label><br>
                    <?php 
                            if( ! empty($category['subcategory'])){
                                echo checkbox_cat2($category['subcategory']);
                            } 

                        }
                    ?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>               
            </form>
        </div> 
    
<?php 
}elseif($do == 'insert'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1>inesrt news</h1>";
        echo "<div class='container'>";
        //get variable from the form
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];

        $formError = array();
        if(strlen($title) > 20 && strlen($title) < 3){
            $formError[] = 'title cant be more than 20 and less than 3';
        }
        if(strlen($content) > 200 && strlen($content) < 20){
            $formError[] = 'title cant be more than 200 and less than 20';
        }
        if(empty($title)){
            $formError[] = 'title cant be empty';
        }
        if(empty($category)){
            $formError[] = 'category cant be empty';
        }
        if(empty($content)){
            $formError[] = 'content cant be empty';
        }
        if(empty($category)){
            $formError[] = 'category cant be empty';
        }
        foreach($formError as $error){
            echo '<div>'.$error.'</div>';
        }
        if (empty($formError)){
            $stmt = $conn->prepare("INSERT INTO news (title,content) VALUES (?,?)");
            $stmt->bind_param("ss", $title, $content);
            $stmt->execute();
            $stmt->store_result();
            $newsID = $stmt->insert_id ;


            foreach($category as $cat) {
                $stmt2 = $conn->prepare("INSERT INTO news_cat (news_id,cat_id) VALUES (?,?)");
                $stmt2->bind_param("ii", $newsID, $cat);
                $stmt2->execute();
            }


            $themsg = "<div>Number of record inserted:\n".$stmt->affected_rows."</div>";
            redirectHome($themsg, 'back');
        }
    }   
}elseif($do == 'edit'){
    $newsID = isset($_GET['newsID']) && is_numeric($_GET['newsID']) ? intval($_GET['newsID']) : 0 ; 

    $stmt = $conn->prepare('SELECT * FROM news WHERE newsID = ? LIMIT 1');
    $stmt->bind_param("i",$newsID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc() ;
    $count = $result->num_rows;
    
    if ($count > 0){ 
        $categories = categories();?>
    <div class="text-center">
        <h1>edit news</h1>
    </div>
        <div class="container">
        <form  action="?do=update"  method="post">
                    <input type="hidden" name="newsID" value="<?php echo $row['newsID'] ?>">
                    <div >
                        <div>
                            <input type="text" name="title"  value="<?php echo $row['title'] ?>" required>
                        </div>
                        <div>
                            <input type="text" name="content"  value="<?php echo $row['content'] ?>" required>
                        </div>
                        <div >
                            <input class="btn btn-primary" type="submit" value="save">
                        </div>
                    </div>
        </div>
<?php  }

}elseif($do == 'update'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $newsID = $_POST['newsID'];

    $stmt = $conn->prepare("UPDATE news SET title =?, content =? WHERE newsID = ? ");
    $stmt->bind_param('ssi', $title, $content, $newsID);
    $stmt->execute();

    
    $themsg = $stmt->affected_rows." record updated";
    print_r($category);
    redirectHome($themsg,);
}
}elseif($do == 'delete'){
    $newsID = isset($_GET['newsID']) && is_numeric($_GET['newsID']) ? intval($_GET['newsID']) : 0 ;  

    $check = checkItem('newsID', 'news', $newsID);
    
    if ($check > 0){
        $stmt = $conn->prepare("DELETE FROM news WHERE newsID = ? ");
        $stmt->bind_param("i", $newsID);
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