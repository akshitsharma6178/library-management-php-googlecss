<footer class="page-footer margin0">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<h5 class="white-text">Heading to be added</h5>
				<p class="grey-text text-lighten-4">this should be the simple footer text to be written, which should include disclaimer related information</p>
			</div>
			<div class="col l4 offset-l2 s12">
				<h5 class="white-text">Navigation</h5>
				<ul>
					<li><a class="grey-text text-lighten-3" href="books.php">Books</a></li>
					<li><a class="grey-text text-lighten-3" href="staff.php">Library Staff</a></li>
					<li><a class="grey-text text-lighten-3" href="rules.php">Rules</a></li>
					<?php if (isLogin()){ ?>
					<li><a class="grey-text text-lighten-3" href="dashboard.php">Dashboard</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			© 2016 Copyright Text
			<a class="grey-text text-lighten-4 right" href="#">Some other link</a>
		</div>
	</div>
</footer>