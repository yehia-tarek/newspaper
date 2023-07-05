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
	<nav>
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">News</a></li>
			<li><a href="#">Sports</a></li>
			<li><a href="#">Opinion</a></li>
			<li><a href="#">Business</a></li>
			<li><a href="#">Technology</a></li>
		</ul>
		<form action="#" method="GET">
			<input type="text" name="search" placeholder="Search...">
			<button type="submit">Search</button>
		</form>
	</nav>
	<div class="container">
		<div class="card">
			<h2>Top News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
		<div class="card">
			<h2>Sports News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
		<div class="card">
			<h2>Opinion</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
		<div class="card">
			<h2>Business News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem,at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
		<div class="card">
			<h2>Technology News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
		<div class="card">
			<h2>More News</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum porta lorem, at lacinia neque hendrerit nec.</p>
			<a href="#">Read More</a>
		</div>
	</div>
</body>
</html>