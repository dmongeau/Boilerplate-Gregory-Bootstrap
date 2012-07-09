
<h1>Supprimer une page</h1>
<form action="/pages/delete.html?id=<?=$Item->getPrimary()?>&confirm=1" method="post" enctype="multipart/form-data">

	<?php if($this->hasMessages('error')) { ?>
    <div class="error"><?=$this->displayMessages('error')?></div>
    <?php } ?>

	<fieldset>
    	<p>Êtes-vous certain de vouloir supprimer la page «<?=$item['title_fr']?>» ?</p>
    </fieldset>
    
    <div class="clear"></div>
    <div class="spacer-small"></div>
    
    <div class="buttons" align="right">
    	<a href="/pages/" class="button">Non</a> 
    	<button type="submit">Oui</button>
    </div>
	

</form>