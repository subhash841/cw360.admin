<section class="content">
	<div class="container-fluid">
		<div class="block-header"></div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Poll Details</h2><br>
						<div id="viewPollDetails">
							<div class="pbody">
								<div class="row">
									<div class="col-sm-4">
										<span>Topic Name:</span><h5><?= @$topic ?></h5>
									</div>
									<!-- <div class="col-sm-4">
										<span>Status:</span><h5>dummy data</h5>
									</div> -->
									<div class="col-sm-4">
										<span>Created at: </span><h5><?= date("d-m-Y", strtotime($created_date)); ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Question:</span><h5>dummy data</h5>
									</div>
									<div class="col-sm-4">
										<span>Description: </span><h5><?= @$description ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Is Approved: </span><h5><?= @$is_approved ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Poll:</span><h5><?= @$poll ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Comments: </span><h5><?= $polls['polls']['total_polls']; ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Replies: </span><h5><?= $replies['replies']['total_replies']; ?></h5>
									</div>
									<div class="col-sm-4">
										<span>No of Votes: </span><h5><?= @$total_votes ?></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>