<?php
declare(strict_types=1);

namespace Fereron\JsLocalization;

use yii\i18n\PhpMessageSource;

class FileMessageSource extends PhpMessageSource
{

    public function getMessages(string $category, string $language)
    {
        return $this->loadMessages($category, $language);
    }

}