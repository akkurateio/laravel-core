<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Api;

use Akkurate\LaravelCore\Http\Requests\Admin\Country\CreateCountryRequest;
use Akkurate\LaravelCore\Http\Requests\Admin\Country\UpdateCountryRequest;
use Akkurate\LaravelCore\Http\Resources\Admin\CountryCollection;
use Akkurate\LaravelCore\Http\Resources\Admin\Country as CountryResource;
use Akkurate\LaravelCore\Models\Country;
use Exception;
use Illuminate\Http\JsonResponse;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return CountryCollection
     *
     */
    public function index()
    {
        return new CountryCollection(QueryBuilder::for(Country::class)
            ->allowedFilters(['name','code'])
            ->allowedSorts(['name','code'])
            ->allowedIncludes(['users'])
            ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCountryRequest $request
     * @return JsonResponse
     */
    public function store(CreateCountryRequest $request)
    {
        $country = Country::create($request->validated());
        return response()->json($country, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Country $country
     * @return CountryResource
     */
    public function show($uuid, Country $country)
    {
        return new CountryResource($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCountryRequest $request
     * @param  Country $country
     * @return CountryResource
     */
    public function update($uuid, Country $country, UpdateCountryRequest $request)
    {
        $country->update($request->validated());
        return new CountryResource($country);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Country $country
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($uuid, Country $country)
    {
        $country->delete();
        return response()->json(null, 204);
    }

}
