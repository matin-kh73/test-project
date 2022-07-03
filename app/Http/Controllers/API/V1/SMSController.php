<?php

namespace App\Http\Controllers\API\V1;

use App\Facades\SMSManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SMSController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function sendAsyncMessage(Request $request): Response
    {
        $message = $request->get('message');
        $receptors = $request->get('receptors');

        $response = SMSManager::driver('kave-negar')->sendAsyncMessage($message, $receptors);

        return Response::withoutData($response['message']);
    }

    /**
     * @param Request $request
     */
    public function sendSyncMessage(Request $request)
    {
        $message = $request->get('message');
        $receptors = $request->get('receptors');

        $response = SMSManager::driver('kave-negar')->sendSyncMessage($message, $receptors);
        return Response::withoutData($response['message']);
    }
}
