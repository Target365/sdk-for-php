<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ResourceMethodNotAvailableException;
use Target365\ApiSdk\Model\OutMessage;

class OutMessageResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'out-messages';
    }

    protected function getResourceModelFqns(): string
    {
        return OutMessage::class;
    }

    public function list(): array
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function prepareMsisdns(array $arr)
    {
        $uri = 'prepare-msisdns';

        $response = $this->apiClient->request('post', $uri, $arr);
    }

    /**
     * POST /out-message/batch
     *
     * @param OutMessage[] $outMessages
     */
    public function postBatch(array $outMessages)
    {
        $uri = 'out-messages/batch';

        $postData = [];

        foreach ($outMessages as $outMessage) {
            $this->forceResourceModel($outMessage);

            $postData[] = $outMessage->normalize();
        }

        $response = $this->apiClient->request('post', $uri, $postData);
    }
}
