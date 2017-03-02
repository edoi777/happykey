
<?
$where = '';
if(!empty($_POST['user'])){
	$where = " WHERE id = '".$_POST['user']."'";
	$rows = $db->getRow('SELECT * FROM users '.$where);
}else if(!empty($_POST['name'])){
	if($_POST['ban']=='on') $_POST['ban']='1';
	else $_POST['ban']='0';
	foreach($_POST as $key=>$value) {
        $db->query('UPDATE users SET `'.$key.'` = \''.$value.'\' WHERE id = '.$_POST['id'].'');
	}
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin/mod/users");
}else if(!empty($_POST['delete'])){
	$db->deleteRow('DELETE FROM users WHERE id = ?', array($_POST['delete']));
	header("Location: http://".$_SERVER['HTTP_HOST']."/admin/mod/users");
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}




?>
<? include('top.php'); menu('Пользователь '.$rows['name'].'');?>
<div class="page-content">     

            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="panel panel-green">
                                            <div class="panel-heading">
                                                Общее описание</div>
                                            <div class="panel-body pan">
                                         <form enctype="multipart/form-data" method="POST">
										     
                                                <div class="form-body pal">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                               <label for="calssCase" class="control-label">
                                                                    Имя </label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-share"></i>
                                                                    <input id="calssCase" type="text" class="form-control" name="name" value="<?=$rows['name']?>"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                    ID сети</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="steam" value="<?=$rows['steam']?>"></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="caseSub" class="control-label">
                                                          Трейд ссылка</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-pencil"></i>
                                                            <input id="caseSub" type="text" placeholder="" class="form-control" name="link" value="<?=$rows['link']?>"></div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="casePrice" class="control-label">
                                                           Аватар</label>
                                                        <div class="input-icon right">
                                                            <i class="fa fa-credit-card"></i>
                                                            <input id="casePrice" type="text" placeholder="" class="form-control" name="avatar" value="<?=$rows['avatar']?>"></div>
                                                    </div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-groups">
																						<div id="baseimg">
																							<img src="<?=$rows['avatar']?>" width="200" height="200">
																						  </div></div>
													</div>	
													<div class="col-md-6">   												
														<div class="form-group">
															<ul id="checkbox">
															<? if($rows['ban']=="1") echo'<input class="checkbox" type="checkbox" name="ban" id="chk_visible" checked><label for="chk_visible">Разбанить</label>';else echo '<input class="checkbox" type="checkbox" name="ban" id="chk_visible"><label for="chk_visible">Забанить</label>'; ?>

															</ul>
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
                                                                                                            <div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                    Денег</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="money" value="<?=$rows['money']?>"></div>
                                                            </div>
															<div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                    Админ</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="admin" value="<?=$rows['admin']?>"></div>
                                                            </div>
															<div class="form-group">
                                                                <label for="caseName" class="control-label">
                                                                    Fake</label>
                                                                <div class="input-icon right">
                                                                    <i class="fa fa-bolt"></i>
                                                                    <input id="caseName" type="text" placeholder="" class="form-control" name="fake" value="<?=$rows['fake']?>"></div>
                                                            </div>															
                                                </div>
                                                <div class="form-actions text-right pal">
												     <input type="hidden" name="id" value="<?=$_POST['user']?>">
                                                     <input id="submit_form" type="submit" class="btn btn-primary" value="Сохранить изменения">
                                                </div>
                                                
                                            </div>
                                        </div>
										</form>
</div>   </div></div>
        </div>








