<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 01:59 PM
 */

namespace App\Site\ServicesProviders;


use App\Models\EmailServiceConfig;
use App\Utils\SharedConfigUtils;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModelsServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'email-service-config',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->share('email-service-config', function ($config, $fs) {
            if (\defined('TESTING') && !!TESTING) {
                $file = '/test/config/email-serv.data';
            } else {
                $file = SharedConfigUtils::$EMAIL_SERVICE_FILE_PATH;
            }

            $content = SharedConfigUtils::readEmailServiceConfig($fs, $file, $config['OKUA_SHARED_CONFIG_KEY']);

            $inst = new EmailServiceConfig();
            $inst->setHostname($content['hostname']);
            $inst->setInboxName($content['inboxName']);
            $inst->setUsername($content['username']);
            $inst->setPswd($content['pswd']);
            $inst->setTagOk($content['tagOk']);
            $inst->setTagIssue($content['tagIssue']);

            return $inst;
        })
        ->withArgument('config')
        ->withArgument('shared-filesystem');
    }
}