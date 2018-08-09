<?php

declare(strict_types=1);

namespace CoopTilleuls\Twig\Prismic;

use Prismic\Dom\RichText;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class PrismicExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('prismic_form', [PrismicRuntime::class, 'getForm']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('prismic_query', [PrismicRuntime::class, 'query']),
            /** @see https://github.com/prismicio/php-kit/issues/152 */
            new TwigFilter('prismic_richtext_text', [PrismicRuntime::class, 'richTextAsText']),
            new TwigFilter('prismic_richtext_html', [RichText::class, 'asHtml'], [
                'is_safe' => ['html'],
            ]),
        ];
    }
}
