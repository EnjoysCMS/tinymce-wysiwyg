<?php


namespace EnjoysCMS\WYSIWYG\TinyMCE;


use App\Components\Helpers\Assets;
use App\Components\WYSIWYG\WysiwygInterface;

class TinyMCE implements WysiwygInterface
{
    private string $template;

    public function __construct(string $template = null)
    {
        $this->template = $template ?? '@wysisyg/tinymce/src/template/basic.tpl';
        $this->initialize();
    }

    public function getTemplate()
    {
        return $this->template;
    }

    private function initialize()
    {
        Assets::createSymlink('assets/WYSIWYG/tinymce/node_modules/tinymce', __DIR__ . '/../node_modules/tinymce');
        Assets::createSymlink('assets/WYSIWYG/tinymce/node_modules/tinymce/langs/ru.js', __DIR__ . '/langs/ru.js');
        Assets::js(__DIR__ . '/../node_modules/tinymce/tinymce.min.js');
    }
}