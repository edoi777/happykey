
<?
if(empty($URIa[4])) {
$action = $_POST["action"];
if(isset($action)){
	
	switch ($action) {
		case 'deleteimg':
	        $where = " WHERE id = '".$_POST['case']."'";
	        $rows = $db->getRow('SELECT * FROM cases '.$where);
		    if (file_exists("..".$rows["img"])){
			    unlink("..".$rows["img"]);			
		    }
		break;
		case 'saveimg':
		    if(isset($_FILES['upload_image'])){
			    $file_name = $_FILES['upload_image']['name'];
			    $file_ext=strtolower(end(explode('.',$_FILES['upload_image']['name'])));
			    $expensions= array("jpeg","jpg","png");
                if(in_array($file_ext,$expensions)=== false){
                   die('not img');
                }
			    $img  = "../template/img/cases/".$file_name;
			    $sqlimg = "/template/img/cases/".$file_name;
			    move_uploaded_file($_FILES['upload_image']['tmp_name'],$img);
			    $db->updateRow('UPDATE cases SET img = ? WHERE id = ?', array($sqlimg,$_POST['case']));
		    }
		break;
		case 'editcase':	
		    $db->updateRow('UPDATE cases SET disp_name = ?,name = ?,status = ? WHERE id = ?', array($_POST['disp_name'],$_POST['name'],$_POST['status'],$_POST['case']));
		break;
	}
}

$where = '';
if(!empty($_POST['case'])){
	$where = " WHERE id = '".$_POST['case']."'";
	$rows = $db->getRow('SELECT * FROM cases '.$where);


	$rows2 = $db->getRows('SELECT * FROM itemsincases WHERE `game` = \''.$rows['name'].'\'');
	 $rows2;
}else if(!empty($_POST['delete'])){
	$db->deleteRow('DELETE FROM cases WHERE id = ?', array($_POST['delete']));
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin/mod/cases");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}




?>
<? include('top.php'); menu('Игра '.$rows['name'].'');?>
<div class="page-content">     

            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                                Общее описание</div>
                                            <div class="panel-body pan">
                                        
										     
                                                <div class="form-body pal">
												 <form enctype="multipart/form-data" method="POST">
												   <input type="hidden" name="action" value="editcase">
												   <input type="hidden" name="case" value="<?=$rows['id']?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                               <label for="calssCase" class="control-label">
                                                                    Имя </label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-share"></i>
                                                                    <input id="calssCase" type="text" class="form-control" name="disp_name" value="<?=$rows['disp_name']?>"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                    Name</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="name" value="<?=$rows['name']?>"></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
													 <div class="row">
		
													  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="casePrice" class="control-label">
                                                           Выпадение (0 - выпадает,1 - только фейкам,2-некому!)</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-credit-card"></i>
                                                            <input id="casePrice" type="text" placeholder="" class="form-control" name="status" value="<?=$rows['status']?>"></div>
                                                    </div>  </div>
													</div>
												<div class="form-actions text-right pal">
												     <input type="hidden" name="id" value="">
                                                     <input id="submit_form" type="submit" class="btn btn-primary" value="Сохранить изменения">
                                                </div>
												</form>
												<div class="row">
													<div class="col-md-6">
														<div class="form-groups"><?  if (strlen($rows["img"]) > 0 && file_exists("..".$rows["img"])) { ?>
															
																						<div id="baseimg">
																							<img src="<?=$rows['img']?>" width="200" height="200">
																						<form enctype="multipart/form-data" method="POST" name="delimg">
																						  <input type="hidden" name="action" value="deleteimg">
																						  <input type="hidden" name="case" value="<?=$rows['id']?>">
																						  	<a href="javascript:document.delimg.submit()"><img src="http://abali.ru/wp-content/uploads/2011/04/delete_32x32.png" width="32" height="32"></a>
																						</form>
														                               </div> 
														                        <? }else {?>
																				<label class="stylelabel">Основная картинка</label>
																				<form enctype="multipart/form-data" method="POST" >
																						<div id="baseimg-upload" style="display: -webkit-box;">
																						    <input type="hidden" name="action" value="saveimg">
																							<input type="hidden" name="case" value="<?=$rows['id']?>" />
																							<input type="file" name="upload_image" />
																							<input id="submit_form" type="submit" class="btn btn-primary" value="Сохранить изображение">
																						</div>
																				
																				</form>
																				 <? }?>
																				
											            </div>
													</div>	
					
												</div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                 <div class="col-lg-4">

                                   <div class="panel panel-green" style="background:#fff;">
                                            <div class="panel-heading">
                                                Управление</div>
                                            <div class="panel-body pan">
                                                <div class="form-body pal">
												<table style="margin-top:20px; text-align: center;" class="table table-bordered table-striped"><tr><th><center>Ключ</center></th><th><center>Управление</center></th></tr>

<?if($rows2):?>
	
<?foreach($rows2 as $row2):?>
												<tr>
	<td><?=$row2['key']?></td>
	<td><a class="btn btn-warning btn-xs" href="/admin/mod/case/edit/<?=$row2['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a class="btn btn-danger btn-xs" href="/admin/mod/case/remove/<?=$row2['id']?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
	</tr>
<?endforeach;?>

<?endif;?>	
	</table>
                                                      
                                                <div class="form-actions text-right pal">
											
													
                                                     <a href="/admin/mod/case/add/<?=$_POST['case']?>" class="btn btn-warning">Добавить ключ</a>
													 
                                                </div>
                                                
                                            </div>
                                        </div>
									
</div>   </div></div>
        </div>


<? }else {
if($URIa[4]=='add') {
	$msg = '';
	$rows = $db->getRow('SELECT * FROM cases WHERE id = ?', array($URIa[5]));
	if(isset($_POST['key'])) {
        if(isset($_FILES['codestxt'])){
				
			    $file_name = $_FILES['codestxt']['name'];
			    $file_ext=strtolower(end(explode('.',$_FILES['codestxt']['name'])));
			    $expensions= array("txt");
                if(in_array($file_ext,$expensions)=== false){
                   die('not txt');
                }
			    $img  = "../".$file_name;
			    $sqlimg = "/".$file_name;
			    move_uploaded_file($_FILES['codestxt']['tmp_name'],$img);
			   	$f = fopen($img, "r");
	            while (!feof($f)) { 
	                $arrM = explode(":",fgets($f)); 
					$db->query('INSERT INTO itemsincases SET `game` = \''.$_POST['game'].'\',`key` = \''.$arrM[1].'\'');
	                

	            }
	            fclose($f);
				header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/cases');exit;
		    }else {
				$db->query('INSERT INTO itemsincases SET `game` = \''.$_POST['game'].'\',`key` = \''.$_POST['key'].'\'');
			    header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/cases');exit;
			}
		
		
	}

	include('top.php'); menu('Добавить ключь к игре '.$rows['name'].'');
echo '<div style="color:#ff0000">'.$msg.'</div>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
  <div class="col-lg-6">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Игра</span>
   <input type="hidden" class="form-control" value="'.$rows['name'].'" placeholder="Username" name="game">
  <input disabled type="text" class="form-control" value="'.$rows['name'].'" placeholder="Username" aria-describedby="basic-addon1">
</div>
<br>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Ключь</span>
  <input name="key" type="text" class="form-control"  placeholder="ASDF-SD3F-DSDV-VZBN" aria-describedby="basic-addon1">
</div>
<br>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Загрузить несколько ключей</span>
  <input type="file" name="codestxt" />
</div>
	
<br><br>
   <input id="submit_form" type="submit" class="btn btn-primary" value="Сохранить изменения">
   
   </form>
  </div>

';


}else if($URIa[4]=='edit' && is_numeric($URIa[5])) {
	$msg = '';
	$rows = $db->getRow('SELECT * FROM itemsincases WHERE id = ?', array($URIa[5]));
	if(isset($_POST['name'])) {
	    foreach($_POST as $key=>$value) {
            $db->query('UPDATE itemsincases SET `'.$key.'` = \''.$value.'\' WHERE id = '.$URIa[5].'');
	    }
	    header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/cases');exit;
		
	}

	include('top.php'); menu('Редактировать ключ '.$rows['category'].' | '.$rows['rusname'].' с кейса '.$rows['case'].'');
	echo '<div style="color:#ff0000">'.$msg.'</div>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">
  <div class="col-lg-6">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Игра</span>
  <input disabled type="text" class="form-control" value="'.$rows['case'].'" placeholder="Username" aria-describedby="basic-addon1">
</div>
<br>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Ключь</span>
  <input name="category" type="text" class="form-control" value="'.$rows['key'].'" placeholder="Username" aria-describedby="basic-addon1">
</div>

<br>
<input id="submit_form" type="submit" class="btn btn-primary" value="Сохранить изменения">
   </form>
  </div>

';

}else if($URIa[4]=='remove' && is_numeric($URIa[5])) {
	$where = " WHERE id = '".$URIa[5]."'";
	$rows = $db->getRow('SELECT * FROM itemsincases '.$where);
	if(isset($_POST['token']) && $_POST['token']==$_SESSION['admin_token']){
		$db->deleteRow('DELETE FROM itemsincases WHERE id = ?', array($URIa[5]));
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/admin/mod/cases');exit;
	}
	include('top.php'); menu('Удаление ключа игры '.$rows['case'].'');
    echo '<h1>Удалить вещь '.$rows['name'].'?</h1><p>Подтвердите удаление '.$rows['category'].' | '.$rows['rusname'].' с кейса '.$rows['case'].'</p>';
	echo '<form style="margin-top:20px;" action="'.$_SERVER['REQUEST_URI'].'" method="post">
	<input type="hidden" name="token" value="'.$_SESSION['admin_token'].'"/>
	<input style="margin-bottom:6px;" class="btn btn-primary" type="submit" value="Удалить" />
</form>';
}
}
?>





