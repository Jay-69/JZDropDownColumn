<?php
/**
 * @link http://www.atlanticbits.com/
 * @copyright Copyright (c) 2019 Eugene Zemskov
 * @license MIT
 */
namespace vendor\jz;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * JZDropDownColumn is the extantion of DataColumn column type for the [[GridView]] widget.
 *
 * It is used to show data columns and allows data of type integer to be edited directly in GridView by setting [[editable]] to true.
 *
 * @author Eugene Zemskov <www@atlanticbits.com>
 */

class JZDropDownColumn extends DataColumn
{

    public $editable = false;
    public $editUrl = '#';
    public $className = '';
    public $list = [];
    public $emptyLabel = 'Click me to add';
    public $denyLabel = 'CANCEL';
    public $emptyCssClass = 'jzdc_empty';
    public $editCssClass = 'jzdc_edit';
    public $infoCssClass = 'jzdc_info';
    public $saveCssClass = 'jzdc_save';
    public $denyCssClass = 'jzdc_deny';
    public $loaderPath = 'loader.gif';
    public $updateAll = false;//to update all pjaxs on page

    public function getDataCellValue($model, $key, $index)
    { 
	if ($this->value !== null){
		
            if (is_string($this->value)){
		return ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute));
            }
            return call_user_func($this->value, $model, $key, $index, $this);

	} elseif ($this->attribute !== null) {			
            
            $val = ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute));

            if($this->getEditable($model, $key, $index)){
                if(is_array($key)){$key = json_encode($key);}
		$this->format='raw';
		$uniqId = uniqid();
		if(isset($val) && $val != null){
                    $clickMe = '';
		} else {
                    $clickMe = '<span id="jzdc_empty_id_'.$uniqId.'" class="'.$this->emptyCssClass.'" onclick="jzDropDownColumnEdit(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.Html::encode($key).'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$this->emptyLabel.'</span>';
                }				
                return '<span id="jzdc_title_id_'.$uniqId.'" onclick="jzDropDownColumnEdit(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.Html::encode($key).'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$val.'</span>'.$clickMe.' <span id="jzdc_info_id_'.$uniqId.'" class="'.$this->infoCssClass.'"></span>'.Html::dropDownList('jzdc_input_'.$uniqId, ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute)), $this->list,['id'=>'jzdc_input_id_'.$uniqId, 'class'=>$this->editCssClass, 'style'=>'display:none;', 'onChange' => 'jzDropDownColumnSave(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).')']).'&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_deny_id_'.$uniqId.'" class="'.$this->denyCssClass.'" style="display:none;" onclick="jzDropDownColumnDeny(\''.$uniqId.'\');">'.$this->denyLabel.'</span>';
            } else {
                return $val;
            }
		
        }
        return null;
    }

    public function getEditable($model, $key, $index)
    {
        if (is_bool($this->editable)) {
            return $this->editable;
        } else {
            return call_user_func($this->editable, $model, $key, $index, $this);
        }
    }
        
}
