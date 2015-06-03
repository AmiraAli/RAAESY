
<div class="col-md-4" id="createCategoryDiv">
		<div class="panel panel-success">

			<div class="panel-heading">New Category</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-6 control-label">Category Name</label>
						<div class="col-md-6">
	    					<input type="text" class="form-control" id="{{ $sectionid }},categoryname" placeholder="Enter Section Name" name="name">
	    					<input type="hidden" class="form-control" id="{{ $sectionid }},sectionid"  value="{{ $sectionid }}">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" onclick="saveCategory('{{ $sectionid }}')" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
