<?php

namespace Polyloans\Filter\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Polyloans\Filter\Commands\CreateFilter\CreateFilterCommand;
use Polyloans\Filter\Commands\DeleteFilter\DeleteFilterCommand;
use Polyloans\Filter\DomainQueries\PredefinedFilterHandler;
use Polyloans\Filter\Requests\SaveFilterRequest;
use Polyloans\Filter\Responses\HtmlFilterResponse;
use Polyloans\Filter\Responses\JsonFilterResponse;
use Polyloans\Filter\Validators\FilterValidator;

class StoreFilterController extends BaseController
{
    /**
     * @var PredefinedFilterHandler
     */
    protected $predefinedFilterHandler;

    public function __construct(PredefinedFilterHandler $predefinedFilterHandler)
    {
        $this->predefinedFilterHandler = $predefinedFilterHandler;
    }

    /**
     * Creates new predefined filter.
     *
     * @param SaveFilterRequest $request
     *
     * @return string success or error message
     */
    public function store(SaveFilterRequest $request): string
    {
        $data = $request->input('filter_data');
        $key = $request->input('filter_key');
        $name = $request->input('filter_name');
        $url = $request->input('filter_url');

        $validator = new FilterValidator();
        $validator->validate(json_decode($data));

        if ($validator->isValid()) {
            event(
                new CreateFilterCommand(
                    $name,
                    $url,
                    $key,
                    Auth::user()->id,
                    $data
                )
            );
        }

        return json_encode($validator->errors());
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getTabs(Request $request): string
    {
        $filters = $this->predefinedFilterHandler->getFilters($request->input('url'));
        $response = new HtmlFilterResponse($filters, $request->input('url'));

        return $response->makeResponse();
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     */
    public function delete(Request $request): void
    {
        event(new DeleteFilterCommand($request->id));
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getJsonTabs(Request $request): string
    {
        $filters = $this->predefinedFilterHandler->getFilters($request->input('url'));
        $response = new JsonFilterResponse($filters);

        return $response->makeResponse();
    }
}
