<?php


namespace EnjoysCMS\WYSIWYG\TinyMCE;

use EnjoysCMS\Core\Components\Helpers\Assets;
use EnjoysCMS\Core\Components\WYSIWYG\WysiwygInterface;

class TinyMCE implements WysiwygInterface
{
    private string $twigTemplate;

    public function __construct(string $twigTemplate = null)
    {
        $this->twigTemplate = $twigTemplate ?? '@wysisyg/tinymce/src/template/basic.tpl';
        $this->initialize();
    }

    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }

    private function initialize()
    {
        $path = str_replace($_ENV['PROJECT_DIR'], '', realpath(__DIR__.'/../'));
        Assets::createSymlink(sprintf('%s/assets%s/node_modules/tinymce', $_ENV['PUBLIC_DIR'], $path), __DIR__ . '/../node_modules/tinymce');
        Assets::createSymlink(sprintf('%s/assets%s/node_modules/tinymce/langs', $_ENV['PUBLIC_DIR'], $path), __DIR__ . '/langs');
        Assets::js(__DIR__ . '/../node_modules/tinymce/tinymce.min.js');
    }
}