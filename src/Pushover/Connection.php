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

    /**
     * Last status code.
     *
     * @var int
     */
    protected $lastStatusCode;

    /**
     * Last response.
     *
     * @var array
     */
    protected $lastResponse;

    /**
     * Constructor.
     *
     * @param string $applicationToken Application token.
     * @param string $defaultUserToken Default user token.
     */
    public function __construct($applicationToken, $defaultUserToken = null)
    {
        $this->applicationToken = $applicationToken;
        $this->defaultUserToken = $defaultUserToken;
    }

    /**
     * Sets the application token.
     *
     * @param string $applicationToken Application token.
     *
     * @return $this
     */
    protected function setApplicationToken($applicationToken)
    {
        $this->applicationToken = $applicationToken;
        return $this;
    }

    /**
     * Gets the application token.
     *
     * @return string
     */
    public function getApplicationToken()
    {
        return $this->applicationToken;
    }

    /**
     * Sets the default user token.
     *
     * @param string $defaultUserToken Default user token.
     *
     * @return $this
     */
    protected function setDefaultUserToken($defaultUserToken)
    {
        $this->defaultUserToken = $defaultUserToken;
        return $this;
    }

    /**
     * Gets the default user token.
     *
     * @return string
     */
    public function getDefaultUserToken()
    {
        return $this->defaultUserToken;
    }

    /**
     * Gets the last status code.
     *
     * @return int
     */
    public function getLastStatusCode()
    {
        return $this->lastStatusCode;
    }

    /**
     * Gets the last response.
     *
     * @return array
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

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
            array(
                CURLOPT_URL            => static::API_URL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => $this->getAPIData($notification, $userToken, $deviceToken),
            )
        );

        $data = curl_exec($ch);
        $this->lastStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->lastResponse = json_decode($data, true);
        curl_close($ch);

        return $this->lastStatusCode == 200
            && array_key_exists('status', $this->lastResponse)
            && $this->lastResponse['status'] == 1
        ;
    }

    /**
     * Get an array of data for sending to the API.
     *
     * @param Notification $notification Notification object.
     * @param string       $userToken    User token.
     * @param string|null  $deviceToken  Device token.
     *
     * @return array
     */
    protected function getAPIData(Notification $notification, $userToken, $deviceToken)
    {
        $data = array(
            'token'   => $this->applicationToken,
            'user'    => $userToken,
            'message' => $notification->getMessage(),
        );

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
