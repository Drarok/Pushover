<?php

namespace Zerifas\Pushover;

class Connection
{
    /**
     * Application token.
     *
     * @var string
     */
    protected $applicationToken;

    /**
     * Constructor.
     *
     * @param string $applicationToken Application token.
     */
    public function __construct($applicationToken)
    {
        $this->applicationToken = $applicationToken;
    }

    public function notifyUser(Notification $notification, $userToken, $deviceToken = null)
    {
        $ch = curl_init();

        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL            => 'https://api.pushover.net/1/messages.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => $this->getAPIData($notification, $userToken, $deviceToken),
            ]
        );

        $data = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    protected function getAPIData(Notification $notification, $userToken, $deviceToken)
    {
        $data = [
            'token'   => $this->applicationToken,
            'user'    => $userToken,
            'message' => $notification->getMessage(),
        ];

        if ($deviceToken) {
            $data['device'] = $deviceToken;
        }

        if ($title = $notification->getTitle()) {
            $data['title'] = $title;
        }

        if ($url = $notification->getUrl()) {
            $data['url'] = $url;
        }

        if ($urlTitle = $notification->getUrlTitle()) {
            $data['urlTitle'] = $urlTitle;
        }

        if ($priority = $notification->getPriority()) {
            $data['priority'] = $priority;
        }

        if ($timestamp = $notification->getTimestamp()) {
            $data['timestamp'] = $timestamp;
        }

        if ($sound = $notification->getSound()) {
            $data['sound'] = $sound;
        }

        return $data;
    }
}
