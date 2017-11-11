<!DOCTYPE html>
<html>
<head>
<style>
	div.container {
		width: 100%;
		border: 1px solid gray;
	}

	header, footer {
		padding: 1em;
		color: white;
		background-color: gray;
		clear: left;
		text-align: center;
	}

	nav {
		float: left;
		max-width: 160px;
		margin: 0;
		padding: 1em;
	}

	nav ul {
		list-style-type: none;
		padding: 0;
	}
	   
	nav ul a {
		text-decoration: none;
	}

	article {
		margin-left: 170px;
		border-left: 1px solid gray;
		padding: 1em;
		overflow: hidden;
	}
</style>
<title> Chinese Zodiac </title>
</head>
<body>

	<div class = "container">
	<header>
		<h1> <?php include("include\inc_header.php"); ?></h1>
	</header>
	
	<nav>
		<ul>
			<?php include("include\inc_button_nav.php");?>	
		</ul>	
	</nav>
	
	
	<div><?php include("include\inc_text_links.php"); ?> </div>
	
	
	<article>
		<?php 
		include('include/inc_site_counter.php');
			if (isset($_GET['page'])) {
				switch ($_GET['page']) {
					case 'site_layout':
						include('include/inc_site_layout.php');
						break;
					case 'control_structures':
						include('include/' .
							'inc_control_structures.php');
						break;
					case 'string_functions':
						include('include/' .
							'inc_string_functions.php');
						break;
					case 'web_forms':
						include('include/inc_web_forms.php');
						break;
					case 'midterm_assessment':
						include('include/inc_midterm_assessment.php');
						break;
					case 'state_information':
						include('include/' .
							'inc_state_information.php');
						break;
					case 'final_project':
						include('include/' .
							'inc_final_project.php');
						break;
					case 'home_page': // A value of
									  // 'home_page' means
										// to display the
										// default page
					default:
						include('include/inc_home.php');
						break;
				}
			}
			else // If no button has been selected, then display
			// the default page
			include('include/inc_home.php');
		?>
		
	</article>
	
   
   <footer>
		<?php include("include\inc_footer.php"); ?>  
   </footer>

   </div>
</body>
</html>