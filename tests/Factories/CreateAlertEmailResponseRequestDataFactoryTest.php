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
use App\Factories\RequestData\UpdateEmailServiceConfigRequestDataFactory;
use App\Models\RequestData\AlertEmailResponseRequestData;
use App\Models\RequestData\CreateAlertEmailResponseRequestData;
use App\Models\RequestData\UpdateEmailServiceConfigRequestData;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils;


/**
 * Class CreateAlertEmailResponseRequestDataFactoryTest
 * @package Tests\Factories
 */
class CreateAlertEmailResponseRequestDataFactoryTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testRegistersCreatedSuccessfully()
    {
        $request = TestUtils::makeServerRequestMock('POST', '/', [], [
            'code' => 1,
            'internalMsg' => '',
            'emailMsg' => 'test',
        ]);

        /** @var CreateAlertEmailResponseRequestData $requestData */
        $requestData = (new CreateAlertEmailResponseRequestDataFactory)($request);

        $this->assertNotNull($requestData);
        $this->assertInstanceOf(CreateAlertEmailResponseRequestData::class, $requestData);

        $requestData->validate();
    }

    /**
     * @throws ValidationException
     */
    public function testErrorRegisterCreatedWithInvalidParams()
    {
        $this->expectException(ValidationException::class);

        $request = TestUtils::makeServerRequestMock('POST', '/');

        /** @var AlertEmailResponseRequestData $requestData */
        $requestData = (new CreateAlertEmailResponseRequestDataFactory)($request);

        $requestData->validate();
    }
}