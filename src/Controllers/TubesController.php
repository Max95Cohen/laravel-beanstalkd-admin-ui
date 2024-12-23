<?php declare(strict_types=1);

namespace Dionera\BeanstalkdUI\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Pheanstalk\Contract\PheanstalkInterface;
use Dionera\BeanstalkdUI\Repositories\JobRepository;

class TubesController extends Controller
{
    private PheanstalkInterface $pheanstalk;
    private JobRepository $jobs;

    public function __construct(PheanstalkInterface $pheanstalk, JobRepository $jobs)
    {
        $this->pheanstalk = $pheanstalk;
        $this->jobs = $jobs;
    }

    public function index(): View
    {
        $tubes = [];

        return view('beanstalkdui::tubes.index', compact('tubes'));
    }

    public function api(): JsonResponse
    {
        $tubeNames = collect($this->pheanstalk->listTubes());

        $tubeNames = $tubeNames->filter(function ($tube) {
            return $tube != 'default';
        })->sort();

        // Adam Wathan give me your strength!
        $tubes = collect($tubeNames)->map(function ($tube) {
            return collect($this->pheanstalk->statsTube($tube))->slice(1)->all();
        })->zip($tubeNames)->flatMap(function ($pair) {
            return [array_merge($pair[0], ['name' => $pair[1]])];
        });

        return response()->json(['tubes' => $tubes]);
    }

    public function showTube(string $tube)
    {
        try {
            $stats = $this->pheanstalk->statsTube($tube);
        } catch (\Exception $e) {
            return abort(404);
        }

        $nextReady = $this->jobs->nextReady($tube, true);
        $nextBuried = $this->jobs->nextBuried($tube);
        $nextDelayed = $this->jobs->nextDelayed($tube, true);
        $prefix = config('beanstalkdui.prefix');

        return view('beanstalkdui::tubes.show', compact(
            'nextReady',
            'nextBuried',
            'nextDelayed',
            'stats',
            'tube',
            'prefix'
        ));
    }
}
