<a class="btn btn-inverse" href="/">Home</a>
<a class="btn btn-inverse" href="<?php eh(url('user/logout')) ?>">Logout</a>
<h1>
<?php 
if (!isset($_SESSION['username'])) {
    header('Location: user/login');
} else {
    echo "Hello {$_SESSION['username']}";
}
?>
</h1>
<h2>All threads</h2>

<ul>
    <?php foreach ($threads as $v): ?>
    <li>
        <a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
        <?php eh($v->title) ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>

Page <b><?php eh($pagenum) ?></b> of <b><?php eh($last) ?></b><br />
<?php echo $paginationCtrls; ?><br />
<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>