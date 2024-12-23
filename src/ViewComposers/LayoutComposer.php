<?php

namespace Dionera\BeanstalkdUI\ViewComposers;

use Illuminate\View\View;
use Pheanstalk\Contract\PheanstalkInterface;

class LayoutComposer
{
    private PheanstalkInterface $pheanstalk;

    public function __construct(PheanstalkInterface $pheanstalk)
    {
        $this->pheanstalk = $pheanstalk;
    }

    public function compose(View $view): void
    {
        $tubes = collect($this->pheanstalk->listTubes())
            ->filter(function ($tube) {
                return $tube != 'default';
            })->sort();

        $view->with('tubes', $tubes);
    }
}
