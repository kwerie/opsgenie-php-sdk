<?php

declare(strict_types=1);

namespace Kwerie\OpsGenieSdk\Request;

use Exception;
use Fig\Http\Message\RequestMethodInterface;
use Kwerie\OpsGenieSdk\Enum\PriorityEnum;

class Incident extends AbstractRequest
{
    const string OPSGENIE_INCIDENTS_ENDPOINT = 'v1/incidents/create';

    public function getEndpoint(): string
    {
        return self::OPSGENIE_INCIDENTS_ENDPOINT;
    }

    public function getRequestMethod(): string
    {
        return RequestMethodInterface::METHOD_POST;
    }

    public function message(string $message): self
    {
        if (strlen($message) > 130)
        {
            // TODO: custom exception
            throw new Exception('Message cannot contain more than 130 characters');
        }

        $this->data['message'] = $message;

        return $this;
    }

    public function description(string $description): self
    {
        $this->data['description'] = $description;
        return $this;
    }

    public function details(array $details): self
    {
        $this->data['details'] = $details;
        return $this;
    }

    public function tags(array $tags): self
    {
        if (count($tags) > 20)
        {
            throw new Exception('Incident cannot contain more than 20 tags');
        }

        array_walk($tags, function(string $item) {
            if (strlen($item) > 50)
            {
                throw new Exception(
                    sprintf(
                        'Tags have a max-length of 50 characters, conflicting tag: %s',
                        $item
                    )
                );
            }
        });

        $this->data['tags'] = $tags;
        return $this;
    }

    public function priority(PriorityEnum $priority): self
    {
        $this->data['priority'] = $priority;

        return $this;
    }

    public function statusPageEntry(string $title, ?string $detail): self
    {
        $this->data['statusPageEntry'] = [
            'title' => $title,
            'detail' => $detail
        ];

        return $this;
    }

    /** @param string $note Cannot be longer than 25000 characters */
    public function note(string $note): self
    {
        if (strlen($note) > 25000)
        {
            // TODO: custom exception
            throw new Exception('Note cannot contain more than 25000 characters');
        }

        $this->data['note'] = $note;

        return $this;
    }

    public function notifyStakeholders(bool $doNotify): self
    {
        $this->data['notifyStakeholders'] = $doNotify;

        return $this;
    }
}
