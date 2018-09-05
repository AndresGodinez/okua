<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\UpdateEmitterRequestDataFactory;
use App\Factories\RequestData\UpdateEmailServiceConfigRequestDataFactory;
use App\Models\RequestData\EmitterRequestData;
use App\Models\RequestData\UpdateEmitterRequestData;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class UpdateEmitterRequestDataFactoryTest
 * @package Tests\Factories
 */
class UpdateEmitterRequestDataFactoryTest extends TestCase
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

        /** @var UpdateEmitterRequestData $requestData */
        $requestData = (new UpdateEmitterRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(UpdateEmitterRequestData::class, $requestData);

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
        $requestData = (new UpdateEmitterRequestDataFactory)($request);

        $requestData->validate();
    }
}