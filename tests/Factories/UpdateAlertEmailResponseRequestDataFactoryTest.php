<?php
/**
 * Created by PhpStorm.
 * User: alberto
 * Date: 4/09/18
 * Time: 04:00 PM
 */

namespace Tests\Factories;
use App\Exceptions\ValidationException;
use App\Factories\RequestData\CreateAlertEmailResponseRequestDataFactory;
use App\Factories\RequestData\UpdateAlertEmailResponseRequestDataFactory;
use App\Models\RequestData\AlertEmailResponseRequestData;
use App\Models\RequestData\CreateAlertEmailResponseRequestData;
use App\Models\RequestData\UpdateAlertEmailResponseRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class UpdateAlertEmailResponseRequestDataFactoryTest
 * @package Tests\Factories
 */
class UpdateAlertEmailResponseRequestDataFactoryTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testRegistersCreatedSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('PUT', '/', [], [
            'code' => 1,
            'internalMsg' => '',
            'emailMsg' => 'test',
        ]);

        /** @var CreateAlertEmailResponseRequestData $requestData */
        $requestData = (new UpdateAlertEmailResponseRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(UpdateAlertEmailResponseRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('PUT', '/');

        /** @var AlertEmailResponseRequestData $requestData */
        $requestData = (new UpdateAlertEmailResponseRequestDataFactory)($request);

        $requestData->validate();
    }
}