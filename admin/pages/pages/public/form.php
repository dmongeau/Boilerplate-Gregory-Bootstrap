<?php if(!isset($Item) || $Item->isNew()) { ?>
<h1>Ajouter une page</h1>
<form action="/pages/add.html" method="post" enctype="multipart/form-data">
<?php } else { ?>
<h1>Modifier cette page</h1>
<form action="/pages/edit.html?id=<?=$Item->getPrimary()?>" method="post" enctype="multipart/form-data">
<?php } ?>

	<?php if($this->hasMessages('error')) { ?>
    <div class="error"><?=$this->getMessagesAsHTML('error')?></div>
    <?php } ?>
    
    <h3>Section</h3>
    
    <div class="field">
        <label>Section du site :</label>
        <div class="input">
            <select name="section">
            	<option value="">--</option>
                <?php foreach($this->data['sites'] as $siteKey => $site) { ?>
                <optgroup label="<?=$site['name_fr']?>">
	                <?php
					
                    foreach($site['sections'] as $sectionKey => $section) {
						
						$key = $siteKey.'_'.$sectionKey;
						$selected = SEL(NE($item,'section',NE($_GET,'section')),$key,'string');
						
						?><option value="<?=$key?>" <?=$selected?>><?=$section['name_fr']?></option><?php
                    }
					
					?>
                </optgroup>
                <?php } ?>
            </select>
        </div>
    </div>
    
    <?php if(isset($Item) && !$Item->isNew()) { ?>
    <div class="field">
        <label>Adresse de la page :</label>
        <div class="input">
            Français : <a href="<?=$Item->permalink('fr')?>"><?=$Item->permalink('fr')?></a><br/>
            Anglais : <a href="<?=$Item->permalink('en')?>"><?=$Item->permalink('en')?></a>
        </div>
    </div>
    <?php } ?>
    
    <div class="spacer-small"></div>
    <div class="hr"></div>
    <div class="spacer-small"></div>
    
    <h3>Contenu</h3>

	
    <div class="contentTabs">
    	<ul>
        	<li><a href="#page-fr">Français</a></li>
        	<li><a href="#page-en">Anglais</a></li>
        </ul>
        
        <div id="page-fr">
        	<div class="field">
		    	<label>Titre :</label>
		        <div class="input">
		        	<input type="text" class="text" name="title_fr" value="<?=NE($item,'title_fr')?>" />
		        </div>
		    </div>
	        
	        <div class="spacer-small"></div>
		
			<div class="field">
		    	<label>Contenu :</label>
		        <div class="input">
		        	<textarea name="body_fr" id="body_fr"><?=NE($item,'body_fr')?></textarea>
		        </div>
		    </div>
        </div>
        
        <div id="page-en">
        	<div class="field">
		    	<label>Titre :</label>
		        <div class="input">
		        	<input type="text" class="text" name="title_en" value="<?=NE($item,'title_en')?>" />
		        </div>
		    </div>
	        
	        <div class="spacer-small"></div>
		
			<div class="field">
		    	<label>Contenu :</label>
		        <div class="input">
		        	<textarea name="body_en" id="body_en"><?=NE($item,'body_en')?></textarea>
		        </div>
		    </div>
        </div>
    
    </div>
    
    <div class="spacer-small"></div>
    <div class="hr"></div>
    <div class="spacer-small"></div>
    
    <div id="documents">
    
	    <div class="buttons fright mt5">
	        <a href="/documents/add.html?section=<?=rawurlencode($key)?>" class="button button-small addDocument">Ajouter un document</a>
	    </div>
	    <h3>Documents</h3>
	    
	    
	    
	    <div class="list">
		    <ul><?php
			
				if(sizeof($documents)) {
					
					foreach($documents as $_document) {
						$_Item = new Document();
						$_Item->setData($_document);
						echo $_Item->getListHTML();
					}
					
				}
			
				?>
	            <li class="document add">
    				<input type="hidden" name="documents_did[]" value="" />
                	<div class="icons">
                    	<a href="#" class="delete" style="display:none;">Supprimer</a>
                    </div>
		        	<div class="field fleft mr20">
				    	<label>Titre du document :</label>
				        <div class="input">
				        	<input type="text" class="text" name="documents_title[]" />
				        </div>
				    </div>
		        	<div class="field fleft mr20">
				    	<label>Langue :</label>
				        <div class="input">
				        	<select name="documents_lang[]">
                            	<option value="">Toutes les langues</option>
                            	<option value="fr">Français</option>
                            	<option value="en">Anglais</option>
                            </select>
				        </div>
				    </div>
		        	<div class="field fleft">
				    	<label>Sélectionnez un document :</label>
				        <div class="input">
				        	<input type="file" name="documents_file[]" />
				        </div>
				    </div>
                    <div class="clear"></div>
			    </li>
            </ul>
	    </div>
    
    </div>
    
    
    <div class="spacer-small"></div>
    <div class="hr"></div>
    <div class="spacer-small"></div>
    
    <div class="buttons" align="right">
    	<a href="/pages/" class="button">Annuler</a> 
    	<button type="submit">Enregistrer</button>
    </div>
	

</form>