<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>%{TITLE}</title>
    <meta name="description" content="%{DESCRIPTION}" />
    %{THUMBNAIL}
    %{HEAD}
    %{STYLESHEETS}
    %{SCRIPTS}
    <script type="text/javascript">
    <?php if(Gregory::get()->auth->isLogged()) { ?>
		var User = <?=json_encode(Gregory::get()->auth->getIdentity())?>
    <?php } else { ?>
		var User = null;
    <?php } ?>
	</script>
</head>
<body class="%{BODYCLASS}">
    <div id="page">
        <div id="header">
        	<div class="inner">
            	<h1 align="center"><a href="/">%{TITLE}</a></h1>
            </div>
        	<div id="menu">
            	<div class="inner">
                <?php if(Gregory::get()->auth->isLogged()) { ?>
                	<ul class="menu fright">
                    	<li><a href="/deconnexion.html">Déconnexion</a></li>
					</ul>
					<ul class="menu">
						<li class="<?=CLA(Gregory::get()->MODULE,'pages','current','string')?>"><a href="/pages/">Pages</a></li>
					</ul>
                    
					<div class="clear"></div>
				<?php } ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="content">
        	<div id="inner">
                %{CONTENT}
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
		<div id="footer">
			<div class="clear">&nbsp;</div>
		</div>
    </div>
</body>
</html>
