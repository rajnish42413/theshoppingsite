<?php
namespace App\Contracts;

interface EnquiryServiceContract {
    public function getList($start,$length);
    public function getInfo($id);
    public function saveInfo($input);
    public function deleteByIds($ids);
}
