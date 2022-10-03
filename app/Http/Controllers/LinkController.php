<?php

namespace App\Http\Controllers;

use App\Actions\AccessLinkLogAction;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{
    public function __construct(
        private LinkRepository $processLink,
        private AccessLinkLogAction $accessLog,
    ){
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $links = Link::all();

        return view('link.index', [
            'links' => $links
        ]);
    }

    /**
     * Register log when user visit a link
     * Redirect user vers origin link
     *
     * @param Link $link
     * @return RedirectResponse
     */
    public function show(Link $link): RedirectResponse
    {
        $this->accessLog->handle($link);

        return redirect()->away($link->origin_link);
    }

    /**
     * @param LinkRequest $request
     * @return void
     */
    public function store(LinkRequest $request)
    {
        $this->processLink->store($request->all());

        return back()->with('message', __('response.link_shorted_successfully'));
    }

    /**
     * @param Link $link
     * @return void
     */
    public function destroy(Link $link)
    {
        if (!Gate::allows('delete_links', $link)) {
            abort(403);
        }

        $link->delete();

        return back()->with('message', __('response.link_deleted_successfully'));
    }
}
