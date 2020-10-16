Yii2-js-localize
=============

Yii2-js-localize is a Yii2 extension aiming to port the native Yii2 translations module to javascript. Language files can be published
and used within javascript in almost the same way as Yii2 does server side.
Currently supported are placeholders and plural forms (including expressions).


Usage
-----------
	
Translations can be used in javascript:

    Yii.t('app','My non-translated text');

Make sure there is a translation available to see the results.


Examples
-----------
(for demo purposes the default language is English, it could be any language)

Simple translation:

    Yii.t('app','Hello world');  // Hello World

Simple translation with custom language:

    Yii.t('app','Hello world','','fr');  // Bonjour tout le monde
    Yii.t('app','Hello world','','de');  // Hallo Welt

Placeholder:

    Yii.t('app','Hello {name}',{name:'Michael'}); // Hello Michael

Multiple placeholders:

    Yii.t('app','Hello {firstname} {lastname}', {firstname:'Michael', lastname:'Jackson'}); // Hello Michael Jackson

Plural forms:

    Yii.t('app','Apple|Apples',0); // Apples
    Yii.t('app','Apple|Apples',1); // Apple
    Yii.t('app','Apple|Apples',2); // Apples

Plural forms with placeholders:

    Yii.t('app','{n} Apple|{n} Apples',0); // 0 Apples
    Yii.t('app','{n} Apple|{n} Apples',1); // 1 Apple
    Yii.t('app','{n} Apple|{n} Apples',2); // 2 Apples

Plural forms with expressions:

    Yii.t('app','0#No comments, be the first!|1#One comment|n>1#{n} comments',0); // No comments, be the first!
    Yii.t('app','0#No comments, be the first!|1#One comment|n>1#{n} comments',1); // One comment
    Yii.t('app','0#No comments, be the first!|1#One comment|n>1#{n} comments',2); // 2 comments


Plural forms with expressions and placeholders:

    Yii.t('app','0#{name} has no mail|1#{name} has one mail|n>1#{name} has {n} mails',{n:0, name:'Pete'}); // Pete has no mail
    Yii.t('app','0#{name} has no mail|1#{name} has one mail|n>1#{name} has {n} mails',{n:1, name:'Pete'}); // Pete has one mail
    Yii.t('app','0#{name} has no mail|1#{name} has one mail|n>1#{name} has {n} mails',{n:2, name:'Pete'}); // Pete has 2 mails
