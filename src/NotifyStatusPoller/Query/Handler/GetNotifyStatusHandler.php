<?php

declare(strict_types=1);

namespace NotifyStatusPoller\Query\Handler;

use Alphagov\Notifications\Client as NotifyClient;
use NotifyStatusPoller\Command\Model\UpdateDocumentStatus;
use NotifyStatusPoller\Query\Model\GetNotifyStatus;

class GetNotifyStatusHandler
{
    private NotifyClient $notifyClient;

    public function __construct(NotifyClient $notifyClient)
    {
        $this->notifyClient = $notifyClient;
    }

    public function handle(GetNotifyStatus $query): UpdateDocumentStatus
    {
        $response = $this->notifyClient->getNotification($query->getNotifyId());

        return new UpdateDocumentStatus([
            'documentId' => $query->getDocumentId(),
            'notifyId' => $query->getNotifyId(),
            'notifyStatus' => $response['status'],
        ]);
    }
}
