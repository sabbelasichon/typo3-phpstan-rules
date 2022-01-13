<?php
use Prefix\MyExtension\PageRendererHooks;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['my_extension'] = PageRendererHooks::class . '->renderPreProcess';
