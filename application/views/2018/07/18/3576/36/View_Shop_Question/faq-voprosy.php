<div class="row box-comment">
    <div class="col-sm-12">
        <img class="quote-left" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-l.png">
        <div class="box-comment-text">
            <div class="text">
                <h4>Question</h4>
                <?php echo $data->values['text']; ?>
            </div>
            <div class="answer">
                <h4>Answer</h4>
                <?php echo $data->values['answer_text']; ?>
            </div>
        </div>
        <img class="quote-right" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-r.png">
    </div>
</div>