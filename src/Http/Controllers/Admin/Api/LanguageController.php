<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Api;

use Akkurate\LaravelCore\Models\Language;
use Exception;
use Illuminate\Http\Response;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Akkurate\LaravelCore\Http\Resources\Admin\Language as LanguageResource;
use Akkurate\LaravelCore\Http\Resources\Admin\LanguageCollection;
use Akkurate\LaravelCore\Http\Requests\Admin\Language\CreateLanguageRequest;
use Akkurate\LaravelCore\Http\Requests\Admin\Language\UpdateLanguageRequest;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return LanguageCollection
     *
     */
    public function index($uuid)
    {
        return new LanguageCollection(QueryBuilder::for(Language::class)
            ->allowedFilters(['locale', 'locale_php'])
            ->allowedSorts(['locale', 'locale_php'])
            ->allowedIncludes(['users'])
            ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateLanguageRequest $request
     * @return Response
     */
    public function store(CreateLanguageRequest $request)
    {
        $Language = Language::create($request->validated());
        return response()->json($Language, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Language $language
     * @return LanguageResource
     */
    public function show($uuid, Language $language)
    {
        return new LanguageResource($language);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLanguageRequest $request
     * @param  Language $language
     * @return LanguageResource
     */
    public function update($uuid, UpdateLanguageRequest $request, Language $language)
    {
        $language->update($request->validated());

        return new LanguageResource($language);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Language $language
     * @return Response
     * @throws Exception
     */
    public function destroy($uuid, Language $language)
    {
        $language->delete();
        return response()->json(null, 204);
    }
}
