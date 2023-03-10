<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ResourceMethodNotAvailableException;
use Target365\ApiSdk\Model\OutMessage;
use Target365\ApiSdk\Model\Pincode;
use Target365\ApiSdk\Attribute\DateTimeAttribute;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function postBatch(array $outMessages): void
    {
        $uri = 'out-messages/batch';

        $postData = [];

        foreach ($outMessages as $outMessage) {
            $this->forceResourceModel($outMessage);

            $postData[] = $outMessage->normalize();
        }

        $response = $this->apiClient->request('post', $uri, $postData);
    }

    /**
     * POST /pincodes
     *
     * @param pincode $model
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function sendPinCode(Pincode $model): void
    {
        $uri = 'pincodes';
        $normalizedData = $model->normalize();
        $response = $this->apiClient->request('post', $uri, $normalizedData);
    }

    /**
     * GET /pincodes/verification?transactionId={transactionId}&pincode={pincode}
     *
     * @param string $transactionId
     * @param string $pincode
     * @throws \InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function verifyPinCode(string $transactionId, string $pincode): bool
    {
        $uri = 'pincodes/verification?transactionId=' . urlencode($transactionId) . '&pincode=' . urlencode($pincode) ;
        $response = $this->apiClient->request('get', $uri);
        return filter_var($response->getBody()->__toString(), FILTER_VALIDATE_BOOLEAN);
    }

    public function getExport(DateTimeAttribute $from, DateTimeAttribute $to)
    {
        $uri = 'export/out-messages?from=' . urlencode($from->__toString()) . '&to=' . urlencode($to->__toString());
        $response = $this->apiClient->request('get', $uri);
        return $response->getBody()->__toString();
    }
}
