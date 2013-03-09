<?php include 'includes/core/document_head.php'?>
	<div id="pjax">
		<div id="wrapper" data-adminica-nav-top="3" data-adminica-nav-inner="6">
			<?php include 'includes/components/topbar.php'?>
			<?php include 'includes/components/sidebar.php'?>
			<?php include 'includes/components/stackbar.php'?></div><!-- Closing Div for Stack Nav, you can boxes under the stack before this -->
			<div id="main_container" class="main_container container_16 clearfix">
				<?php include 'includes/components/navigation.php'?>
				<div class="flat_area grid_16">
					<h2>Dialog Window <small>aka Popup Window, Modal Window, lightbox, etc.</small>
						<div class="holder">
							<?php include 'includes/components/dynamic_loading.php'?>
						</div>
					</h2>
					<p>At vero eos et accusamus et iusto odio <a href="#">dignissimos ducimus qui blanditiis</a> praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et <strong>expedita distinctio</strong>. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
				</div>
				<div class="box grid_16 circle">
					<div class="indented_button_bar circle">
						<div class="columns no_lines">
							<div class="col_20">
								<div class="section clearfix">
									<button class="full_width light large_icon icon_top on_dark dialog_button circle" data-dialog="dialog_welcome">
										<img src="images/icons/large/grey/speech_bubble_2.png">
									</button>
								</div>
							</div>
							<div class="col_20">
								<div class="section clearfix">
									<button class="full_width light large_icon icon_top on_dark dialog_button circle" data-dialog="dialog_form">
										<img src="images/icons/large/grey/create_write.png">
									</button>
								</div>
							</div>
							<div class="col_20">
								<div class="section clearfix">
									<button class="full_width light large_icon icon_top on_dark dialog_button circle" data-dialog="dialog_register">
										<img src="images/icons/large/grey/pencil.png">
									</button>
								</div>
							</div>
							<div class="col_20">
								<div class="section clearfix">
									<button class="full_width light large_icon icon_top on_dark dialog_button circle" data-dialog="dialog_delete">
										<img src="images/icons/large/grey/trashcan_2.png">
									</button>
								</div>
							</div>
							<div class="col_20">
								<div class="section clearfix">
									<button class="full_width light large_icon icon_top on_dark dialog_button circle" data-dialog="dialog_logout">
										<img src="images/icons/large/grey/locked_2.png">
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php include 'includes/core/document_foot.php'?>