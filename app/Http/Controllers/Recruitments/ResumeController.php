<?php

namespace App\Http\Controllers\Recruitments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Common\UploadFileEntry;
use Illuminate\Http\Response;

use View, DB, Storage;
class ResumeController extends Controller
{
	public function index() {
		return View::make('recruitments.resumes.index');		
	}
	public function show($id) {
		$entry = UploadFileEntry::where ( 'id', '=', $id )->firstOrFail ();
		if(Storage::disk('local')->exists('cv/'. $entry->filename)){
			$file = Storage::disk ( 'local' )->get ('cv/'. $entry->filename );
			return (new Response ( $file, 200 ))->header ( 'Content-Type', $entry->mime );
		}
	}
	public function download($id){
		$entry = UploadFileEntry::where ( 'id', '=', $id )->firstOrFail ();
		if(Storage::disk('local')->exists('cv/'. $entry->filename)){
			return response()->download(storage_path('app').'/cv/'. $entry->filename);
		}
	}
	public function destroy($id){
		$deleteResumeFileEntry = UploadFileEntry::find($id);
		$deleteResumeFilename = $deleteResumeFileEntry->filename;
		if(Storage::disk('local')->exists('cv/'.$deleteResumeFilename)){
			Storage::disk('local')->delete('cv/'.$deleteResumeFilename);
			$deleteResumeFileEntry->delete();
		}
		return redirect()->route('recruitments.resumes.index' );
	}
	public function getResumesInfo(Request $request){	
		/*
		 * Paging
		 */
		$limit =  0;
		$skip  =  0;
		if ( $request->has('start')  &&  $request->has('length') )
		{
			$limit = intval($request->input('length'));
			$skip  = intval($request->input('start'));
		}
		
		/*
		 * Count the records Total & set the initial value for recordsFiltered
		 */
		$recordTotals = $jobs = DB::table('tblUploadFiles')->where('category','=', '2')->count();
		$recordsFiltered = 	$recordTotals;
		
		$candidates = null;
		if($request->has('search.value')){
			$keyword = trim($request->input('search.value'));
			if($keyword != ""){
				$keyword = '%'.$keyword.'%';
				$candidates = DB::select('
								SELECT tblCandidates.*, tblUploadFiles.filename, tblUploadFiles.mime
								FROM tblCandidates 
								INNER JOIN tblUploadFiles 
								ON tblCandidates.resume_upload_id = tblUploadFiles.id
								WHERE tblUploadFiles.category = 2 AND
								(								
								        tblCandidates.first_name  LIKE :keyword_1 OR
										tblCandidates.middle_name LIKE :keyword_2 OR
										tblCandidates.last_name   LIKE :keyword_3
								)
								LIMIT :skip, :take
						', ['keyword_1'=>$keyword, 'keyword_2'=>$keyword, 'keyword_3'=>$keyword, 'skip'=>$skip, 'take'=>$limit]);
				$recordsFiltered= count($jobs);
			}
		}else{
			$candidates = DB::table('tblCandidates')
						->join('tblUploadFiles','tblCandidates.resume_upload_id', '=', 'tblUploadFiles.id')
						->where('tblUploadFiles.category','=','2')
						->select(
							'tblCandidates.*',
							'tblUploadFiles.filename',
							'tblUploadFiles.mime'						
						)
						->skip($skip)
						->take($limit)
						->get();
		}
		$ret = array("draw"=> $request->input('draw'),"recordsTotal"=>$recordTotals, "recordsFiltered"=> $recordsFiltered,'data'=>array());
		$i = 0;
		
		$dlg_delete_confirm_title = trans('labels.recruitments.resumes.messages.dlg_delete_confirm_title');
		$dlg_delete_confirm_msg   = trans('labels.recruitments.resumes.messages.dlg_delete_confirm_msg');
		
		
		foreach($candidates as $candidate){
			$skills = DB::table('tblCandidate_Skills')
							->join('tblSkills','tblCandidate_Skills.skill_id','=','tblSkills.id')
							->where('tblCandidate_Skills.candidate_id','=',$candidate->id)
							->select('tblCandidate_Skills.id AS id', 'tblSkills.name AS name','tblSkills.description AS display' )
							->get();
			$strSkill="";
			foreach($skills as $skill){
				$strSkill.='<span class="badge bg-'.$skill->display.'">'.$skill->name.'</span>';
			}
			
			$i+=1;
			$jobInfo = array(
					$i,
					$candidate->first_name.' '.$candidate->middle_name.' '.$candidate->last_name,
					$candidate->email,
					$strSkill,
					$candidate->mime,
					'
						<div class="text-center">
                			<a class="btn btn-social-icon btn-tumblr" href="'. route('recruitments.resumes.download',['resumes'=>$candidate->resume_upload_id]).'"><i class="fa fa-download"></i></a>
              				<a class="btn btn-social-icon btn-twitter" target="_blank" href="'. route('recruitments.resumes.show',['resumes'=>$candidate->resume_upload_id]).'"><i class="fa fa-eye"></i></a>
                			<a class="btn btn-social-icon btn-danger"
								data-toggle="modal" data-target="#confirmDelete" 
								data-title="'.$dlg_delete_confirm_title .'" '.
								'data-message="'.$dlg_delete_confirm_msg.'"'.
								'data-url="' .route('recruitments.resumes.destroy',['resume'=>$candidate->resume_upload_id]).'"'.
						'>
							<i class="fa fa-eraser"></i></a>
             		 	</div>'
			);
			array_push($ret['data'], $jobInfo);
		}
		return json_encode($ret);
	}
}
