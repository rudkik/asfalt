<?php if($data->values['is_answer'] == 1){ ?>
    <div hidden="hidden">
        <div itemscope itemtype="http://schema.org/Question">
            <h1 itemprop="name"><?php echo Func::trimTextNew($data->values['question_text'], 120); ?></h1>
            <div itemprop="acceptedAnswer" itemscope itemtype="http://schema.org/Answer">
                <meta itemprop="upvoteCount" content="66" />
                <div itemprop="text"><?php echo $data->values['question_text']; ?></div>
            </div>
            <div itemprop="suggestedAnswer" itemscope itemtype="http://schema.org/Answer">
                <meta itemprop="upvoteCount" content="100" />
                <div itemprop="text"><?php echo $data->values['answer_text']; ?></div>
            </div>
        </div>
    </div>
<?php } ?>