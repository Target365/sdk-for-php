<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit\Model;

use Target365\ApiSdk\Model\Keyword;
use Target365\ApiSdk\Tests\AbstractTestCase;

class KeywordTest extends AbstractTestCase
{
    public function testPopulate()
    {
        $keyword = new Keyword();

        $keyword->populate(
            [
              'keywordId' => 123,
              'shortNumberId' => 'NO-0000',
              'keywordText' => 'Test',
              'mode' => 'Text',
              'forwardUrl' => 'https://tempuri.org',
              'enabled' => true,
              'created' => '2017-11-17T14:30:00+00:00',
              'lastModified' => '2017-11-17T14:30:00+00:00',
              'tags' => [
                    'Foo',
                    'Bar'
                ]
            ]
        );

        $this->assertEquals(123, $keyword->getKeywordId());
    }
}