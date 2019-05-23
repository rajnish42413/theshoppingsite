<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
        protected function getDTsearch($req){
        $srch = array();
        if($req->columns){
            foreach($req->columns as $k => $val){
              if($val['search']['value']!=""){
                $srch[$val['data']] = $val['search']['value'];
              }
            }
        }
        return $srch;
    }
    protected function getDTsort($req){
        $order[0] = 'created_at';
        $order[1] = 'desc';
        if($req->order[0]['dir'] != ""){
            $order[0] = $req->columns[$req->order[0]['column']]['data'];
            $order[1] = $req->order[0]['dir'];
        }
        return $order;
    }
    protected function getDTpage($req){
        $length = $req->length > 0 ? $req->length : 100;
        $start = $req->start > 0 ? $req->start : 0;
        $currPage = ($start / $length) + 1;
        \Illuminate\Pagination\Paginator::currentPageResolver(function() use ($currPage) { return $currPage; });
        return array($length,$currPage);
    }


    protected function buildNestedArr($data,$id_col,$pid_col,$title_col){
        $result = [];
        foreach($data as $k => $v){
            $this->arrListName[$v->$id_col] = $v->$title_col;
            if($v->$pid_col == 0){
                $arr[$v->$id_col] = $this->nestedArr($v,$data,$id_col,$pid_col);
            }
        }
        $result['arrListSorted'] = $arr;
        $result['arrListName'] = $this->arrListName;
        return $result;
    }

    protected function nestedArr($m,$data,$id_col,$pid_col){
        $noChild = true;
        foreach($data as $k => $v){
            if($m->$id_col == $v->$pid_col){
                $arr[$v->$id_col] = $this->nestedArr($v,$data,$id_col,$pid_col);
                $noChild = false;
            }
        }
        if($noChild == true){
            return null;
        }
        else{
            return $arr;
        }
    }

    protected function responseDTJson($draw,$recTotal, $recFilter, $data){
        return Response::json(['draw'=>$draw,'recordsTotal'=>$recTotal, 'recordsFiltered'=>$recFilter, 'data'=>$data])->header('Access-Control-Allow-Origin',"*");
    }	
}
