<?php
namespace vendor\jz;

use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class JZDropDownColumn extends DataColumn{

    public $editable=false;
    public $editUrl='#';
    public $className='';
    public $list=[];
    public $emptyLabel='Click me to add';
    public $denyLabel='CANCEL';//
    public $editMaxLen=100;//
    public $emptyCssClass='jzdc_empty';
    public $editCssClass='jzdc_edit';
    public $infoCssClass='jzdc_info';
    public $saveCssClass='jzdc_save';
    public $denyCssClass='jzdc_deny';
    public $loaderPath='loader.gif';
    public $updateAll = false;//to update all pjax on page

    public function getDataCellValue($model, $key, $index){        
	if ($this->value !== null) {
            if (is_string($this->value)) {
		return ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute));
            }

            return call_user_func($this->value, $model, $key, $index, $this);

	} elseif ($this->attribute !== null) {
			
            
            $val = ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute));

            if($this->getEditable($model, $key, $index)){
                if(is_array($key)){$key = json_encode($key);}
		$this->format='raw';
		$uniqId = uniqid();
		if(isset($val) && $val!=null){
                    $clickMe='';
		} else {
                    $clickMe='<span id="jzdc_empty_id_'.$uniqId.'" class="'.$this->emptyCssClass.'" onclick="jzDropDownColumnEdit(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.Html::encode($key).'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$this->emptyLabel.'</span>';
                }				
//                    return '<span id="jzdc_title_id_'.$uniqId.'" onclick="jzDataColumnTextEdit(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$val.'</span>'.$clickMe.' <span id="jzdc_info_id_'.$uniqId.'" class="'.$this->infoCssClass.'"></span>'.Html::input('text','jzdc_input_'.$uniqId,$val,['id'=>'jzdc_input_id_'.$uniqId,'maxlength'=>$this->editMaxLen, 'class'=>$this->editCssClass, 'style'=>'display:none;']).'&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_save_id_'.$uniqId.'" class="'.$this->saveCssClass.'" style="display:none;" onclick="jzDataColumnTextSave(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\');">'.$this->saveLabel.'</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_deny_id_'.$uniqId.'" class="'.$this->denyCssClass.'" style="display:none;" onclick="jzDataColumnTextDeny(\''.$uniqId.'\');">'.$this->denyLabel.'</span>';
                return '<span id="jzdc_title_id_'.$uniqId.'" onclick="jzDropDownColumnEdit(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.Html::encode($key).'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).');" onmouseover="$(this).css(\'text-decoration\',\'underline\');" onmouseout="$(this).css(\'text-decoration\',\'none\');" style="cursor:pointer;">'.$val.'</span>'.$clickMe.' <span id="jzdc_info_id_'.$uniqId.'" class="'.$this->infoCssClass.'"></span>'.Html::dropDownList('jzdc_input_'.$uniqId, ArrayHelper::getValue($this->list, ArrayHelper::getValue($model, $this->attribute)), $this->list,['id'=>'jzdc_input_id_'.$uniqId, 'class'=>$this->editCssClass, 'style'=>'display:none;', 'onChange' => 'jzDropDownColumnSave(\''.$uniqId.'\',\''.$this->className.'\',\''.$this->attribute.'\',\''.$key.'\',\''.$this->editUrl.'\',\''.$this->loaderPath.'\','.json_encode($this->updateAll).')']).'&nbsp;&nbsp;&nbsp;&nbsp;<span id="jzdc_deny_id_'.$uniqId.'" class="'.$this->denyCssClass.'" style="display:none;" onclick="jzDropDownColumnDeny(\''.$uniqId.'\');">'.$this->denyLabel.'</span>';
            } else {
                return $val;
            }
        }
        return null;
    }

    public function getEditable($model, $key, $index) {
        if (is_bool($this->editable)) {
            return $this->editable;
        } else {
            return call_user_func($this->editable, $model, $key, $index, $this);
        }
    }
        
}
