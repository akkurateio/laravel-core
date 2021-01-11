<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Illuminate\View\View;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Kris\LaravelFormBuilder\FormBuilder;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Forms\Admin\Language\LanguageCreateForm;
use Akkurate\LaravelCore\Forms\Admin\Language\LanguageUpdateForm;
use Akkurate\LaravelCore\Http\Requests\Admin\Language\CreateLanguageRequest;
use Akkurate\LaravelCore\Http\Requests\Admin\Language\UpdateLanguageRequest;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     * @return View
     */
    public function index($uuid)
    {
        $languages = Language::orderBy('created_at', 'desc')->paginate();
        // Just a trick to display a table with all the fields of the model
        $language = $languages->first();
        // Avoid breaking if there are no entries
        if ($language) {
            $columns = array_keys($language->toArray());
        } else {
            $columns = [];
        }
        return view('admin::back.languages.index', compact('languages', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $uuid
     * @param  FormBuilder $formBuilder
     * @return View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(LanguageCreateForm::class, [
            'method' => 'POST',
            'url' => route('brain.admin.languages.store', ['uuid' => $uuid]),
            'id' => 'languageForm'
        ]);
        return view('admin::back.languages.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     * @param  CreateLanguageRequest $request
     * @return RedirectResponse
     */
    public function store($uuid, CreateLanguageRequest $request)
    {
        Language::create($request->validated());
        return redirect()->route('brain.admin.languages.index', ['uuid' => $uuid])
            ->withSuccess(trans('Langue').' '.trans('créée avec succès'));
    }

    public function show($uuid, $languageId)
    {
        $language = Language::where('id', $languageId)->first();
        return redirect()->route('brain.admin.languages.edit', ['language' => $language, 'uuid' => $uuid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param FormBuilder $formBuilder
     * @param $languageId
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder, $languageId)
    {
        $language = Language::where('id', $languageId)->first();
        $form = $formBuilder->create(LanguageUpdateForm::class, [
            'method' => 'PUT',
            'url' => route('brain.admin.languages.update', ['language' => $language, 'uuid' => $uuid]),
            'id' => 'languageForm',
            'model' => $language
        ]);
        return view('admin::back.languages.edit', compact('language', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param  UpdateLanguageRequest $request
     * @param  Language $language
     * @return RedirectResponse
     */
    public function update($uuid, UpdateLanguageRequest $request, Language $language)
    {
        $language->update(array_merge($request->validated(), ['is_active' => $request->filled('is_active')]));
        return redirect()->route('brain.admin.languages.index', ['uuid' => $uuid])
            ->withSuccess(trans('Langue').' '.trans('mise à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     * @param $languageId
     * @return RedirectResponse
     */
    public function destroy($uuid, $languageId)
    {
        $language = Language::where('id', $languageId)->first();
        $language->delete();
        return redirect()->route('brain.admin.languages.index', ['uuid' => $uuid])
            ->withSuccess(trans('Langue').' '.trans('supprimée avec succès'));
    }

    public function toggle($uuid, Language $language)
    {
        $language->update([
            'is_active' => !$language->is_active
        ]);
        return back();
    }
}
