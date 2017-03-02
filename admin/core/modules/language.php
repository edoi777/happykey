<?php
if(empty($URIa[3])) {
	echo '<h1>Управление фразами</h1>';
	if(!empty($_POST['q'])) {
		$_POST['q']='%'.$_POST['q'].'%';
		$WHERE = ' WHERE name LIKE ? OR value_en LIKE ? OR value_ru LIKE ?';
		$WHERE_ARR = array($_POST['q'],$_POST['q'],$_POST['q']);
	}
	else {
		$WHERE = '';
		$WHERE_ARR = array();
	}
	$q = $db->getRows('SELECT * FROM words'.$WHERE.' ORDER BY name ASC', $WHERE_ARR);
	echo '<table style="margin-top:20px;" class="table table-striped"><tr><th>Название</th><th>Значение EN</th><th>Значение RU</th><th>Действия</th></tr>';
	foreach($q as $line) {
		echo '<tr><td>'.$line['name'].'</td><td>'.htmlspecialchars($line['value_en']).'</td><td>'.htmlspecialchars($line['value_ru']).'</td><td><a class="btn btn-warning btn-xs" href="/mod/language/edit/'.$line['id'].'"><span class="glyphicon glyphicon-pencil"></span></a> <a class="btn btn-danger btn-xs" href="/mod/language/remove/'.$line['id'].'"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
	}
	echo '</table>';
}
else if($URIa[3]=='add') {
	if($_POST['token']==$_SESSION['admin_token']) {
		$db->insertRow('INSERT INTO words SET name = ?, value_en = ?, value_ru = ?', array($_POST['name'],$_POST['value_en'],$_POST['value_ru']));
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/mod/language');exit;
	}
	echo '<h1>Добавить новую фразу</h1>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
<input style="margin-bottom:6px;" type="text" required placeholder="Название [a-zA-Z0-9_-] (используется в шаблонах)" name="name" class="form-control"/>
<input style="margin-bottom:6px;" type="text" required placeholder="Значение на английском" name="value_en" class="form-control"/>
<input style="margin-bottom:6px;" type="text" required placeholder="Значение на русском" name="value_ru" class="form-control"/>
<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Добавить" />
</form>';
}
else if($URIa[3]=='edit' && is_numeric($URIa[4])) {
	if($_POST['token']==$_SESSION['admin_token']) {
		$db->updateRow('UPDATE words SET name = ?, value_en = ?, value_ru = ? WHERE id = ?', array($_POST['name'],$_POST['value_en'],$_POST['value_ru'], $URIa[4]));
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/mod/language');exit;
	}
	$q = $db->getRow('SELECT * FROM words WHERE id = ?', array($URIa[4]));
	echo '<h1>Редактировать фразу</h1>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
	<input style="margin-bottom:6px;" type="text" value="'.$q['name'].'" required placeholder="Название [a-zA-Z0-9_-] (используется в шаблонах)" name="name" class="form-control"/>
	<input style="margin-bottom:6px;" type="text" value="'.htmlspecialchars($q['value_en']).'" required placeholder="Значение на английском" name="value_en" class="form-control"/>
	<input style="margin-bottom:6px;" type="text" value="'.htmlspecialchars($q['value_ru']).'" required placeholder="Значение на русском" name="value_ru" class="form-control"/>
	<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
	<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Редактировать" />
</form>';
}
else if($URIa[3]=='remove' && is_numeric($URIa[4])) {
	if($_POST['token']==$_SESSION['admin_token']) {
		$db->deleteRow('DELETE FROM words WHERE id = ?', array($URIa[4]));
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/mod/language');exit;
	}
	echo '<h1>Удалить фразу</h1><p>Подтвердите удаление</p>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
	<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
	<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Удалить" />
</form>';
}
?>
<script>
$(document).ready(function() {
	<?php if($URIa[3]==NULL){ ?>
	$('#search_form input,#search_form button').removeAttr('disabled');
	$('#action_bar').html('<button onclick="top.location.href=\'/mod/language/add\';" type="button" class="btn btn-success navbar-btn">Добавить</button>');
	<?php } else { ?>
	$('#action_bar').html('<button onclick="top.location.href=\'/mod/language\';" type="button" class="btn btn-success navbar-btn">Назад</button>');
	<?php } ?>
});
</script>
