<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class DPDService
{
    /**
     * @var \App\Models\City
     */
    private City $cityRepository;

    public function __construct(City $city)
    {
        $this->cityRepository = $city;
    }

    /**
     * Query Cities.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function queryCities(array $data): Collection
    {
        $query = trim((string) ($data['query'] ?? ''));
        $searchTerms = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $tsQuery = implode(' & ', array_map(static fn(string $term) => $term . ':*', $searchTerms));

        return $this->cityRepository::query()
            ->where('country_id', '=', $data['country_id'])
            ->whereRaw("to_tsvector('russian', name) @@ to_tsquery('russian', ?)", [$tsQuery])
            ->with('terminals')
            ->get();
    }

    public function getCityById(int $id): ?\App\Models\City
    {
        return $this->cityRepository::query()
            ->with('terminals')
            ->find($id);
    }

    public function getCityByDpdCityId(string $dpdCityId): ?\App\Models\City
    {
        return $this->cityRepository::query()
            ->with('terminals')
            ->where('city_id', '=', $dpdCityId)
            ->first();
    }
}
