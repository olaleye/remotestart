<?php

namespace Tests\Unit\Search;

use Core\Redis;
use MercuryHolidays\Search\Searcher;
use PHPUnit\Framework\TestCase;

class SearcherTest extends TestCase
{
    private Searcher $searcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpRedis();

        $this->searcher = new Searcher();
    }

    public function testAddStoresRecordsInMemory(): void
    {
        $payload = $this->getRecords();
        $this->flushRecords();

        foreach ($payload as $property){
            $this->searcher->add($property);
        }

        $hotels = Redis::getRedis()->lrange('hotels', 0, -1);

        $this->assertCount(14, $hotels);
        $this->flushRecords();
    }

    public function testSearchReturnsTheExpectedResults(): void
    {
        $payload = $this->getRecords();
        $this->flushRecords();

        foreach ($payload as $property){
            $this->searcher->add($property);
        }

        $hotels = $this->searcher->search(2, 30, 50);

        $this->assertCount(2, $hotels);
        $this->assertEquals(
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 3,
                'room_price' => 45.80,
                'available' => true
            ],
            (array)$hotels[0]
        );

        $this->assertSame(
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 4,
                'room_price' => 45.80,
                'available' => true
            ],
            (array)$hotels[1]
        );

        $this->flushRecords();
    }

    public function testSearchDoesReturnEmptyArray(): void
    {
        $payload = $this->getRecords();
        $this->flushRecords();

        foreach ($payload as $property){
            $this->searcher->add($property);
        }

        $hotels = $this->searcher->search(0, 0, 0);

        $this->assertCount(0, $hotels);
        $this->flushRecords();
    }

    private function getRecords(): array
    {
        return [
            [
                'hotel_name' => 'Hotel A',
                'floor' => 1,
                'room_number' => 1,
                'room_price' => 25.80,
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 1,
                'room_number' => 2,
                'room_price' => 25.80,
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 1,
                'room_number' => 3,
                'room_price' => 25.80,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 1,
                'room_number' => 4,
                'room_price' => 25.80,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 1,
                'room_number' => 5,
                'room_price' => 25.80,
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 2,
                'room_number' => 6,
                'room_price' => 30.10,
            ],
            [
                'hotel_name' => 'Hotel A',
                'floor' => 2,
                'room_number' => 7,
                'room_price' => 35.00,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 1,
                'room_price' => 45.80,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 2,
                'room_price' => 45.80,
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 3,
                'room_price' => 45.80,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 4,
                'room_price' => 45.80,
                'available' => true
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 1,
                'room_number' => 5,
                'room_price' => 45.80,
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 2,
                'room_number' => 6,
                'room_price' => 49.00,
            ],
            [
                'hotel_name' => 'Hotel B',
                'floor' => 2,
                'room_number' => 7,
                'room_price' => 49.00,
            ],
        ];
    }

    private function setUpRedis(): void
    {
        $config = [
            'host' => 'sunspottours_redis',
            'port' => 6379,
            'scheme' => 'tcp'
        ];

       Redis::getConnection($config);
    }

    private function flushRecords(): void
    {
        Redis::getRedis()->flushall();
    }
}
