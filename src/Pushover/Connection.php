<?php

namespace Zerifas\Pushover;

class Connection
{
    /**
     * API URL.
     *
     * @const string
     */
    const API_URL = 'https://api.pushover.net/1/messages.json';

    /**
     * Application token.
     *
     * @var string
     */
    protected $applicationToken;

    /**
     * Default user token to use if none passed.
     *
     * @var string
     */
    protected $defaultUserToken;
     * Constructor.
     *
     * @param string $applicationToken Application token.
     * @param string $defaultUserToken Default user token.
     */
    public function __construct($applicationToken)
    public function __construct($applicationToken, $defaultUserToken = null)
    {
        $this->applicationToken = $applicationToken;
        $this->defaultUserToken = $defaultUserToken;
    }

    public function notifyUser(Notification $notification, $userToken, $deviceToken = null)
    {
    /**
     * Send a notification to a user or user's device.
     *
     * @param Notification $notification Notification object.
     * @param string       $userToken    Optional user token (must be specified if there's no defaultUserToken set).
     * @param string       $deviceToken  Optional device token.
     *
     * @return bool
     */
    public function notifyUser(Notification $notification, $userToken = null, $deviceToken = null)
    {
        if ($userToken === null) {
            if ($this->defaultUserToken === null) {
                throw new \InvalidArgumentException('You must set a default user token or pass one to notifyUser.');
            }

            $userToken = $this->defaultUserToken;
        }
        $ch = curl_init();

        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL            => static::API_URL,
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
