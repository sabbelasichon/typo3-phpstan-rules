<?php

$foo = $_EXTCONF['foo'];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$_EXTKEY] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
