<?php

declare(strict_types=1);

namespace Kwerie\OpsGenieSdk\Request;

use Kwerie\OpsGenieSdk\Enum\PriorityEnum;
use Kwerie\OpsGenieSdk\Interface\RequestInterface as OpsGenieRequestInterface;

abstract class AbstractRequest implements OpsGenieRequestInterface
{
    public array $data = [
        'priority' => PriorityEnum::P3
    ];

    abstract public function getEndpoint(): string;
    abstract public function getRequestMethod(): string;

    public function getUrl(): string
    {
        return implode(
            '/',
            [
                $this->getBaseUri(),
                $this->getEndpoint()
            ]
        );
    }

    public function getPayload(): array
    {
        return array_merge(
            $this->data,
            [
                'impactedServices' => getenv('OPSGENIE_SERVICE_ID')
            ]
        );
    }

    public function getBaseUri(): string
    {
        return $this->getRegion() != 'EU' ? 'https://api.opsgenie.com' : 'https://api.eu.opsgenie.com';
    }

    private function getRegion(): string
    {
        return getenv('OPSGENIE_REGION');
    }
}
