<?php

namespace MercuryHolidays\Search;

use Core\Redis;

class Searcher
{
    private string $key = 'hotels';

    public function add(array $property): void
    {
        $redis = Redis::getRedis();

        $property['available'] = isset($property['available']);

        $redis->rpush($this->key, [json_encode($property)]);
    }

    public function search(int $roomsRequired, float $minimum, float $maximum): array
    {
        $hotels = $this->find($minimum, $maximum);

        if($roomsRequired === 1){
            return $hotels;
        }

        return $this->filter($hotels);
    }

    /**
     * Retrieves all the hotels in the in-memory database and filters them
     * based on the minimum and maximum budgets
     *
     * @param float $minimum
     * @param float $maximum
     * @return array
     */
    private function find(float $minimum, float $maximum): array
    {
        $records = [];

        $hotels = Redis::getRedis()->lrange('hotels', 0, -1);

        foreach ($hotels as $hotel){
            $data = json_decode($hotel);

            if($data->room_price >= $minimum && $data->room_price <= $maximum && $data->available){
                $records[] = $data;
            }
        }

        return $records;
    }

    /**
     * Filters the hotels based on the logic below
     * All room options must be adjacent (and on the same floor) if the number of rooms is more than one.
     * All room options should be returned within the minimum and maximum budget inclusive.
     * Only rooms that are AVAILABLE should be returned.
     *
     * @param array $hotels
     * @return array
     */
    private function filter(array $hotels): array
    {
        $filteredHotels = [];

        for($i = 0; $i < count($hotels) -1; $i++){
            if(
                ($hotels[$i]->room_number) + 1 === $hotels[$i +1]->room_number &&
                $hotels[$i]->floor === $hotels[$i +1]->floor &&
                $hotels[$i]->hotel_name === $hotels[$i +1]->hotel_name
            ){
                $filteredHotels[] = $hotels[$i];
                $filteredHotels[] = $hotels[$i + 1];
            }
        }

        return $filteredHotels;
    }
}
