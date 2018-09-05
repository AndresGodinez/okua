<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateEmitterRequestDataFactory;
use App\Factories\RequestData\UpdateEmailServiceConfigRequestDataFactory;
use App\Models\RequestData\EmitterRequestData;
use App\Models\RequestData\CreateEmitterRequestData;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CreateEmitterRequestDataFactoryTest
 * @package Tests\Factories
 */
class CreateEmitterRequestDataFactoryTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testRegistersCreatedSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('POST', '/', [], [
            'name' => 'test',
            'rfc' => 'test',
            'email' => 'test',
        ]);

        /** @var CreateEmitterRequestData $requestData */
        $requestData = (new CreateEmitterRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(CreateEmitterRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('POST', '/');

        /** @var EmitterRequestData $requestData */
        $requestData = (new CreateEmitterRequestDataFactory)($request);

        $requestData->validate();
    }
}