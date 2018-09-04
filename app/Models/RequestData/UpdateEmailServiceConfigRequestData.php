<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 03:55 PM
 */

namespace App\Models\RequestData;


use App\Exceptions\ValidationException;
use App\Interfaces\IValidableRequest;


/**
 * Class UpdateEmailServiceConfigRequestData
 * @package App\Models\RequestData
 */
class UpdateEmailServiceConfigRequestData implements IValidableRequest
{
    /** @var string */
    protected $hostname = '';

    /** @var string */
    protected $inboxName = '';

    /** @var string */
    protected $username = '';

    /** @var string */
    protected $pswd = '';

    /** @var string */
    protected $tagOk = '';

    /** @var string */
    protected $tagIssue = '';

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getInboxName()
    {
        return $this->inboxName;
    }

    /**
     * @param string $inboxName
     */
    public function setInboxName(string $inboxName)
    {
        $this->inboxName = $inboxName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPswd()
    {
        return $this->pswd;
    }

    /**
     * @param string $pswd
     */
    public function setPswd(string $pswd)
    {
        $this->pswd = $pswd;
    }

    /**
     * @return string
     */
    public function getTagOk()
    {
        return $this->tagOk;
    }

    /**
     * @param string $tagOk
     */
    public function setTagOk(string $tagOk)
    {
        $this->tagOk = $tagOk;
    }

    /**
     * @return string
     */
    public function getTagIssue()
    {
        return $this->tagIssue;
    }

    /**
     * @param string $tagIssue
     */
    public function setTagIssue(string $tagIssue)
    {
        $this->tagIssue = $tagIssue;
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->hostname || !$this->inboxName || !$this->username || !$this->pswd || !$this->tagOk || !$this->tagIssue) {
            throw new ValidationException('Invalid configuration parameters');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf(
            '<EmailServiceConfigRequestData [hostname: %s, inboxName: %s, username: %s, tagOk: %s, tagIssue: %s]>',
            $this->hostname,
            $this->inboxName,
            $this->username,
            $this->tagOk,
            $this->tagIssue
        );
    }
}