<?php

namespace App\Listeners;

use App\Events\MessageSendSuccessfullyEvent;
use App\Http\Resources\KaveNegarResource;
use App\Services\Message\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreMessageListener
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * Create the event listener.
     *
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Handle the event.
     *
     * @param MessageSendSuccessfullyEvent $event
     * @return void
     */
    public function handle(MessageSendSuccessfullyEvent $event)
    {
        $data = KaveNegarResource::collection($event->data)->resolve();
        $this->messageService->insert($data) ;
    }
}
