<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Exception;
use Illuminate\View\View;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Kris\LaravelFormBuilder\FormBuilder;
use Akkurate\LaravelCore\Models\Country;
use Akkurate\LaravelCore\Forms\Admin\Country\CountryCreateForm;
use Akkurate\LaravelCore\Forms\Admin\Country\CountryUpdateForm;
use Akkurate\LaravelCore\Http\Requests\Admin\Country\CreateCountryRequest;
use Akkurate\LaravelCore\Http\Requests\Admin\Country\UpdateCountryRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $countries = Country::orderBy('created_at', 'desc')->paginate();
        // Just a trick to display a table with all the fields of the model
        $country = $countries->first();
        // Avoid breaking if there are no entries
        if ($country) {
            $columns = array_keys($country->toArray());
        } else {
            $columns = [];
        }
        return view('admin::back.countries.index', compact('countries', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $uuid
     * @param  FormBuilder $formBuilder
     * @return View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CountryCreateForm::class, [
            'method' => 'POST',
            'url' => route('brain.admin.countries.store', ['uuid', $uuid]),
            'id' => 'countryForm'
        ]);
        return view('admin::back.countries.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     * @param  CreateCountryRequest $request
     * @return RedirectResponse
     */
    public function store($uuid, CreateCountryRequest $request)
    {
        Country::create($request->validated());
        return redirect()->route('brain.admin.countries.index', ['uuid' => $uuid])
            ->withSuccess(trans('Pays').' '.trans('créé avec succès'));
    }


    public function show($uuid, $countryId)
    {
        $country = Country::where('id', $countryId)->first();
        return redirect()->route('brain.admin.countries.edit', ['country' => $country, 'uuid' => $uuid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param FormBuilder $formBuilder
     * @param $countryId
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder, $countryId)
    {
        $country = Country::where('id', $countryId)->first();
        $form = $formBuilder->create(CountryUpdateForm::class, [
            'method' => 'PUT',
            'url' => route('brain.admin.countries.update', ['country' => $country, 'uuid' => $uuid]),
            'id' => 'countryForm',
            'model' => $country
        ]);
        return view('admin::back.countries.edit', compact('country', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param  UpdateCountryRequest $request
     * @param  Country $country
     * @return RedirectResponse
     */
    public function update($uuid, UpdateCountryRequest $request, Country $country)
    {
        $country->update(array_merge($request->validated(), ['is_active' => $request->filled('is_active')]));
        return redirect()->route('brain.admin.countries.index', ['uuid' => $uuid])
            ->withSuccess(trans('Pays').' '.trans('mis à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     * @param  Country $country
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($uuid, $countryId)
    {
        $country = Country::where('id', $countryId)->first();
        $country->delete();
        return redirect()->route('brain.admin.countries.index', ['uuid' => $uuid])
            ->withSuccess(trans('Pays').' '.trans('supprimé avec succès'));
    }

    public function toggle($uuid, Country $country)
    {
        $country->update([
            'is_active' => !$country->is_active
        ]);
        return back();
    }

}
