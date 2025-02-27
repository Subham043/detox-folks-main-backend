<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Exports\PromoterReportDataExport;
use App\Modules\Promoter\Exports\PromoterReportExport;
use App\Modules\Promoter\Requests\PromoterReportRequest;
use App\Modules\Promoter\Services\PromoterReportService;
use Maatwebsite\Excel\Facades\Excel;

class PromoterReportController extends Controller
{
    public function __construct(private PromoterReportService $service){}

    public function report(){
        $data = $this->service->reportPaginate();
        return view('admin.pages.promoter.report.list', compact(['data']));
    }

    public function list(){
        $data = $this->service->paginate();
        return view('admin.pages.promoter.report.paginate', compact(['data']))
        ->with('search', request()->query('filter')['search'] ?? '');
    }

    public function list_excel(){
        $data = $this->service->reportExport();
        return Excel::download(new PromoterReportExport($data), 'promoter_report.xlsx');
    }

    public function excel(){
        $data = $this->service->export();
        return Excel::download(new PromoterReportDataExport($data), 'promoter_report_data.xlsx');
    }

    public function create(){
        return view('admin.pages.promoter.report.create');
    }

    public function store(PromoterReportRequest $request){
        try {
            //code...
            $this->service->create($request->validated());
            return response()->json([
                'message' => "Report created successfully.",
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }
    }

    public function edit($id){
        $data = $this->service->getById($id);
        return view('admin.pages.promoter.report.update', compact(['data']));
    }

    public function update(PromoterReportRequest $request, $id){
        $data = $this->service->getById($id);
        try {
            //code...
            $this->service->update($data, $request->validated());
            return response()->json([
                'message' => "Report updated successfully.",
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }
    }

    public function delete($id){
        $data = $this->service->getById($id);
        try {
            $this->service->delete($data);
            return redirect()->back()->with('success_status', 'Report deleted successfully.');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }
}
