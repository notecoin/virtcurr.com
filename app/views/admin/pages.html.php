<h3>Site Pages</h3>
<script src="/ckeditor/ckeditor.js"></script>
<ul class="nav nav-pills">
	<?php foreach($templates as $tt){		
		if(	$this->_request->args[0]==$tt['name']){
		$page_content = $tt['content'];
		$page_name = $tt['name'];
		}
	?>
	<li <?php if(	$this->_request->args[0]==$tt['name']){echo "class='active'";}?> ><a href="/admin/pages/<?=$tt['name']?>"><?=ucfirst($tt['name'])?></a></li>
	<?php }?>
</ul>
<div>
<?php 
if($settings[$page]!=''){
	$page_template = 	$settings[$page];
}else{
	$page_template = $page_content;
}
?>
	<h3><?=strtoupper($page_name)?></h3>
	<form action="/admin/pages/<?=$page_name?>" method="post">
		<textarea name="template" id="template" class="ckeditor"><?=$page_template?></textarea><br>
		<small>To copy from template, delete all content and click save!</small><br>
		<input type="submit" value="Save" class="btn btn-primary">
	</form>
</div>