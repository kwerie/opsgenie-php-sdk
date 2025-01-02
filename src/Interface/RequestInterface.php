<?php

declare(strict_types=1);

namespace Kwerie\OpsGenieSdk\Interface;

interface RequestInterface
{
    function getEndpoint(): string;
    function getRequestMethod(): string;
    function getPayload(): array;
    function getBaseUri(): string;
}
