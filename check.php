<?php
if ($_POST){
    try{
        $PDO = new PDO('mysql:host='.$_POST['host'].';charset=UTF8',$_POST['user'],$_POST['password']);
        $prepare = $PDO->prepare('SELECT VERSION();');
        $prepare->execute();
        $row = $prepare->fetch();
        $PDO = $prepare = null;
        preg_match('/^[\d.]+/',$row[0],$version);
        exit('最低版本要求为5.5.0，当前版本为'.$version[0].'，'.($version[0]>=5.5 ? '<span class="green">支持</span>' : '<span class="red">不支持</span>'));
    }catch(Exception $e){
        exit($e->getMessage());
    }
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>《昱杰订单管理系统（ThinkPHP版）》运行环境检测</title>
<script type="text/javascript" src="public/base/jquery.js"></script>
<script type="text/javascript" src="public/base/H-ui/H-ui.min.js"></script>
<script type="text/javascript" src="public/admin/js/Common.js"></script>
<link rel="stylesheet" type="text/css" href="public/base/H-ui/H-ui.min.css">
<link rel="stylesheet" type="text/css" href="public/base/styles/Basic.css">
<script type="text/javascript">
$(function(){
	$('.btn').on('click',function(){
		$.ajax({
			type : 'POST',
			url : 'check.php',
			data : {
				host : $('input[name=host]').val(),
				user : $('input[name=user]').val(),
				password : $('input[name=password]').val()
			},
			success : function(data){
				$('.mysql_version').html(data);
			}
		});
	});
});
</script>
</head>

<body style="width:95%;">
<p>PHP版本：最低版本要求为7.1.0，当前版本为<?php echo phpversion();?>，<?php echo version_compare(PHP_VERSION,'7.1.0','>=') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>MySQL版本：<?php if (version_compare(PHP_VERSION,'7.1.0','<')){?>请先解决PHP版本过低的问题<?php }elseif (!extension_loaded('pdo') || !extension_loaded('pdo_mysql')){?>请先开启pdo和pdo_mysql扩展<?php }else{?><span class="mysql_version"></span><input type="text" name="host" class="input-text" placeholder="MySQL服务器地址"><input type="text" name="user" class="input-text" placeholder="MySQL用户名"><input type="text" name="password" class="input-text" placeholder="MySQL密码"><input type="button" value="查看" class="btn btn-primary radius"><?php }?></p>
<p>curl扩展：<?php echo extension_loaded('curl') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>gd2扩展：<?php echo extension_loaded('gd') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>mbstring扩展：<?php echo extension_loaded('mbstring') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>openssl扩展：<?php echo extension_loaded('openssl') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>pdo扩展：<?php echo extension_loaded('pdo') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
<p>pdo_mysql扩展：<?php echo extension_loaded('pdo_mysql') ? '<span class="green">支持</span>' : '<span class="red">不支持</span>';?></p>
</body>
</html>