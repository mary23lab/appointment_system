<div>
    <!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-danger border-0 elevation-1 navbar-dark">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>

    	<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" data-widget="fullscreen" href="#" role="button">
					<i class="fas fa-expand-arrows-alt"></i>
				</a>
			</li>

			<!-- Navbar Search -->
			<li class="nav-item pt-1">
				<a class="btn btn-default btn-sm mr-2" href="../logout.php" role="button">
					Logout
					<i class="fas fa-sign-out-alt ml-1 text-danger"></i>
				</a>
			</li>
		</ul>
	</nav>
  	<!-- /.navbar -->

  	<!-- Main Sidebar Container -->
	<aside class="main-sidebar main-sidebar-custom elevation-1 sidebar-light-danger">
		<!-- Brand Logo -->
		<div class="border-bottom text-center w-100 p-3 small text-bold">
            <img src="../../assets/system-images/logo.png" class="mb-2" height="50" alt="User Image"><br>
            <h3 class="text-bold" style="font-family: Lobster">Pet Plus</h3>
        </div>

		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar user (optional) -->
			<div class="user-panel mt-2 py-2 mb-3 d-flex border-0 bg-light">
				<div class="image">
					<img src="../../assets/user-images/<?= $_SESSION['profile_picture']; ?>" class="mt-2 img-circle elevation-1" style="margin-top: 6px" alt="User Image">
				</div>

				<div class="info">
					<a href="#" class="d-block text-overflow" style="font-size: 13px !important">
                        <?= $_SESSION['username']; ?><br>
						<small class="text-bold">Role: <?= ucfirst($userProfile['role']); ?></small>
					</a>
				</div>
			</div>

     		<!-- Sidebar Menu -->
			<nav class="mt-2" style="font-size: 15px !important">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="dashboard.php" class="d-flex align-content-center nav-link <?= strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">dashboard</span>
							<p>Dashboard</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="appointments.php" class="d-flex align-content-center nav-link <?= strpos($_SERVER['REQUEST_URI'], 'appointments.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">event</span>
							<p>Appointments</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="pets.php" class="d-flex align-content-center nav-link <?= strpos($_SERVER['REQUEST_URI'], 'pets.php') !== false || strpos($_SERVER['REQUEST_URI'], 'pet-details.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">pets</span>
							<p>Pet Records</p>
						</a>
					</li>

                    <li class="nav-item">
						<a href="chats.php" class="nav-link d-flex align-content-center <?= strpos($_SERVER['REQUEST_URI'], 'chats.php') !== false || strpos($_SERVER['REQUEST_URI'], 'chats-details.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">chat</span>
							<p>Chats</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="feedback.php" class="nav-link d-flex align-content-center <?= strpos($_SERVER['REQUEST_URI'], 'feedback.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">report</span>
							<p>Feedback</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="reminders.php" class="nav-link d-flex align-content-center <?= strpos($_SERVER['REQUEST_URI'], 'reminders.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">notifications</span>
							<p>Reminders</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="audit-trails.php" class="nav-link d-flex align-content-center <?= strpos($_SERVER['REQUEST_URI'], 'audit-trails.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">insights</span>
							<p>Audit Trails</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="my-account.php" class="nav-link d-flex align-content-center <?= strpos($_SERVER['REQUEST_URI'], 'my-account.php') !== false ? 'active' : '' ?>">
							<span class="nav-icon material-icons-outlined">manage_accounts</span>
							<p>My Account</p>
						</a>
					</li>
				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		</div>
    	<!-- /.sidebar -->
  	</aside>
	<!-- / .Main Sidebar Container -->
</div>