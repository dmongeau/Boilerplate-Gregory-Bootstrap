<?php if($this->hasMessages('success')) { ?>
<div class="success"><?=$this->getMessagesAsHTML('success')?></div>
<?php } ?>


<div class="tabs">
	<ul>
	<?php foreach($tree as $site => $sections) { ?>
		<li><a href="#site-<?=$site?>"><?=$this->data['sites'][$site]['name_fr']?></a></li>
	<?php } ?>
	</ul>
    
	<?php foreach($tree as $site => $sections) { ?>
    <div id="site-<?=$site?>">
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
	<?php } ?>
</div>

<div class="clear"></div>