<script>
    $('#basic-addon1').click(function(){
	 $('#codegenerator').val((Math.random()+'').slice(2, 2 + Math.max(1, Math.min(10, 15))));		
	});
	</script>
<?
if(empty($URIa[4])) {
		include('top.php'); menu('Управление ваучерами');
?>

<h1> <a class="btn btn-warning" href="/admin/mod/vauchers/add">Добавить</a></h1>
<?
	$rows = $db->getRows('SELECT * FROM codes');
	echo '<table style="margin-top:20px;" class="table table-striped"><tr><th>ID</th><th>Код</th><th>Цена</th><th>Действия</th></tr>';
	foreach($rows as $row) {
		echo '<tr><td>'.$row['id'].'</td><td>'.$row['code'].'</td><td>'.$row['price'].' руб.</td><td><a class="btn btn-warning btn-xs" href="/admin/mod/vauchers/edit/'.$row['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a class="btn btn-danger btn-xs" href="/admin/mod/vauchers/remove/'.$row['id'].'"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>';
	}	
	echo '</table>';
	
}
else if($URIa[4]=='add') {
	$msg = '';
	if(isset($_POST['token']) AND $_POST['token']==$_SESSION['admin_token']) {
		if(!empty($_POST['price']) AND !empty($_POST['code'])) {		
			$db->insertRow('INSERT INTO codes SET code = ?, price = ?', array($_POST['code'],$_POST['price']));
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/vauchers');exit;
		}else{
			$msg = 'Заполните все поля';
		}
	}
	
	
	echo '<h1>Добавить фишку</h1>';
	echo '<div style="color:#ff0000">'.$msg.'</div>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
	<div class="input-group">
    <span class="input-group-addon" id="codegen">Код (ЖМИ)</span>
    <input name="code" id="codegenerator" type="text" class="form-control"  aria-describedby="basic-addon1">
    </div>
    <br>
    <div class="input-group">
    <span class="input-group-addon" id="basic-addon2">Цена</span>
    <input name="price" type="text" class="form-control"  placeholder="100" aria-describedby="basic-addon1">
    </div>
    <br>

	
	

<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Добавить" />
</form>';


}
else if($URIa[4]=='edit' && is_numeric($URIa[5])) {
	$q = $db->getRow('SELECT * FROM codes WHERE id = ?', array($URIa[5]));
	if($_POST['token']==$_SESSION['admin_token']) {
		if(!empty($_POST['price'])) {
			$db->updateRow('UPDATE codes SET price = ? WHERE id = ?', array($_POST['price'],$URIa[5]));
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/vauchers');exit;
		}
	}
	include('top.php'); menu('Редактивировать ваучер');
	echo '<div style="color:#ff0000">'.$msg.'</div>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
	    <div class="input-group">
    <span class="input-group-addon" id="basic-addon2">Цена </span>
    <input name="price" value="'.$q['price'].'" type="text" class="form-control"  placeholder="100" aria-describedby="basic-addon1">
    </div>
	</br>
<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Сохранить" />
</form>';

}
else if($URIa[4]=='remove' && is_numeric($URIa[5])) {
	if(isset($_POST['token']) && $_POST['token']==$_SESSION['admin_token']) {
		$db->deleteRow('DELETE FROM codes WHERE id = ?', array($URIa[5]));
		
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/vauchers');exit;
	}
	include('top.php'); menu('Удаление ваучера');
	echo '<h1>Удалить ваучер?</h1><p>Подтвердите удаление</p>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
	<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
	<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Удалить" />
</form>';
}

