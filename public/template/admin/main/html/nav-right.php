<?php 
	$id  		= Session::get('user')['info']['id'];
	$model 		= new Model();
	$query[] 	= "SELECT `id`, `username`, `fullname`, `created`, `avatar`";
	$query[] 	= "FROM `".TBL_USER."`";
	$query[]	= "WHERE `id` = '".$id."'";
	$query 		= implode(" ", $query);
	$infoItem	= $model->fetchRow($query);
	$username 	= $infoItem['username'];
	$created	= $infoItem['created'];
	$imgAvatar 	= $infoItem['avatar'];

	$linkLogout = URL::createLink('admin', 'index', 'logout');
	$linkProfile= URL::createLink('admin', 'index', 'profile');
 ?>
<nav class="navbar navbar-static-top" role="navigation">
	<!-- Sidebar toggle button-->
	<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas"
		role="button"> <span class="sr-only">Toggle navigation</span> <span
		class="icon-bar"></span> <span class="icon-bar"></span> <span
		class="icon-bar"></span>
	</a>
	<div class="navbar-right">
		<ul class="nav navbar-nav">
			<!-- User Account: style can be found in dropdown.less -->
			<li class="dropdown user user-menu"><a href="#"
				class="dropdown-toggle" data-toggle="dropdown"> <i
					class="glyphicon glyphicon-user"></i> <span><?php echo $username ?> <i
						class="caret"></i></span>
			</a>
				<ul class="dropdown-menu">
					<!-- User image -->
					<li class="user-header bg-light-blue"><img src="<?php echo UPLOAD_URL.'avatar'.DS.$imgAvatar;?>"
						class="img-circle" alt="User Image" />
						<p>
							<?php echo $username ?> - Web Developer <small>Member since <?php echo $created ?></small>
						</p></li>
					<!-- Menu Body -->
					
					<!-- Menu Footer-->
					<li class="user-footer">
						<div class="pull-left">
							<a href="<?php echo $linkProfile ?>" class="btn btn-default btn-flat">Profile</a>
						</div>
						<div class="pull-right">
							<a href="<?php echo $linkLogout ?>" class="btn btn-default btn-flat">Sign out</a>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>