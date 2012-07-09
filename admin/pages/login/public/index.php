<form action="/connexion.html?next=<?=rawurlencode(Bob::x('ne',$_REQUEST,'next'))?>" class="login" method="post">
    <h3>Connexion</h3>
    
    <?php if($this->hasErrors()) { ?>
    <div class="error"><?=$this->displayErrors()?></div>
    <?php } ?>
	
    <div class="field">
    	<label>Courriel :</label>
        <input type="text" name="email" class="text" style="width:250px;" />
        <div class="clear"></div>
    </div>
	
    <div class="field">
    	<label>Mot de passe :</label>
        <input type="password" name="pwd" class="text" style="width:250px;" />
        <div class="clear"></div>
    </div>
    
    <p class="field submit">
    	<button type="submit">Connexion</button>
    </p>
</form>