<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if($post->ID==28){
    $args=array(
        'numberposts'=>400,
        'category'=>14,//es la categoria de foertas de trabajo
    );
    $ofers=get_posts($args);
    if(count($ofers)>0){
        echo '<ul class="ofertas">';
        foreach($ofers as $of){
            $perm=get_permalink($of->ID);
            ?>
<li>
    <a href="<?=$perm?>">
        <label><?=$of->post_title?></label><br/>
        <span><?=substr(strip_tags($of->post_content),0,300)?><?php if(strlen($of->post_content)>300){echo "...";} ?></span>
    </a>
    <div class="readmore" style="text-align: right;">
        <a href="<?=$perm?>">Leer más »</a>
    </div>
</li>
<?php
        }
echo "</ul>";
    }
}
?>
