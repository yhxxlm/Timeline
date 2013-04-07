Timeline
========

*  Yii TimelineJs extension

### [Setup]:
*  This extension have to be installed into:
*  Yii-Application/proected/extensions/Timeline
  
### [Usage]:
```php
     <?php $this->widget('ext.Timeline.Timeline', array(
       'id'=>'demo',
       'language'=>'zh-cn',
       'options' => array(
           'width'=>'100%',
           'height'=>'100%',
           'source'=> 'path/to/example_json.json'
          )
        ));
  
      ?>
```php  
### [See also]:
*  <https://github.com/VeriteCo/TimelineJS>