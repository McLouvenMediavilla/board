<h1>All threads</h1>
<?php 
//$page_threads = array_chunk($threads, 3);
//$page_count = count($page_threads);
//var_dump($page_threads);

//for ($i = 0; $i < $page_count; $i++) :?>
<ul>
	<?php foreach ($threads as $v): ?>
	<?php //foreach ($page_threads[0] as $v): ?>
	<li>
		<a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
		<?php eh($v->title) ?>
	    </a>
	</li>
	<?php endforeach ?>
</ul>
<?php //endfor ?>
<?php //for loop page numbers?>
<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
<a class="btn btn-large btn-primary" href="<?php eh(url('user/login')) ?>">Login</a>
