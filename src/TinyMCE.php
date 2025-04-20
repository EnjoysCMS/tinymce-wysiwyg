<?php
declare(strict_types=1);

namespace EnjoysCMS\ContentEditor\TinyMCE;

use Enjoys\AssetsCollector;
use EnjoysCMS\Core\ContentEditor\ContentEditorInterface;
use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use function Enjoys\FileSystem\makeSymlink;

final class TinyMCE implements ContentEditorInterface
{
    private ?string $selector = null;

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly Environment $twig,
        private readonly AssetsCollector\Assets $assets,
        private readonly LoggerInterface $logger,
        private readonly ?string $template = null
    ) {
        if (!file_exists(__DIR__ . '/../node_modules/tinymce')) {
            $command = sprintf('cd %s && yarn install', realpath(__DIR__ . '/..'));
            try {
                $result = passthru($command);
                if ($result === false) {
                    throw new Exception();
                }
            } catch (Throwable) {
                throw new RuntimeException(sprintf('Run: %s', $command));
            }
        }
        $this->initialize();
    }

    private function getTemplate(): ?string
    {
        return $this->template ?? __DIR__ . '/template/basic.twig';
    }


    /**
     * @throws Exception
     */
    private function initialize(): void
    {
        $path = str_replace(getenv('ROOT_PATH'), '', realpath(__DIR__ . '/../'));
        makeSymlink(sprintf('%s/assets%s/node_modules/tinymce', $_ENV['PUBLIC_DIR'], $path), __DIR__ . '/../node_modules/tinymce');
        makeSymlink(sprintf('%s/assets%s/node_modules/tinymce/langs', $_ENV['PUBLIC_DIR'], $path), __DIR__ . '/langs');
        $this->assets->add(AssetsCollector\AssetType::JS, __DIR__ . '/../node_modules/tinymce/tinymce.min.js');
    }


    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    public function getSelector(): string
    {
        if ($this->selector === null) {
            throw new RuntimeException('Selector not set');
        }
        return $this->selector;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getEmbedCode(): string
    {
        $twigTemplate = $this->getTemplate();
        if (!$this->twig->getLoader()->exists($twigTemplate)) {
            throw new RuntimeException(
                sprintf("ContentEditor: (%s): Нет шаблона в по указанному пути: %s", self::class, $twigTemplate)
            );
        }
        return $this->twig->render(
            $twigTemplate,
            [
                'editor' => $this,
                'selector' => $this->getSelector()
            ]
        );
    }
}
