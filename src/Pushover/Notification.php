<?php

namespace Zerifas\Pushover;

class Notification
{
    /**
     * Silent priority.
     *
     * @const int
     */
    const PRIORITY_SILENT = -2;

    /**
     * Quiet priority.
     *
     * @const int
     */
    const PRIORITY_QUIET = -1;

    /**
     * High priority.
     *
     * @const int
     */
    const PRIORITY_HIGH = 1;

    /**
     * Confirm priority.
     *
     * @const int
     */
    const PRIORITY_CONFIRM = 2;

    /**
     * Message.
     *
     * @var string
     */
    protected $message;

    /**
     * Title.
     *
     * @var string
     */
    protected $title;

    /**
     * URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Title for the URL.
     *
     * @var string
     */
    protected $urlTitle;

    /**
     * Message priority.
     *
     * -2 to generate no notification/alert.
     * -1 to always send as a quiet notification.
     * 1 to display as high-priority and bypass the user's quiet hours.
     * 2 to also require confirmation from the user.
     *
     * @var int
     */
    protected $priority;

    /**
     * Message timestamp.
     *
     * @var int
     */
    protected $timestamp;

    /**
     * Name of a sound.
     *
     * @var string
     */
    protected $sound;

    /**
     * Constructor.
     *
     * @param string $message Message.
     * @param string $title   Title.
     */
    public function __construct($message, $title = null)
    {
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Sets the Message.
     *
     * @param string $message the message
     *
     * @return $this
     */
    protected function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Gets the Message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the Title.
     *
     * @param string $title the title
     *
     * @return $this
     */
    protected function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Gets the Title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the URL.
     *
     * @param string $url the url
     *
     * @return $this
     */
    protected function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Gets the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the Title for the URL.
     *
     * @param string $urlTitle the url title
     *
     * @return $this
     */
    protected function setUrlTitle($urlTitle)
    {
        $this->urlTitle = $urlTitle;
        return $this;
    }

    /**
     * Gets the Title for the URL.
     *
     * @return string
     */
    public function getUrlTitle()
    {
        return $this->urlTitle;
    }

    /**
     * Sets the Message priority.
     *
     * @param int $priority the priority
     *
     * @return $this
     */
    protected function setPriority($priority)
    {
        $priority = intval($priority);
        if ($priority < -2 || $priority > 2 || $priority == 0) {
            throw new \InvalidArgumentException('Invalid priority: ' . $priority);
        }
        $this->priority = $priority;
        return $this;
    }

    /**
     * Gets the Message priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Sets the Message timestamp.
     *
     * @param int $timestamp the timestamp
     *
     * @return $this
     */
    protected function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Gets the Message timestamp.
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets the Name of a sound.
     *
     * @param string $sound the sound
     *
     * @return $this
     */
    protected function setSound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    /**
     * Gets the Name of a sound.
     *
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }
}
