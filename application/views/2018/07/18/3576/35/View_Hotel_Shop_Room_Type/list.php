<option value="<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>" data-human="<?php echo $data->values['human']; ?>" data-human_extra="<?php echo $data->values['human_extra']; ?>"><?php echo $data->values['name']; ?> (осталось <?php echo Func::getCountElementStrRus($data->additionDatas['count_free'], 'комнат', 'комната', 'комнаты') ?>)</option>