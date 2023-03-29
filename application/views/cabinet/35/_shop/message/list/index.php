<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Переписка</h3>
    </div>
    <div class="box-body chat" id="chat-box">
        <?php
        foreach ($data['view::_shop/message/one/index']->childs as $value) {
            echo $value->str;
        }
        ?>
    </div>
    <div class="box-footer">
        <div class="input-group">
            <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        </div>
        <div class="box-footer clearfix">
            <button class="pull-right btn btn-default" id="sendEmail">Отправить <i class="fa fa-arrow-circle-right"></i></button>
        </div>
    </div>
</div>
