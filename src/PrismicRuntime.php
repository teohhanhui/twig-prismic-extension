<?php

declare(strict_types=1);

namespace CoopTilleuls\Twig\Prismic;

use Prismic\Api;
use Prismic\SearchForm;
use Twig\Extension\RuntimeExtensionInterface;

final class PrismicRuntime implements RuntimeExtensionInterface
{
    private $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    public function getForm(string $name = 'everything', ?string $ref = null): ?SearchForm
    {
        if (null === $ref) {
            $ref = $this->api->ref();
        } elseif ('master' === $ref) {
            $ref = $this->api->master()->getRef();
        }

        $form = $this->api->forms()->{$name} ?? null;

        if (null !== $form) {
            $form = $form->ref($ref);
        }

        return $form;
    }

    /**
     * @return object
     */
    public function query(SearchForm $form, ?string $query = null, ?string $lang = null)
    {
        if (null !== $query) {
            $form = $form->query($query);
        }

        if (null !== $lang) {
            $form = $form->lang($lang);
        }

        return $form->submit();
    }
}
