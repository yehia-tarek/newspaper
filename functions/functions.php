<?php
function get_title(){
    global $page_title;

    if (isset($page_title)){
        echo $page_title;
    } else {
        echo 'default';
    }
}

//======================
function checkItem($select, $from, $value){
    global $conn ;
    $statment = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->bind_param('s',$value);
    $statment->execute();
    $result = $statment->get_result();

    $count = $result->num_rows;
    
    return $count ;
}

//==============================
function redirectHome($theMsg, $url = null, $seconds = 3){
    if ($url === null){
        $url = 'index.php';
        $link = 'home page';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
            $url =$_SERVER['HTTP_REFERER'];
            $link = 'previous page';
        }else {
            $url = 'index.php';
            $link = 'home page';
        }
    }

    echo $theMsg;
    echo "<div class ='alert alert-info'>you will redirected to $link after $seconds seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();

}

function dbconnect(){
    $conn = new mysqli('localhost', 'root', '', 'newspaper');

	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}

    return $conn;

}

function categories()
{
	$conn = dbconnect();
	
	$sql = "SELECT * FROM categories WHERE parent_id=0";
	$result = $conn->query($sql);
	
	$categories = array();
	
	while($row = $result->fetch_assoc())
	{
		$categories[] = array(
			'id' => $row['id'],
			'parent_id' => $row['parent_id'],
			'category_name' => $row['category_name'],
			'subcategory' => sub_categories($row['id']),
		);
	}
	
	return $categories;
}

//========

function sub_categories($id)
{	
	$conn = dbconnect();
	
	$sql = "SELECT * FROM categories WHERE parent_id=$id";
	$result = $conn->query($sql);
	
	$categories = array();
	
	while($row = $result->fetch_assoc())
	{
		$categories[] = array(
			'id' => $row['id'],
			'parent_id' => $row['parent_id'],
			'category_name' => $row['category_name'],
			'subcategory' => sub_categories($row['id']),
		);
	}
	return $categories;
}
//====
function viewsubcat($categories , $level = 0)
{
	$html = '<ul class="sub-category">';
	$level += 2 ;
	foreach($categories as $category){
        $id = $category['id'];
        $cat =$category['category_name'];
		$html .= "<tr><td>".str_repeat('--', $level). "$cat </td>
					<td>	<a class='btn btn-success btn-lg' role='button' href='news_cat.php?do=edit&id=$id'>edit</a>
						<a class='btn btn-danger btn-lg' role='button' href='news_cat.php?do=delete&id=$id'>delete</a> </td></tr>
				";
		
		if( ! empty($category['subcategory'])){
			$html .= viewsubcat($category['subcategory'], $level);
		}

	}
	$html .= '</ul>';
	
	return $html;
}
//===========
function option_subcat($categories, $level = 0)
{
	$html = '';
    $level++ ;
	foreach($categories as $category){
        $id = $category['id'];
        $cat =$category['category_name'];

		$html .= "<option value='$id'>".str_repeat('--', $level).$cat."</option>";
		
		if( ! empty($category['subcategory'])){
			$html .= option_subcat($category['subcategory'], $level);
		}   
	}	
	return $html;
}

//=================

function checkbox_cat($categories, $level = 0, $child=0)
{
	$html = '';
    $level++ ;
    $child++ ;
	foreach($categories as $category){
        $id = $category['id'];
        $cat =$category['category_name'];

		$html .= "	<input type='checkbox' name='category[]' value='$id' class='level-$level child-$child' id='category' />
					<label for='category'>".str_repeat('--', $level).$cat."</label><br>";
		$child++ ;
		
		if( ! empty($category['subcategory'])){
			$html .= checkbox_cat($category['subcategory'], $level);
		}   
	}	
	return $html;
}

function checkbox_cat2($categories, $level = 0, $child=0)
{
	$html = '';
    $level++ ;
    $child++ ;
	foreach($categories as $category){
        $id = $category['id'];
        $cat =$category['category_name'];

		$html .= "<ul>	<input type='checkbox' name='category[]' value='$id' id='level-$level-$child' ' />
					<label for='category'>".str_repeat('--', $level).$cat."</label><br>";
		$child++ ;
		
		if( ! empty($category['subcategory'])){
			$html .= checkbox_cat2($category['subcategory'], $level);
		}
		$html .= "</ul>" ; 
	}	
	return $html;
}

function viewsubcat2($categories , $level = 0)
{
	$html = '<ul class="sub-category">';
	$level += 2 ;
	foreach($categories as $category){
        $id = $category['id'];
        $cat =$category['category_name'];
		$html .= "<td>$cat</td><br>";
		
		if( ! empty($category['subcategory'])){
			$html .= viewsubcat2($category['subcategory'], $level);
		}

	}
	$html .= '</ul>';
	
	return $html;
}
?>