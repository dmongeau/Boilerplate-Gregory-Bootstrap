<?php if($this->hasMessages('success')) { ?>
<div class="success"><?=$this->getMessagesAsHTML('success')?></div>
<?php } ?>

<?php foreach($tree as $site => $sections) { ?>
<div class="spacer-small"></div>
<div class="site">
	<h3><?=$this->data['sites'][$site]['name_fr']?></h3>
	<?php foreach($sections as $key => $section) { ?>
		<div class="buttons fright">
			<a href="/pages/add.html?section=<?=rawurlencode($site.'_'.$key)?>" class="button button-small">Ajouter une page</a>
		</div>
	    <h4><?=$section['name_fr']?></h4>
        <div class="list">
            <ul><?php
            
                if(sizeof($section['items'])) {
                    
                    foreach($section['items'] as $_item) {
                        $_Item = new Page();
                        $_Item->setData($_item);
                        echo $_Item->getListHTML();
                    }
                    
                } else {
                    ?><li class="noresult">Aucune page dans cette section</li><?php
                }
            
            ?></ul>
        </div>
	<?php } ?>
</div>
<div class="hr"></div>
<?php } ?>

<div class="clear"></div>