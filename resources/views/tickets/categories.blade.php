<div class="list-group">
	<a href="#" class="list-group-item active" id="cat_all" onclick="searchByCat('cat_all', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ count($tickets) }}</span><strong>All categories</strong></a>
	@foreach ($categories as $category)
		   <a href="#" class="list-group-item" id="cat_{{ $category->category_id }}" onclick="searchByCat('cat_{{ $category->category_id }}', <?php if(Auth::user()->type === 'admin'){echo 1; }else{ echo 0;} ?>)"><span class="badge">{{ $category->count }}</span>{{ $category->name }}</a>  			         
    @endforeach			  
</div>