<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\UpdateEmailServiceConfigRequestDataFactory;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class UpdateEmailServiceConfigRequestDataFactoryTest
 * @package Tests\Factories
 */
class UpdateEmailServiceConfigRequestDataFactoryTest extends TestCase
{
    /**
     * @throws \App\Exceptions\ValidationException
     */
    public function testRegistersCreatedSuccessfully()
    {
        $factory = new UpdateEmailServiceConfigRequestDataFactory;

        $request = TestUtils::makeServerRequestMock('PUT', '/', [], [
            'hostname' => 'test',
            'inboxName' => 'test',
            'username' => 'test',
            'pswd' => 'test',
            'tagOk' => 'test',
            'tagIssue' => 'test',
        ]);

        $requestData = $factory($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(UpdateEmailServiceConfigRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('PUT', '/');

        $factory = new UpdateEmailServiceConfigRequestDataFactory;
        $requestData = $factory($request);

        $requestData->validate();
    }
}