<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 11:29 AM
 */

namespace App\Models;


use App\Exceptions\ValidationException;
use App\Interfaces\IArraySerializableModel;
use App\Interfaces\IValidableModel;

class EmailServiceConfig implements IValidableModel, IArraySerializableModel
{
    protected $hostname = '';
    protected $inboxName = '';
    protected $username = '';
    protected $pswd = '';
    protected $tagOk = '';
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
     * @return array
     */
    public function toArray()
    {
        return [
            'hostname' => $this->hostname,
            'inboxName' => $this->inboxName,
            'username' => $this->username,
            'pswd' => $this->pswd,
            'tagOk' => $this->tagOk,
            'tagIssue' => $this->tagIssue,
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (!$this->hostname) {
            throw new ValidationException('Invalid mailbox hostname');
        }

        if (!$this->inboxName) {
            throw new ValidationException('Invalid mailbox main tag name');
        }

        if (!$this->username) {
            throw new ValidationException('Invalid mailbox username');
        }

        if (!$this->pswd) {
            throw new ValidationException('Invalid mailbox password');
        }

        if (!$this->tagOk) {
            throw new ValidationException('Invalid mailbox processed tag name');
        }

        if (!$this->tagIssue) {
            throw new ValidationException('Invalid mailbox issues tag name');
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return \sprintf(
            '<EmailServiceConfig [hostname: %s, inboxName: %s, username: %s, tagOk: %s, tagIssue: %s]>',
            $this->hostname,
            $this->inboxName,
            $this->username,
            $this->tagOk,
            $this->tagIssue
        );
    }
}