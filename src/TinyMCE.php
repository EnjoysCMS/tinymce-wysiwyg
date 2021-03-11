<?php


namespace EnjoysCMS\WYSIWYG\TinyMCE;


use App\Components\Helpers\Assets;
use App\Components\WYSIWYG\WysiwygInterface;

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
        Assets::createSymlink('assets/WYSIWYG/tinymce/node_modules/tinymce', __DIR__ . '/../node_modules/tinymce');
        Assets::createSymlink('assets/WYSIWYG/tinymce/node_modules/tinymce/langs/ru.js', __DIR__ . '/langs/ru.js');
        Assets::js(__DIR__ . '/../node_modules/tinymce/tinymce.min.js');
    }
}