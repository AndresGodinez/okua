<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateFilterReceptorRequestDataFactory;
use App\Models\RequestData\CreateFilterReceptorRequestData;
use App\Models\RequestData\FilterReceptorRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CreateFilterReceptorRequestDataFactoryTest
 * @package Tests\Factories
 */
class CreateFilterReceptorRequestDataFactoryTest extends TestCase
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

        /** @var CreateFilterReceptorRequestData $requestData */
        $requestData = (new CreateFilterReceptorRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(CreateFilterReceptorRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('POST', '/');

        /** @var FilterReceptorRequestData $requestData */
        $requestData = (new CreateFilterReceptorRequestDataFactory)($request);

        $requestData->validate();
    }
}