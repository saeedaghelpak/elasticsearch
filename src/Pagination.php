<?php

namespace Basemkhirat\Elasticsearch;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\HtmlString;

class Pagination extends LengthAwarePaginator
{

    /**
     * Render the paginator using the given view.
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    public function links($view = "default", $data = [])
    {
        extract($data);

        $paginator = $this;

        $elements = $this->elements();

        return new HtmlString(
            static::viewFactory()->make($view ?: 'default', array_merge($data, [
                'paginator' => $this,
                'elements' => $this->elements(),
            ]))->render()
        );

//        require dirname(__FILE__) . "/pagination/" . $view . ".php";
    }


    /**
     * Get the array of elements to pass to the view.
     * @return array
     */
    protected function elements()
    {

        $window = UrlWindow::make($this);

        return array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }

    /**
     * Determine if the paginator is on the first page.
     * @return bool
     */
    public function onFirstPage()
    {
        return $this->currentPage() <= 1;
    }
}
