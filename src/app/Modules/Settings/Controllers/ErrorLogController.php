<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

//code taken from laravel log viewer
class ErrorLogController extends Controller
{
    private $laravelLogViewer;

    public function __construct(LaravelLogViewer $laravelLogViewer)
    {
        $this->middleware('permission:view application error logs', ['only' => ['get']]);
        $this->laravelLogViewer = $laravelLogViewer;
    }

    public function get(Request $request){
        $folderFiles = [];
        if ($request->input('f')) {
            $this->laravelLogViewer->setFolder(Crypt::decrypt($request->input('f')));
            $folderFiles = $this->laravelLogViewer->getFolderFiles(true);
        }
        if ($request->input('l')) {
            $this->laravelLogViewer->setFile(Crypt::decrypt($request->input('l')));
        }

        if ($early_return = $this->earlyReturn($request)) {
            return $early_return;
        }

        $data = [
            'logs' => $this->laravelLogViewer->all(),
            'folders' => $this->laravelLogViewer->getFolders(),
            'current_folder' => $this->laravelLogViewer->getFolderName(),
            'folder_files' => $folderFiles,
            'files' => $this->laravelLogViewer->getFiles(true),
            'current_file' => $this->laravelLogViewer->getFileName(),
            'standardFormat' => true,
            'structure' => $this->laravelLogViewer->foldersAndFiles(),
            'storage_path' => $this->laravelLogViewer->getStoragePath(),
        ];

        if ($request->wantsJson()) {
            return $data;
        }

        if (is_array($data['logs']) && count($data['logs']) > 0) {
            $firstLog = reset($data['logs']);
            if ($firstLog) {
                if (!$firstLog['context'] && !$firstLog['level']) {
                    $data['standardFormat'] = false;
                }
            }
        }

        return view('admin.pages.setting.error_log')->with([...$data]);

    }

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    private function earlyReturn(Request $request)
    {
        if ($request->input('f')) {
            $this->laravelLogViewer->setFolder(Crypt::decrypt($request->input('f')));
        }

        if ($request->input('dl')) {
            return $this->download($this->pathFromInput($request, 'dl'));
        } elseif ($request->has('clean')) {
            app('files')->put($this->pathFromInput($request, 'clean'), '');
            return redirect(url()->previous());
        } elseif ($request->has('del')) {
            app('files')->delete($this->pathFromInput($request, 'del'));
            return redirect($request->url());
        } elseif ($request->has('delall')) {
            $files = ($this->laravelLogViewer->getFolderName())
                        ? $this->laravelLogViewer->getFolderFiles(true)
                        : $this->laravelLogViewer->getFiles(true);
            foreach ($files as $file) {
                app('files')->delete($this->laravelLogViewer->pathToLogFile($file));
            }
            return redirect($request->url());
        }
        return false;
    }

    /**
     * @param string $input_string
     * @return string
     * @throws \Exception
     */
    private function pathFromInput(Request $request, $input_string)
    {
        return $this->laravelLogViewer->pathToLogFile(Crypt::decrypt($request->input($input_string)));
    }

    /**
     * @param string $data
     * @return mixed
     */
    private function download($data)
    {
        if (function_exists('response')) {
            return response()->download($data);
        }

        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }
}
