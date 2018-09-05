<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateFilterEmitterRequestDataFactory;
use App\Models\RequestData\CreateFilterEmitterRequestData;
use App\Models\RequestData\FilterEmitterRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CreateFilterEmitterRequestDataFactoryTest
 * @package Tests\Factories
 */
class CreateFilterEmitterRequestDataFactoryTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testRegistersCreatedSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('POST', '/', [], [
            'rfc' => 'test',
            'valid' => 1,
        ]);

        /** @var CreateFilterEmitterRequestData $requestData */
        $requestData = (new CreateFilterEmitterRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(CreateFilterEmitterRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('POST', '/');

        /** @var FilterEmitterRequestData $requestData */
        $requestData = (new CreateFilterEmitterRequestDataFactory)($request);

        $requestData->validate();
    }
}