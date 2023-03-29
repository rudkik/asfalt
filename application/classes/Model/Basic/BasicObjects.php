<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_BasicObjects extends Model {


	public function do_some() {}

	// индекс
	private $indexObjects = array();

	//количество элементов в массиве
	private $count =0 ;


    /**
     * получение объекта в списке
     * Порядковый номер объекта
     * @param $index
     * @return BasicObject|null
     */
	public function getRecord($index){
		if (($this->count>$index)&&($index>-1)){
			return $this->indexObjects[$index];
		}else {
			return NULL;
		}
	}

	/** Возвращает количество объектов
	 * Возвращает количество полей
	 */
	public function getCount()
	{
		return $this->count;
	}

	/** добавление объекта в списк
	 * Объекта списка типа BasicObject
	 */
	public function addRecord($basicObject){
		$this->indexObjects[$this->count]=$basicObject;
		$this->count++;
	}

	/** удаление объекта из списка
	 * Порядковый номер объекта
	 */
	public function deleteRecord($index){
		if (($this->count>$index)&&($index>-1)){
			for ($i=$index; $i <$this->count-1; $i++) {
				$this->indexObjects[$i]=$this->indexObjects[$i+1];
			}
			unset($this->indexObjects[$this->count-1]); // Это удаляет элемент из массива
			$this->count--;
		}
	}

	/** Очищает список объектов
	 */
	public function clear(){
		unset($this->indexObjects);
		$this->indexObjects=array();
		$this->count=0;
	}
}
