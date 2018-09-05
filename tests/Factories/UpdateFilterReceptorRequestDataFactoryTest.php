<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;


use App\Exceptions\ValidationException;
use App\Factories\RequestData\UpdateFilterReceptorRequestDataFactory;
use App\Models\RequestData\FilterReceptorRequestData;
use App\Models\RequestData\UpdateFilterReceptorRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class UpdateFilterReceptorRequestDataFactoryTest
 * @package Tests\Factories
 */
class UpdateFilterReceptorRequestDataFactoryTest extends TestCase
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

        /** @var UpdateFilterReceptorRequestData $requestData */
        $requestData = (new UpdateFilterReceptorRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(UpdateFilterReceptorRequestData::class, $requestData);

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
        $requestData = (new UpdateFilterReceptorRequestDataFactory)($request);

        $requestData->validate();
    }
}