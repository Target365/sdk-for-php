<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Model\Keyword;

class KeywordResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'keywords';
    }

    protected function getResourceModelFqns(): string
    {
        return Keyword::class;
    }

    public function list(
        $shortNumberId = null,
        string $keywordText = null,
        string $mode = null,
        string $tag = null
    ): array {
        $queryStringData = [
            'shortNumberId' => $shortNumberId,
            'keywordText' => $keywordText,
            'mode' => $mode,
            'tag' => $tag,
        ];

        return parent::listBase($queryStringData);
    }
}
