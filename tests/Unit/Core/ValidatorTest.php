<?php

namespace Tests\Unit\Core;

use Core\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new Validator();
    }

    public function testValidateReturnAnEmptyArrayWhenAllFieldsAreValidated(): void
    {
        $rules = [
            'hotel_name' => 'required|string',
            'floor' => 'required|int',
            'room_number' => 'required|int',
            'room_price' => 'required',
            'available' => 'required'
        ];

        $payload = [
            'hotel_name' => 'Mercury hotel',
            'floor' => 1,
            'room_number' => 2,
            'room_price' => 2.50,
            'available' => true
        ];

        $errors = $this->validator->validate($rules, $payload);

        $this->assertEmpty($errors);
        $this->assertTrue($this->validator->isValid());
    }

    public function testRequiredReturnsMessageWhenFieldIsRequired(): void
    {
        $rules = [
            'hotel_name' => 'required|string',
            'floor' => 'required|int',
            'room_number' => 'required|int',
            'room_price' => 'required',
            'available' => 'required'
        ];

        $payload = [
            'floor' => 1,
            'room_number' => 2,
            'room_price' => 2.50,
            'available' => true
        ];

        $errors = $this->validator->validate($rules, $payload);

        $this->assertNotEmpty($errors);
        $this->assertFalse($this->validator->isValid());
        $this->assertSame('The hotel_name is required!', $this->validator->getError('hotel_name'));
        $this->assertCount(1, $errors);
    }

    public function testStringReturnsMessageWhenFieldIsNotAString(): void
    {
        $rules = [
            'hotel_name' => 'required|string',
            'floor' => 'required|int',
            'room_number' => 'required|int',
            'room_price' => 'required',
            'available' => 'required'
        ];

        $payload = [
            'hotel_name' => '1',
            'floor' => 1,
            'room_number' => 2,
            'room_price' => 2.50,
            'available' => true
        ];

        $errors = $this->validator->validate($rules, $payload);

        $this->assertNotEmpty($errors);
        $this->assertFalse($this->validator->isValid());
        $this->assertSame('The hotel_name is not a valid string!', $this->validator->getError('hotel_name'));
    }

    public function testIntReturnsMessageWhenFieldIsNotAInt(): void
    {
        $rules = [
            'hotel_name' => 'required|string',
            'floor' => 'required|int',
            'room_number' => 'required|int',
            'room_price' => 'required|int',
            'available' => 'required'
        ];

        $payload = [
            'hotel_name' => 'Hotel',
            'floor' => 'This is a string',
            'room_number' => 'This is not an integer',
            'room_price' => 'Another string',
            'available' => true
        ];

        $errors = $this->validator->validate($rules, $payload);

        $this->assertNotEmpty($errors);
        $this->assertFalse($this->validator->isValid());
        $this->assertSame('The floor is not a valid integer!', $this->validator->getError('floor'));
        $this->assertSame('The room_number is not a valid integer!', $this->validator->getError('room_number'));
        $this->assertSame('The room_price is not a valid integer!', $this->validator->getError('room_price'));
        $this->assertCount(3, $errors);
    }
}