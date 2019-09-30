//Example for usage in GridView

Pjax::begin(['id' => 'pjax_id_1', 'options'=> ['class'=>'pjax', 'loader'=>'loader_id_1', 'neverTimeout'=>true]]);

    echo GridView::widget([

        'dataProvider' => $dp,

        'filterModel' => $model,

        'options'=>['class'=>'grid-view','id'=>'grid_id_1'],

        'summaryOptions'=>['style'=>'text-align:right;'],

        'columns' => [

            [
		'class' => 'vendor\jz\JZDropDownColumn',
                'className' => 'Payment',
                'attribute' => 'payment_method',
                'editable' => true,
                'list' => ['List item 0', 'List item 1', 'List item 2'],
		      'editUrl' => Url::to(['payment/intedit']),
		      'emptyLabel' => Yii::t('msg','Click me to change'),
		      'denyLabel' => Yii::t('msg','CANCEL'),
		      'loaderPath' => Yii::getAlias('@jzCssImgWeb').'/img_loader.gif',
                'headerOptions' => ['style'=>'width:200px; text-align:center;'],
            ],

        ],

    ]); 

Pjax::end();


//Example of action for edit attribute via dropdown change

    public function actionIntedit()
    {		
        if(isset($_GET['data'])){
            $json = json_decode($_GET['data']);
            if(isset($json->class) && isset($json->id) && isset($json->attribute) && isset($json->value)){
                $className = $json->class;
                if($className == 'YourClass'){
                    $model = YourClass::findOne(intval($json->id));
                    if(isset($model)){
                        $attribute = $json->attribute;
                        $model->$attribute = intval($json->value);//variable variable!!!
                        if($model->save()){
                            return json_encode(['msg'=>1,'val'=>$model->$attribute]);
                        } else {return json_encode(['msg'=>0,'val'=>'Error.']);}
                    } else {return json_encode(['msg'=>0,'val'=>'No model found.']);}
                }
            } else {return json_encode(['msg'=>0,'val'=>'No correct data set provided.']);}
        } else {return json_encode(['msg'=>0,'val'=>'No data provided.']);}
    }


























