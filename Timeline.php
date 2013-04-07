<?php

/**
 * Copyright: milkyway <yhxxlm@gmail.com>
 * Base on <https://github.com/VeriteCo/TimelineJS>
 * Created on 2013-04-07
 * 
 * This extension have to be installed into:
 * <Yii-Application>/proected/extensions/Timeline
 * 
 * Usage:
 * <?php $this->widget('ext.Timeline.Timeline', array(
 *   'id'=>'demo',
 *   'language'=>'zh-cn',
 *    'options' => array(
 *       'width'=>'100%',
 *       'height'=>'100%',
 *       'source'=> 'path/to/example_json.json'
 *    )
 * ));
 * 
 * ?>
 * 
 * See also:<https://github.com/VeriteCo/TimelineJS>
 */
class Timeline extends CWidget {

    public $coreCss = true;
    public $coreJs = true;
    public $forceCopyAssets = true;
    public $options = array();
    public $language = '';

    /**
     * @var array the HTML attributes that should be rendered in the HTML tag representing the JUI widget.
     */
    public $htmlOptions = array();

    /**
     * @var string handles the assets folder path.
     */
    protected $_assetsUrl;

    public function init() {
        // Register the Timeline path alias.
        if (Yii::getPathOfAlias('Timeline') === false)
            Yii::setPathOfAlias('Timeline', realpath(dirname(__FILE__) . '/'));

        if ($this->coreCss !== false)
            $this->registerCoreCss();

        if ($this->coreJs !== false)
            $this->registerCoreJs();
    }

    /**
     * Registers the Timeline CSS.
     */
    public function registerCoreCss() {
        $this->registerAssetCss('timeline.css');
    }

    /**
     * Registers a specific css in the asset's css folder
     * @param string $cssFile the css file name to register
     * @param string $media the media that the CSS file should be applied to. If empty, it means all media types.
     */
    public function registerAssetCss($cssFile, $media = '') {
        Yii::app()->getClientScript()->registerCssFile($this->getAssetsUrl() . "/css/{$cssFile}", $media);
    }

    /**
     * Registers the Timeline CSS.
     */
    public function registerCoreJs() {
        $this->registerJS('timeline.js');
        $this->registerJS('storyjs-embed.js', CClientScript::POS_END);
    }

    /**
     * Registers the Timeline JavaScript.
     * @param int $position the position of the JavaScript code.
     * @see CClientScript::registerScriptFile
     */
    public function registerJS($jsFile, $position = CClientScript::POS_HEAD) {
        /* @var CClientScript $cs */
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');

        $cs->registerScriptFile($this->getAssetsUrl() . "/js/{$jsFile}", $position);
    }

    /**
     * <div id="timeline-embed"></div>
     * <script type="text/javascript">
     *  var timeline_config = {
     *    width: "100%",
     *    height: "100%",
     *    source: 'example_json.json'
     *  }
     * </script>
     */
    public function run() {
        $id = $this->getId();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        echo '<div id="timeline-embed"></div>';

        $options = CJavaScript::encode($this->options);

        $timelineConfig = <<<EOD
           var timeline_config = {$options}
EOD;

        $cs = Yii::app()->getClientScript();
        $cs->registerScript($this->id, $timelineConfig, CClientScript::POS_HEAD);
        $cs->registerScriptFile($this->getAssetsUrl() . '/js/locale/' . $this->language . '.js', CClientScript::POS_HEAD);
    }

    /**
     * Returns the URL to the published assets folder.
     * @return string the URL
     */
    public function getAssetsUrl() {
        if (isset($this->_assetsUrl))
            return $this->_assetsUrl;
        else {
            $assetsPath = Yii::getPathOfAlias('Timeline.assets');
            $assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, $this->forceCopyAssets);
            return $this->_assetsUrl = $assetsUrl;
        }
    }

}