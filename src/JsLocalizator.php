<?php
declare(strict_types=1);

namespace Fereron\JsLocalization;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

class JsLocalizator extends Component
{
    public $languages = [];
    public $defaultLanguage;
    public $categories = [];

    private $dictionaryFile;

    /**
     * @var string the root directory storing the published Js file.
     */
    public $basePath = '@webroot/public/js/localization';

    public function init()
    {
        $this->languages = $this->languages ?: Yii::$app->params['languages'];
        $this->defaultLanguage = $this->defaultLanguage ?: Yii::$app->language;


        $this->basePath = Yii::getAlias($this->basePath);
        if (!is_dir($this->basePath)) {
            throw new InvalidConfigException("The directory does not exist: {$this->basePath}");
        }

        $this->basePath = realpath($this->basePath);

        // create hash
        $hash = substr(md5(implode($this->categories) . ':' . implode($this->languages) ), 0, 10);
        $this->dictionaryFile = "dictionary.{$hash}.js";

        if (!file_exists($this->basePath . DIRECTORY_SEPARATOR . $this->dictionaryFile)) {
            $this->localizeJs();
        }
    }

    protected function localizeJs()
    {
        $source = Yii::createObject(FileMessageSource::class);

        // loop message files and store translations in array
        $dictionary = [];
        foreach ($this->languages as $locale => $language) {
            foreach ($this->categories as $category) {
                $dictionary[$locale][$category] = $source->getMessages($category, $locale);
            }
        }

        $config = [
            'language' => $this->defaultLanguage,
//            'onMissingTranslation' => $this->onMissingTranslation
        ];

        // JSONify config/dictionary
        $data = sprintf(
            "Yii.translate.config=%s;Yii.translate.dictionary=%s",
            Json::encode($config), Json::encode($dictionary)
        );

        // save to dictionary file
        if (!file_put_contents($this->basePath . DIRECTORY_SEPARATOR . $this->dictionaryFile, $data)) {
            throw new InvalidConfigException("Could not write dictionary file to: {$this->basePath}");
        }
    }

    /**
     * @return string
     */
    public function getDictionaryFile()
    {
        return $this->dictionaryFile;
    }

}