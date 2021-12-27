<section class="content">
	<div class="container-fluid">
		<div class="block-header"></div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Article Details</h2><br>
						<div id="viewPollDetails">
							<div class="pbody">
								<div class="row">
									<div class="col-sm-4">
										<span>Topics:</span><h5><?= @$topic ?></h5>
									</div>
									<!-- <div class="col-sm-4">
										<span>Status:</span><h5>dummy data</h5>
									</div> -->
									<div class="col-sm-4">
										<span>Created at: </span><h5><?= date("d-m-Y", strtotime($created_date)); ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Question:</span><h5><?= @$question ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Description: </span><h5><?= @$description ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Is Approved: </span><h5><?= @$is_approved ?></h5>
									</div>
									<div class="col-sm-4">
										<span>Comments: </span><h5><?= $articles['articles']['total_articles']; ?></h5>
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