<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\UpdateFilterEmitterRequestDataFactory;
use App\Models\RequestData\FilterEmitterRequestData;
use App\Models\RequestData\UpdateFilterEmitterRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class UpdateFilterEmitterRequestDataFactoryTest
 * @package Tests\Factories
 */
class UpdateFilterEmitterRequestDataFactoryTest extends TestCase
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

        /** @var UpdateFilterEmitterRequestData $requestData */
        $requestData = (new UpdateFilterEmitterRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(UpdateFilterEmitterRequestData::class, $requestData);

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
        $requestData = (new UpdateFilterEmitterRequestDataFactory)($request);

        $requestData->validate();
    }
}