<?php
session_start();
if (isset($_SESSION['Username'])){
    $page_title ='dashboard';
    include 'init.php';

    $last_num = 2 ;
    $stmt = $conn->prepare("SELECT * FROM news  ORDER BY news_date limit $last_num");
    $stmt->execute();
    $result = $stmt->get_result();
}?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Newspaper Dashboard</title>
	<style>
		/* Style your dashboard here */
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		header {
			background-color: #333;
			color: #fff;
			padding: 10px;
			text-align: center;
			font-size: 24px;
		}

		nav {
			background-color: #ddd;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		nav ul {
			margin: 0;
			padding: 0;
			list-style: none;
			display: flex;
		}

		nav li {
			margin: 0 10px;
		}

		nav a {
			color: #333;
			text-decoration: none;
			font-size: 18px;
			padding: 5px;
			border-radius: 5px;
		}

		nav a:hover {
			background-color: #333;
			color: #fff;
		}

		.container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			align-items: flex-start;
			padding: 10px;
			margin: 10px;
			background-color: #f2f2f2;
			box-shadow: 0 0 5px #aaa;
		}

		.card {
			background-color: #fff;
			padding: 10px;
			margin: 10px;
			box-shadow: 0 0 5px #aaa;
			flex-basis: calc(33.33% - 20px);
			min-height: 200px;
			display: flex;
			flex-direction: column;
		}

		.card h2 {
			font-size: 20px;
			margin: 0;
			padding: 5px 0;
		}

		.card p {
			font-size: 16px;
			margin: 0;
			padding: 5px 0;
			flex-grow: 1;
		}

		.card a {
			color: #333;
			text-decoration: none;
			font-size: 16px;
			padding: 5px;
			border-radius: 5px;
			align-self: flex-end;
			margin-top: 10px;
		}

		.card a:hover {
			background-color: #333;
			color: #fff;
		}

		@media screen and (max-width: 768px) {
			.container {
				flex-direction: column;
				align-items: center;
			}

			.card {
				flex-basis: 100%;
			}
		}
	</style>
</head>
<body>
	<header>Newspaper Dashboard</header>

	<div class="container">
		<div class="card">
			<h2>latest <?php echo $last_num ?> News</h2>
            <?php $i = 1 ;
                while($row = $result->fetch_assoc()){ ?>
                    <p><?php echo $i ?></p>
                    <h3><?php echo "title :-".$row['title'] ?></h3>
                    <p><?php echo "content :-".$row['content'] ?></p>
                    <p><?php  $i++ ?></p>
            <?php } ?>
		</div>
		<div class="card">
			
			<?php 
                $categories = categories(); ?>
                <h1>categories</h1>
                <?php foreach($categories as $category){ ?>
                        <ul class="category">
                            <li><?php echo $category['category_name'] ?></li>
                        <?php 
                            if( ! empty($category['subcategory'])){
                                echo viewsubcat2($category['subcategory']);
                            } 
                        ?>
                    </ul>
                <?php } ?>
		</div> 
        <!-- <div class="card">
			<h2>Sports News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>   -->
	</div>
</body>
</html>

<?php
include 'templets/footer.php';
?>