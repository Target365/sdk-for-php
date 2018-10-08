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


}