<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\ApiClientException;
use Target365\ApiSdk\Model\Keyword;
use Target365\ApiSdk\Tests\AbstractTestCase;

class KeywordResourceTest extends AbstractTestCase
{

    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $keyword = new Keyword();

        $keyword
            ->setShortNumberId('NO-0000')
            ->setKeywordText('Test' . (string) rand() . (string) time() ) // NOTE: keywordText must be unique per shortNumberId and text
            ->setMode('Text')
            ->setForwardUrl('https://tempuri.org')
            ->setEnabled(true)
            ->setTags(['Foo', 'Bar']);


        $identifier = $apiClient->keywordResource()->post($keyword);

        $this->assertTrue(is_numeric($identifier));

        return $identifier;
    }

    public function testGetList()
    {
        $apiClient = $this->getApiClient();

        $keywords = $apiClient->keywordResource()->getList();

        // We know there is at least 1 item as we just posted one
        $this->assertGreaterThanOrEqual(1, count($keywords));

        foreach ($keywords as $keyword) {
            $this->assertInstanceOf(Keyword::class, $keyword);
        }
    }

    /**
     * @depends testPost
     */
    public function testGetOne($identifier)
    {
        $apiClient = $this->getApiClient();

        $keyword = $apiClient->keywordResource()->getOne($identifier);

        $this->assertInstanceOf(Keyword::class, $keyword);

        $this->assertEquals($identifier, $keyword->getIdentifier());

        return $keyword;
    }

    /**
     * @depends testGetOne
     */
    public function testPut(Keyword $keyword)
    {
        $apiClient = $this->getApiClient();

        $changedForwardUrl = 'https://tempuri-changed.org';

        $keyword
            ->setForwardUrl($changedForwardUrl);

        $apiClient->keywordResource()->put($keyword);

        $keywordChanged = $apiClient->keywordResource()->getOne($keyword->getIdentifier());

        $this->assertEquals($changedForwardUrl, $keywordChanged->getForwardUrl());

        return $keywordChanged;
    }

    /**
     * @depends testPut
     */
    public function testDelete(Keyword $keyword)
    {
        $apiClient = $this->getApiClient();

        $apiClient->keywordResource()->delete($keyword->getIdentifier());

        $this->assertTrue(true);

        return $keyword;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(Keyword $keyword)
    {
        $this->expectException(ApiClientException::class);

        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $apiClient->keywordResource()->getOne($keyword->getIdentifier());
    }


}